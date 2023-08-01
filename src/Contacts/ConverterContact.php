<?php

namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\WriteCellData;

/**
 * 自定义读写转换器契约
 */
interface ConverterContact
{
    /**
     * 指定当前属性在excel文档中的单元格格式
     * @return int
     */
    public function supportExcelTypeKey(): int;

    /**
     * 读取转换
     * @param ReaderContext $context
     * @return string
     */
    public function convertToData(ReaderContext $readerContext): string;

    /**
     * 写入转换
     * @param WriterContext $writerContext
     * @return WriteCellData
     */
    public function convertToExcelData(WriterContext $writerContext): WriteCellData;

}