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
}