<?php

namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\Config;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Vtiful\Kernel\Format;

interface WriterContext
{
    public function __construct(mixed $rawValue,int $rowIndex,int $columnIndex,Config $config);

    /**
     * @return Style|Format
     */
    public function getCellStyle();

    /**
     * 当前行数
     * @return int
     */
    public function getRowIndex(): int;

    public function getColumnIndex(): int;

    /**
     * 当前是否为 xls-writer 驱动
     * @return bool
     */
    public function isXlsWriter():bool;

    /**
     * 当前是否为 php-office 驱动
     * @return bool
     */
    public function isPhpOffice(): bool;

    public function getValue():mixed;
}