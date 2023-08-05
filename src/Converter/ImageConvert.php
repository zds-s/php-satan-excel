<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Converter;

use DeathSatan\SatanExcel\Contacts\ReaderContext;
use DeathSatan\SatanExcel\Contacts\WriterContext;
use DeathSatan\SatanExcel\WriteCellData;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Address;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Vtiful\Kernel\Excel;

class ImageConvert implements \DeathSatan\SatanExcel\Contacts\ConverterContact
{
    /**
     * {@inheritDoc}
     */
    public function supportExcelTypeKey()
    {
        if ($this->isPhpOffice()) {
            return DataType::TYPE_STRING;
        }
        if ($this->isXlsWriter()) {
            return Excel::TYPE_STRING;
        }
        throw new \RuntimeException('not found handler');
    }

    /**
     * {@inheritDoc}
     */
    public function convertToData(ReaderContext $readerContext): string
    {
        return $readerContext->getValue();
    }

    /**
     * {@inheritDoc}
     */
    public function convertToExcelData(WriterContext $writerContext): WriteCellData
    {
        if ($writerContext->isPhpOffice()) {
            $cell = $writerContext->getCell();
            $drawing = new Drawing();
            $drawing->setPath($writerContext->getValue());
            $drawing->setCoordinates(Address::cell($writerContext->getRowIndex(),$writerContext->getColumnIndex()));
            $cell->getParent()->getParent()->getDrawingCollection()->append($drawing);
        }
        if ($writerContext->isXlsWriter()){

        }
        return new WriteCellData('');
    }
}
