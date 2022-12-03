<?php
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
$spreadsheet = \DeathSatan\SatanExcel\FileHelpers::loadFile(__DIR__.'/demo.xlsx');
$sheet = $spreadsheet->getActiveSheet();

//$sheet->setCellValue()