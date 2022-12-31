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
$dataFields = ['id','name','pass'];
$filedTitles = [
    '序号','名称','密码'
];
$arrayExportConfig = new ArrayExportConfig();
// 设置要导出的数据
$arrayExportConfig->setData($data);
$arrayExportConfig->setFirstFields($filedTitles);

$arrayExportConfig->addEvent(ArrayExportConfig::EVENT_SAVING,
    function (Spreadsheet $spreadsheet){
    // 保存前回调 在这里对要导出的文件 SpreadSheet进行操作
//        dump($spreadsheet);
    }
);
$arrayExportConfig->addEvent(ArrayExportConfig::EVENT_CELL_FORMAT,
function (\PhpOffice\PhpSpreadsheet\Cell\Cell $cell,array $raw)use ($dataFields,$filedTitles){
    // 获取当前单元格值
     $cellValue = $cell->getValue();
     // 获取当前一列所属的下标
     $index = array_search($cellValue,$raw);
     $dataFieldValue = $dataFields[$index];
     $filedValue = $filedTitles[$index];
     echo sprintf('当前设置的值:%s,列名:%s,列标题:%s',$cellValue,$dataFieldValue,$filedValue)."\n";
}
);
$export = new ArrayExport($arrayExportConfig);

# 保存为文件
$file = $export->save();
# 获取保存
$file_path = $file->getRealPath();
// 将文件移动到当前目录下并且重命名为 demo.xlsx
copy($file_path,__DIR__.DIRECTORY_SEPARATOR.'demo.xlsx');
