<?php

namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\Converter\StringConverter;

interface ExcelPropertyContact
{
    /**
     * @param string $value 标题列名
     * @param int $order 排序 优先级2
     * @param int $index 排序 优先级1
     * @param string $converter 转换器 默认字符串转换器
     */
    public function __construct(string $value,int $order = PHP_INT_MAX,int $index = 0,string $converter = StringConverter::class);

    public function getValue(): string;

    public function getConverter(): string;

    public function getIndex(): int;

    public function getOrder(): int;

    public function setOrder(int $order):self;

    public function setIndex(int $index):self;
}