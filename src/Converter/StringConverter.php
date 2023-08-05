<?php

namespace DeathSatan\SatanExcel\Converter;

use DeathSatan\SatanExcel\Contacts\ReaderContext;
use DeathSatan\SatanExcel\Contacts\WriterContext;
use DeathSatan\SatanExcel\Traits\ConverterTrait;
use DeathSatan\SatanExcel\WriteCellData;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Vtiful\Kernel\Excel;
use Vtiful\Kernel\Format;

class StringConverter implements \DeathSatan\SatanExcel\Contacts\ConverterContact
{
    use ConverterTrait;

    /**
     * @inheritDoc
     */
    public function supportExcelTypeKey(): int
    {
        if ($this->isPhpOffice()){
            return DataType::TYPE_STRING;
        }
        if ($this->isXlsWriter()){

            return Excel::TYPE_STRING;
        }
        throw new \RuntimeException('not found handler');
    }

    /**
     * @inheritDoc
     */
    public function convertToData(ReaderContext $readerContext): string
    {
        return str_replace("\t",'',$readerContext->getValue())??'';
    }

    /**
     * @inheritDoc
     */
    public function convertToExcelData(WriterContext $writerContext): WriteCellData
    {
        return new WriteCellData($writerContext->getValue()."\t");
    }
}