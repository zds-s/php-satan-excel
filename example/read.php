<?php
require_once 'init.php';
debug(function (){
    $excel = \DeathSatan\SatanExcel\Factory::excel(new \DeathSatan\SatanExcel\Config(mode: \DeathSatan\SatanExcel\Mode::MODE_PHP_OFFICE));
    $reader = $excel->read(__DIR__.DIRECTORY_SEPARATOR.'demo.xlsx',\ExcelDto\DemoDTO::class,new class implements \DeathSatan\SatanExcel\Contacts\ListenerContact{
        protected array $data;
        public function invoke(object $data, array $rawData)
        {
            $this->data[] = $rawData;
        }
        public function doAfterAllAnalysed(array $data)
        {
            var_dump("当前一共:".count($this->data).'行');
            var_dump("第一行");
            var_dump($this->data[0]);
        }
    });
    $reader->doRead();
});

