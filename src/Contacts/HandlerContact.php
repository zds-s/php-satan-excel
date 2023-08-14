<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Lib\ExcelDataResult;

interface HandlerContact
{
    public function __construct(Config $config);

    public function openFile(string $path): self;

    public function setListener(ListenerContact|\Closure|null $listener): static;

    public function getListener(): ListenerContact|\Closure|null;

    public function setExcelData(array $excelData): void;

    public function setExcelProperty(array $excelProperty): void;

    public function setExcelPropertyOther(array $excelPropertyOther): void;

    public function getExcelData(): array;

    public function getExcelProperty(): array;

    public function setExcel(array $excelEntity): static;

    /**
     * @return ExcelDataResult[]
     */
    public function getRawData(): array;

    public function setExcelClassData(array $excelClass): self;

    public function getExcel(): array;

    public function setStartRow(int $startRow): static;

    public function getStartRow(): int;

    public function save(): \SplFileInfo;

    public function setData(\Closure|array $data): static;

    public function getData();
}
