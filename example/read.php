<?php

use DeathSatan\SatanExcel\Contacts\ListenerContact;
use DeathSatan\SatanExcel\Factory;
use DeathSatan\SatanExcel\Mode;
use ExcelDto\DemoDTO;

require_once 'init.php';
debug(function (){
    $excel = Factory::excel(new \DeathSatan\SatanExcel\Config(mode: Mode::MODE_PHP_OFFICE));
    $reader = $excel->read(__DIR__.DIRECTORY_SEPARATOR.'demo.xlsx', DemoDTO::class);
    $data = $reader->doRead();
    var_dump($data);
});

