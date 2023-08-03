<?php
require_once 'init.php';
$data = [];
for ($i=0;$i<10000  ;$i++)
{
    $data[] = [
        'id'    =>  randomInt(),
        'name'  =>  randomChinese(),
        'password'  =>  randomStr(6),
        'test1' =>  randomStr(),
        'test2' =>  randomStr(),
        'test3' =>  randomStr(),
        'test4' =>  randomStr(),
        'test5' =>  randomStr(),
        'test6' =>  randomStr(),
        'test7' =>  randomStr(),
    ];
}
debug(function ()use ($data){
    $excel = \DeathSatan\SatanExcel\Factory::excel(new \DeathSatan\SatanExcel\Config(
        mode: \DeathSatan\SatanExcel\Mode::MODE_PHP_OFFICE
    ));
    $splFileInfo = $excel->write(\ExcelDto\DemoDTO::class)
        ->doSave([$data]);
    $xlsx = $splFileInfo->getRealPath();
    @copy($xlsx,__DIR__.DIRECTORY_SEPARATOR.'writer.xlsx');
    @unlink($xlsx);
});