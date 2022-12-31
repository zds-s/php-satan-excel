<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Export;

interface BaseExport
{
    /**
     * 当前要导出的数组列表.
     */
    public function toArray(): array;

    /**
     * 将导出结果保存到指定文件
     * 默认输出到系统临时文件目录.
     */
    public function save(): \SplFileObject;
}
