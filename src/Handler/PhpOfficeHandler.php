<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Handler;

use DeathSatan\SatanExcel\Annotation\DateFormat;
use DeathSatan\SatanExcel\Annotation\NumberFormat;
use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Contacts\ConverterContact;
use DeathSatan\SatanExcel\Contacts\ExcelDataContact;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;
use DeathSatan\SatanExcel\Contacts\HandlerContact;
use DeathSatan\SatanExcel\Context\ReaderContext;
use DeathSatan\SatanExcel\Context\WriterContext;
use DeathSatan\SatanExcel\Driver;
use DeathSatan\SatanExcel\Traits\HandlerTrait;
use DeathSatan\SatanExcel\Traits\ModeTrait;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PhpOfficeHandler implements HandlerContact
{
    use ModeTrait;
    use HandlerTrait;

    protected Spreadsheet $driver;

    public function __construct(public Config $config)
    {
        $this->init();
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function openFile(string $path): HandlerContact
    {
        $this->driver = IOFactory::load($path);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getRawData(): array
    {
        $data = [];
        $driver = $this->driver;

        foreach ($this->getExcelData() as $excelDataIndex => $excelDataList) {
            $excelProperty = $this->getExcelProperty()[$excelDataIndex];
            $excelPropertyKeys = array_keys($excelProperty);
            $excelEntity = $this->getExcel()[$excelDataIndex];

            foreach ($excelDataList as $excelData) {
                /** @var ExcelDataContact $excelData */
                /** @var Worksheet $workSheet */
                $sheetList = $driver->getAllSheets();
                foreach ($sheetList as $workSheet) {
                    $rows = $workSheet->getRowIterator($this->getStartRow() + 1);
                    $data[$excelData->getSheetIndex()] = [];
                    $data[$excelData->getSheetIndex()]['sheetName'] = $workSheet->getTitle();
                    foreach ($rows as $row) {
                        $cells = $row->getCellIterator();
                        $cellData = [];
                        $entity = new ($excelEntity);
                        foreach ($cells as $cell) {
                            $columnIndex = ord($cell->getColumn()) - 65;
                            $key = $excelPropertyKeys[$columnIndex];
                            /** @var ConverterContact $converter */
                            $converter = new ($excelProperty[$key]->converter)($this->getConfig());
                            $readContext = new ReaderContext($cell->getValue(), $row->getRowIndex(), $columnIndex, $this->getConfig());
                            $value = $converter->convertToData($readContext);
                            if (property_exists($entity, $key)) {
                                $entity->{$key} = $value;
                            }
                            $cellData[$key] = $value;
                        }
                        $this->handleListener($entity, $cellData, 1);
                        $data[$excelData->getSheetIndex()]['sheetData'][] = $entity;
                    }
                }
            }
        }
        $this->handleListener($entity, $cellData, 2);
        return $data;
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function save(): \SplFileInfo
    {
        $data = $this->getData();
        $spreadSheet = new Spreadsheet();
        $excelProperty = $this->getExcelProperty();
        $excelClass = $this->getExcelClassData();
        foreach ($this->getExcelData() as $listIndex => $excelDataList) {
            foreach ($excelDataList as $index => $excelDataAttribute) {
                /** @var ExcelDataContact $excelDataAttribute */
                /** @var ExcelPropertyContact $excelPropertyAttribute */
                $excelPropertyAttribute = json_decode(json_encode($excelProperty[$listIndex], JSON_UNESCAPED_UNICODE), true);
                $sheet = $spreadSheet->getSheet($index);
                $sheet->setTitle($excelDataAttribute->getSheetName());
                $activeData = $data[$index];
                $keyTran = [];
                $i = 0;
                foreach ($excelPropertyAttribute as $key => $property) {
                    $keyTran[$key] = array_merge($property, ['rowIndex' => ++$i]);
                    $headCell = $sheet->getCell([$i, 1]);
                    $headCell->setValue($property['value']);
                }
                $cellIndex = 1;
                foreach ($activeData as $activeDataIndex => $values) {
                    ++$cellIndex;
                    foreach ($values as $key => $value) {
                        $attribute = $this->getPropertyAttribute($excelClass[$listIndex], $key);
                        if ($attribute !== false) {
                            if ($attribute instanceof DateFormat) {
                                $format = $attribute->getValue();
                                $value = date($format, $value);
                            }
                            if ($attribute instanceof NumberFormat) {
                                $format = $attribute->getValue();
                                $value = sprintf($format, $value);
                            }
                        }
                        $keyAttr = $keyTran[$key];
                        /** @var ConverterContact $converter */
                        $converter = new ($keyAttr['converter'])($this->getConfig());
                        $cell = $sheet->getCell([$keyAttr['rowIndex'], $cellIndex]);
                        $context = $converter->convertToExcelData(new WriterContext([$value, $cell], $keyAttr['rowIndex'], $cellIndex, $this->getConfig()));
                        $cell->setValue($context->getValue());
                    }
                }
            }
        }
        $wirter = IOFactory::createWriter($spreadSheet, IOFactory::WRITER_XLSX);
        $ext = '.xlsx';
        $filename = uniqid('satanExcel');
        $tmpDir = sys_get_temp_dir();
        $filepath = $tmpDir . DIRECTORY_SEPARATOR . $filename . $ext;
        $wirter->save($filepath);
        return new \SplFileInfo($filepath);
    }

    protected function init()
    {
        $this->driver = $this->getConfig()->driver[Driver::PHP_OFFICE] ?? new Spreadsheet();
    }
}
