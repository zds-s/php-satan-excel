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
use PhpOffice\PhpSpreadsheet\Exception;
use Vtiful\Kernel\Excel;
use Vtiful\Kernel\Format;

class XlsWriterHandler implements \DeathSatan\SatanExcel\Contacts\HandlerContact
{
    use HandlerTrait;

    protected ?Excel $driver;

    protected string $path;

    public function __construct(public Config $config)
    {
        $this->init();
    }

    public function init()
    {
        $this->driver = $this->getConfig()->driver[Driver::XLS_WRITER];
    }

    public function openFile(string $path): HandlerContact
    {
        $this->path = $path;
        return $this;
    }

    public function getRawData(): array
    {
        if ($this->driver === null) {
            $pathinfo = pathinfo($this->path);
            $this->driver = new Excel(['path' => $pathinfo['dirname']]);
            $filePath = $pathinfo['basename'];
        } else {
            $filePath = $this->path;
        }
        $excel = $this->driver->openFile($filePath);
        $sheetList = $excel->sheetList();
        $data = [];
        $excelClass = $this->getExcelClassData();

        foreach ($this->getExcelData() as $excelDataIndex => $excelDataList) {
            foreach ($excelDataList as $excelData) {
                $sheetName = null;
                /** @var ExcelDataContact $excelData */
                if (in_array($excelData->getSheetName(), $sheetList)) {
                    $sheetName = $excelData->getSheetName();
                } else {
                    $sheetName = $sheetList[$excelData->getSheetIndex()];
                }
                $data[$excelData->getSheetIndex()] = [];
                $data[$excelData->getSheetIndex()]['sheetName'] = $excelData->getSheetName();

                $sheetWorker = $excel->openSheet($sheetName)->setSkipRows($this->getStartRow());
                $sheetData = $sheetWorker->getSheetData();
                $excelProperty = $this->getExcelProperty()[$excelDataIndex];
                $excelPropertyKeys = array_keys($excelProperty);

                foreach ($sheetData as $rowIndex => $sheetDatum) {
                    $excelEntity = new ($this->getExcel()[$excelDataIndex]);
                    $values = array_combine($excelPropertyKeys, $sheetDatum);
                    $columnIndex = 0;
                    $cellData = [];
                    foreach ($values as $key => $val) {
                        /** @var ConverterContact $converter */
                        $converter = new ($excelProperty[$key]->converter)($this->getConfig());
                        $readContext = new ReaderContext($val, $rowIndex, $columnIndex, $this->getConfig());
                        $value = $converter->convertToData($readContext);
                        $attribute = $this->getPropertyAttribute($excelClass[$excelDataIndex], $key);
                        if ($attribute !== false) {
                            if ($attribute instanceof DateFormat) {
                                $formatValue = strtotime($value);
                                if ($formatValue !== false) {
                                    $value = $formatValue;
                                }
                            }
                            if ($attribute instanceof NumberFormat) {
                                $format = $attribute->getValue();
                                $value = sscanf($val, $format);
                            }
                        }
                        if (property_exists($excelEntity, $key)) {
                            $excelEntity->{$key} = $value;
                        }
                        $cellData[$key] = $value;
                        ++$columnIndex;
                    }

                    $this->handleListener($excelEntity, $cellData, 1);
                    $data[$excelData->getSheetIndex()]['sheetData'][] = $excelEntity;
                }
            }
        }
        $this->handleListener($excelEntity, $cellData, 2);
        return $data;
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function save(): \SplFileInfo
    {
        $data = $this->getData();
        $excelData = $this->getExcelData();
        $excel = $this->getExcel();
        $excelProperty = $this->getExcelProperty();
        $excelClass = $this->getExcelClassData();

        $tmp = sys_get_temp_dir();
        $filename = uniqid('satanExcel');
        $ext = '.xlsx';
        $filepath = $tmp . DIRECTORY_SEPARATOR . $filename . $ext;
        $excelDirver = (new Excel([
            'path' => $tmp,
        ]));

        foreach ($this->getExcelData() as $listIndex => $excelDataList) {
            foreach ($excelDataList as $index => $excelDataAttribute) {
                /** @var ExcelDataContact $excelDataAttribute */
                /** @var ExcelPropertyContact $excelPropertyAttribute */
                $excelPropertyAttribute = json_decode(json_encode($excelProperty[$listIndex], JSON_UNESCAPED_UNICODE), true);
                $sheet = $excelDirver->fileName($filename . $ext, $excelDataAttribute->getSheetName());
                $activeData = $data[$index];
                $keyTran = [];
                $i = 0;
                foreach ($excelPropertyAttribute as $key => $property) {
                    $sheet->insertText(0, $i, $property['value']);
                    $keyTran[$key] = array_merge($property, ['rowIndex' => $i++]);
                }
                $cellIndex = 0;
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
                        $format = new Format($excelDirver->getHandle());
                        $context = $converter->convertToExcelData(new WriterContext([$value, $format], $keyAttr['rowIndex'], $cellIndex, $this->getConfig(),$sheet));
                        $sheet->insertText($cellIndex, $keyAttr['rowIndex'], $context->getValue(), null, $format->toResource());
                    }
                }
            }
        }
        return new \SplFileInfo($excelDirver->output());
    }
}
