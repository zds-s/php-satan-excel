<?php

namespace ExcelDto;

use DeathSatan\SatanExcel\Annotation\ExcelData;
use DeathSatan\SatanExcel\Annotation\ExcelProperty;

#[ExcelData(sheetName: '1111')]
class DemoDTO
{
    #[ExcelProperty(value: "序号",index: 1)]
    public string $id;
    #[ExcelProperty(value: "名称",index: 2)]
    public string $name;
    #[ExcelProperty(value: "密码",index: 3)]
    public string $password;

    #[ExcelProperty(value: "测试1",index: 4)]
    public string $test1;
    #[ExcelProperty(value: "测试2",index: 4)]
    public string $test2;
    #[ExcelProperty(value: "测试3",index: 4)]
    public string $test3;
    #[ExcelProperty(value: "测试4",index: 4)]
    public string $test4;
    #[ExcelProperty(value: "测试5",index: 4)]
    public string $test5;
    #[ExcelProperty(value: "测试6",index: 4)]
    public string $test6;
    #[ExcelProperty(value: "测试7",index: 4)]
    public string $test7;

}