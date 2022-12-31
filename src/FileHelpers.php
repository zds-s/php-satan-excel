<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class FileHelpers
{
    /**
     * \PhpOffice\PhpSpreadsheet\IOFactory::load别名.
     */
    public static function loadFile(string $filename, int $flags = 0, ?array $readers = null): Spreadsheet
    {
        return IOFactory::load($filename, $flags, $readers);
    }
}
