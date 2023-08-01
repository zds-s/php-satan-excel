<?php

namespace DeathSatan\SatanExcel\Annotation;


use DeathSatan\SatanExcel\Contacts\ExcelDataContact;

/**
 * 标明在Excel类上面
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class ExcelData implements ExcelDataContact
{
    /**
     * @param string $sheetName Sheet名称 默认Sheet1
     * @param int $sheetIndex Sheet索引 默认0
     */
    public function __construct(public string $sheetName = 'Sheet1',public int $sheetIndex = 0){}

    public function getSheetIndex(): int
    {
        return $this->sheetIndex;
    }

    public function getSheetName(): string
    {
        return $this->sheetName;
    }

}