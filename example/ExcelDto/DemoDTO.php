<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace ExcelDto;

use DeathSatan\SatanExcel\Annotation\DateFormat;
use DeathSatan\SatanExcel\Annotation\ExcelData;
use DeathSatan\SatanExcel\Annotation\ExcelProperty;
use DeathSatan\SatanExcel\Converter\ImageConvert;

#[ExcelData(sheetName: '1111')]
class DemoDTO
{
    #[ExcelProperty(value: '序号', index: 1)]
    public string $id;

    #[ExcelProperty(value: '名称', index: 2)]
    public string $name;

    #[ExcelProperty(value: 'test1')]
    public string $test1;

    #[ExcelProperty(value: 'test1')]
    public string $test111;
    #[ExcelProperty(value: 'test1')]
    public string $test2;
    #[ExcelProperty(value: 'test1')]
    public string $test3;
    #[ExcelProperty(value: 'test1')]
    public string $test4;
    #[ExcelProperty(value: 'test1')]
    public string $test5;
    #[ExcelProperty(value: 'test1')]
    public string $test6;
    #[ExcelProperty(value: 'test1')]
    public string $test7;
    #[ExcelProperty(value: 'test1')]
    public string $test8;
    #[ExcelProperty(value: 'test1')]
    public string $test9;
    #[ExcelProperty(value: 'test1')]
    public string $test10;
    #[ExcelProperty(value: 'test1')]
    public string $test11;
    #[ExcelProperty(value: 'test1')]
    public string $test12;
    #[ExcelProperty(value: 'test1')]
    public string $test13;
    #[ExcelProperty(value: 'test1')]
    public string $test14;

    #[ExcelProperty(value: "图片",converter: ImageConvert::class)]
    public string $image;
}
