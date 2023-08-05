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

    #[ExcelProperty(value: '密码', index: 3)]
    public string $password;

    #[DateFormat('Y-m-d H:i:s')]
    #[ExcelProperty(value: '登录时间', index: 4)]
    public int $login_time;

    #[ExcelProperty(value: '图片', index: 5, converter: ImageConvert::class)]
    public string $image;
}
