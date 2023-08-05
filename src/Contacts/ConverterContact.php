<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\WriteCellData;

/**
 * 自定义读写转换器契约.
 */
interface ConverterContact
{
    /**
     * 指定当前属性在excel文档中的单元格格式.
     */
    public function supportExcelTypeKey();

    /**
     * 读取转换.
     * @param ReaderContext $context
     */
    public function convertToData(ReaderContext $readerContext): string;

    /**
     * 写入转换.
     */
    public function convertToExcelData(WriterContext $writerContext): WriteCellData;
}
