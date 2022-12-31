<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Export;

use DeathSatan\SatanExcel\Export\Config\ArrayExportConfig;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\BaseWriter;

/**
 * 数组导出为文件.
 */
class ArrayExport implements BaseExport
{
    private Spreadsheet $spreadsheet;
    private ArrayExportConfig $config;

    public function __construct(ArrayExportConfig $config)
    {
        $this->config = $config;
        $this->spreadsheet = new Spreadsheet();
    }

    public function getSpreadsheet(): Spreadsheet
    {
        return $this->spreadsheet;
    }

    public function getConfig(): ArrayExportConfig
    {
        return $this->config;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->getConfig()->getData();
    }

    /**
     * {@inheritDoc}
     */
    public function save(): \SplFileObject
    {
        $config = $this->getConfig();
        $spreadsheet = $this->getSpreadsheet();
        // 设置活动sheet
        $workSheet = $spreadsheet->getActiveSheet();
        $this->formatSheet($workSheet, $config);
        $saving = $config->getEvent(ArrayExportConfig::EVENT_SAVING);
        // 保存前回调
        foreach ($saving as $saving_callback) {
            call_user_func($saving_callback, $spreadsheet);
        }
        $writer = $config->getFileType();
        if (! class_exists($writer)) {
            throw new \RuntimeException('文件类型不是有效类:' . $writer);
        }
        $writer = new $writer($spreadsheet);
        if ($writer instanceof BaseWriter) {
            $temp = sys_get_temp_dir();
            // 随机文件名
            $filename = uniqid('satan-excel');
            $filepath = $temp . DIRECTORY_SEPARATOR . $filename . '.tmp';
            $writer->save($filepath);
            return new \SplFileObject($filepath);
        }
        throw new \RuntimeException('文件类型不是有效类:' . $writer);
    }

    private function formatSheet(Worksheet $worksheet, ArrayExportConfig $config)
    {
        $data = $config->getData();
        // 是否分批处理、避免内存过大。
        if ($config->isYield() || ($config->isAutoYield() && count($data) > 1000)) {
            $data = $this->arrayToYield($data);
        }
        $startLine = $config->getStartLine();
        $firstData = $config->getFirstFields();
        $call_cell_back = function (Cell $cell, array $raw) use ($config) {
            $cell_back = $config->getEvent(ArrayExportConfig::EVENT_CELL_FORMAT);
            foreach ($cell_back as $closure) {
                call_user_func($closure, $cell, $raw);
            }
        };
        if ($firstData !== null) {
            $firstValues = array_values($firstData);
            foreach ($firstValues as $first_i => $value) {
                $cell = $worksheet->getCell([$first_i + 1, $startLine]);
                $cell->setValue($value);
                $call_cell_back($cell, $firstValues);
            }
            ++$startLine;
        }
        unset($value);
        foreach ($data as $val) {
            $values = array_values($val);
            foreach ($values as $data_i => $value) {
                $cell = $worksheet->getCell([$data_i + 1, $startLine]);
                $cell->setValue($value);
                $call_cell_back($cell, $values);
            }
            ++$startLine;
        }
    }

    private function arrayToYield(array $data): \Generator
    {
        foreach ($data as $val) {
            yield $val;
        }
    }
}
