<?php

use DeathSatan\SatanExcel\Export\ArrayExport;
use DeathSatan\SatanExcel\Export\Config\ArrayExportConfig;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once dirname(__DIR__).'/vendor/autoload.php';

$data = [
    [
        'id'=>0,
        'name'=>1,
        'pass'=>'123456'
    ],
    [
        'id'=>1,
        'name'=>2,
        'pass'=>'123456'
    ]
];
$filedTitles = [
    '序号','名称','密码'
];
$arrayExportConfig = new ArrayExportConfig();
// 设置要导出的数据
$arrayExportConfig->setData($data);
$arrayExportConfig->setFirstFields($filedTitles);

$arrayExportConfig->addEvent(ArrayExportConfig::EVENT_SAVING,
    function (Spreadsheet $spreadsheet){
    // 保存前回调
//        dump($spreadsheet);
    }
);
$arrayExportConfig->addEvent(ArrayExportConfig::EVENT_CELL_FORMAT,
function (\PhpOffice\PhpSpreadsheet\Cell\Cell $cell,array $raw){
//    dump($cell->getValue());
}
);
$export = new ArrayExport($arrayExportConfig);

$file = $export->save();
$file_path = $file->getRealPath();
copy($file_path,__DIR__.DIRECTORY_SEPARATOR.'demo.xlsx');
