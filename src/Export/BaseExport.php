<?php

namespace DeathSatan\SatanExcel\Export;

use SplFileObject;

interface BaseExport
{

    /**
     * 当前要导出的数组列表
     * @return array
     */
    public function toArray():array;

    /**
     * 将导出结果保存到指定文件
     * 默认输出到系统临时文件目录
     * @return SplFileObject
     */
    public function save():SplFileObject;

}