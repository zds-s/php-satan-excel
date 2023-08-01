<?php

namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\Config;

interface HandlerContact
{
    public function __construct(Config $config);

    public function openFile(string $path) : self;

    public function setListener(ListenerContact|\Closure|null $listener): static;

    public function getListener(): ListenerContact|\Closure|null;
    /**
     * @param array $excelData
     */
    function setExcelData(array $excelData): void;

    /**
     * @param array $excelProperty
     */
    function setExcelProperty(array $excelProperty): void;

    /**
     * @return array
     */
    function getExcelData(): array;

    /**
     * @return array
     */
    function getExcelProperty(): array;

    public function getRawData(): array;

    public function setExcel(array $excelEntity):static;

    public function getExcel():array;

    public function setStartRow(int $startRow): static;

    public function getStartRow(): int;

    public function save(): \SplFileInfo;

    public function setData(\Closure|array $data): static;

    public function getData(): array;
}