<?php

namespace ExcelDto;

use DeathSatan\SatanExcel\Annotation\DateFormat;
use DeathSatan\SatanExcel\Annotation\ExcelData;
use DeathSatan\SatanExcel\Annotation\ExcelProperty;
use DeathSatan\SatanExcel\Annotation\NumberFormat;

#[ExcelData(sheetName: '1111')]
class DemoDTO
{
    #[ExcelProperty(value: "序号",index: 1)]
    public string $id;
    #[ExcelProperty(value: "名称",index: 2)]
    public string $name;
    #[ExcelProperty(value: "密码",index: 3)]
    public string $password;

    #[DateFormat("Y-m-d H:i:s")]
    #[ExcelProperty(value: "登录时间",index: 4)]
    public int $login_time;
}