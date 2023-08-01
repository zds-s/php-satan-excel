<?php
require_once 'init.php';
debug(function (){
    $data = [];
    for ($i=0;$i<10000  ;$i++)
    {
        $data[] = [
            'id'    =>  randomInt(),
            'name'  =>  randomChinese(),
            'password'  =>  randomStr(6)
        ];
    }
    $excel = \DeathSatan\SatanExcel\Factory::excel(new \DeathSatan\SatanExcel\Config(
        mode: \DeathSatan\SatanExcel\Mode::MODE_XLS_WRITER
    ));
    $splFileInfo = $excel->write(\ExcelDto\DemoDTO::class)
        ->doSave([$data]);
    $xlsx = $splFileInfo->getRealPath();
    @copy($xlsx,__DIR__.DIRECTORY_SEPARATOR.'writer.xlsx');
    @unlink($xlsx);
});