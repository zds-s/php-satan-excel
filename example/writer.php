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
$data = [];
for ($i = 0; $i < 10; ++$i) {
    $data[] = [
        'id' => randomInt(),
        'name' => randomChinese(),
        'password' => randomStr(6),
        'login_time' => time(),
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
