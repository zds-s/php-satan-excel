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
for ($i = 0; $i < 10000;++$i) {
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
        'image' =>  __DIR__.DIRECTORY_SEPARATOR.'222.png'
    ];
}
debug(function () use ($data) {
    // 生成excel操作类
    $excel = Factory::excel(new Config(
        mode: Mode::MODE_XLS_WRITER // 使用xlsxwriter做驱动
    ));
    // 导出到文件
    $splFileInfo = $excel->write(DemoDTO::class)
        ->doSave($data);
    // 获取真实文件地址
    $xlsx = $splFileInfo->getRealPath();
    // 复制到当前目录
    @copy($xlsx, __DIR__ . DIRECTORY_SEPARATOR . 'writer.xlsx');
    @unlink($xlsx);
});
