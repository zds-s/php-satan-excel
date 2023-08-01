<?php
// 格式化字节数为可读形式（如 KB、MB、GB 等）
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
}



function debug(Closure $closure)
{
    ini_set('memory_limit','10000000000');
    $start_memoryUsage = memory_get_usage();
    $start_time = microtime(true);
    $closure();
    $end_time = microtime(true);
    $end_memoryUsage = memory_get_usage();
    echo sprintf("程序执行完毕\r\n执行用时%s\r\n执行消耗内存%s\r\n", $end_time - $start_time, formatBytes($end_memoryUsage - $start_memoryUsage));
}
// App_Controller_System_Authority_DynamicController

/**
 * @throws Exception
 */
function randomStr(int $length = 10)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // 字符范围
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function randomInt(int $length = 4)
{
    $randomNumber = '';
    for ($i = 0; $i < $length; $i++) {
        $randomNumber .= mt_rand(0, 9);
    }
    return $randomNumber;
}

function randomChinese(int $length = 4)
{
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode = mt_rand(0x4E00, 0x9FFF); // 生成随机的 Unicode 编码值
        $randomChar = mb_chr($randomCode, 'UTF-8'); // 将 Unicode 编码转换为实际汉字字符
        $result .= $randomChar;
    }
    return $result;
}