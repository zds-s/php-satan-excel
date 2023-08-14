<?php
require_once 'init.php';

use DeathSatan\SatanExcel\Contacts\ListenerContact;
use DeathSatan\SatanExcel\Factory;
use DeathSatan\SatanExcel\Mode;
use DeathSatan\SatanExcel\Traits\ConverterTrait;
use DeathSatan\SatanExcel\Traits\HandlerTrait;
use ExcelDto\DemoDTO;

class ReadListener implements ListenerContact
{
    /**
     * 每次解析一条数据
     * @param object $data Entity实体
     * @param array $rawData 原生array数据
     * @return void
     */
    public function invoke(object $data, array $rawData)
    {
        $isEntity = $data instanceof DemoDTO;
        print "isEntity {$isEntity} \n ";
        print_r($rawData);
    }

    /**
     * 解析完所有数据后调用此方法
     * @param \DeathSatan\SatanExcel\Lib\ExcelDataResult[] $data 所有数据 array
     * @return void
     */
    public function doAfterAllAnalysed(array $data)
    {
        $count = count($data[0]->getSheetData());
        print "所有数据一共{$count}条\n";
    }

}

require_once 'init.php';
debug(function () {
    $excel = Factory::excel(new \DeathSatan\SatanExcel\Config(mode: Mode::MODE_XLS_WRITER));
    $listener = new ReadListener();
    $reader = $excel->read(__DIR__ . DIRECTORY_SEPARATOR . 'writer.xlsx', DemoDTO::class,$listener);
    $data = $reader->doRead();
    var_dump($data);
});