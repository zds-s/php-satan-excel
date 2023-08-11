<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Factory;
use DeathSatan\SatanExcel\Mode;
use ExcelDto\DemoDTO;

require_once 'init.php';
ini_set('memory_limit',"2G");
$data = [];
for ($i = 0; $i < 100000; ++$i) {
    $data[] = [
        'id' => randomInt(),
        'name' => randomChinese(),
        'test1'=>randomStr(),
        'test11'=>randomStr(),
        'test2'=>randomStr(),
        'test3'=>randomStr(),
        'test4'=>randomStr(),
        'test5'=>randomStr(),
        'test6'=>randomStr(),
        'test7'=>randomStr(),
        'test8'=>randomStr(),
        'test9'=>randomStr(),
        'test10'=>randomStr(),
        'test11'=>randomStr(),
        'test12'=>randomStr(),
        'test13'=>randomStr(),
        'test14'=>randomStr(),
    ];
}
debug(function () use ($data) {
    $excel = Factory::excel(new Config(
        mode: Mode::MODE_XLS_WRITER
    ));
    $splFileInfo = $excel->write(DemoDTO::class)
        ->doSave($data);
    $xlsx = $splFileInfo->getRealPath();
    @copy($xlsx, __DIR__ . DIRECTORY_SEPARATOR . 'writer.xlsx');
    @unlink($xlsx);
});
