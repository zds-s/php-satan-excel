<?php

namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\Config;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Vtiful\Kernel\Format;

interface ReaderContext
{

    public function __construct(mixed $rawValue,int $rowIndex,int $columnIndex,Config $config);

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

    /**
     * 获取当前单元值
     * 驱动为 xls-writer 时则为混合类型
     * 驱动为 php-office 时则为Cell类实例
     * @return string|Cell
     */
    public function getValue(): mixed;

    /**
     * 当前行数
     * @return int
     */
    public function getRowIndex(): int;

    /**
     * 当前列数
     * @return int
     */
    public function getColumnIndex(): int;
}