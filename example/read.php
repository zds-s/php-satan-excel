<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
use DeathSatan\SatanExcel\Factory;
use DeathSatan\SatanExcel\Mode;
use DeathSatan\SatanExcel\Traits\ConverterTrait;
use DeathSatan\SatanExcel\Traits\HandlerTrait;
use ExcelDto\DemoDTO;

require_once 'init.php';
debug(function () {
    $excel = Factory::excel(new \DeathSatan\SatanExcel\Config(mode: Mode::MODE_PHP_OFFICE));

    $reader = $excel->read(__DIR__ . DIRECTORY_SEPARATOR . 'writer.xlsx', DemoDTO::class);
    $data = $reader->doRead();
    var_dump($data);
});
