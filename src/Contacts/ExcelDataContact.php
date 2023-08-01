<?php

namespace DeathSatan\SatanExcel\Contacts;

interface ExcelDataContact
{
    /**
     * @param string $sheetName Sheet名称 默认Sheet1
     * @param int $sheetIndex Sheet索引 默认0
     */
    public function __construct(string $sheetName = 'Sheet1',int $sheetIndex = 0);

    public function getSheetName(): string;

    public function getSheetIndex(): int;
}