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
use DeathSatan\SatanExcel\Traits\ConverterTrait;
use DeathSatan\SatanExcel\WriteCellData;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Vtiful\Kernel\Excel;

class StringConverter implements \DeathSatan\SatanExcel\Contacts\ConverterContact
{
    use ConverterTrait;

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
        return str_replace("\t", '', $readerContext->getValue()) ?? '';
    }

    /**
     * {@inheritDoc}
     */
    public function convertToExcelData(WriterContext $writerContext): WriteCellData
    {
        return new WriteCellData($writerContext->getValue() . "\t");
    }
}
