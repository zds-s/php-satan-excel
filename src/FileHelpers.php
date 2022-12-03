<?php

namespace DeathSatan\SatanExcel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class FileHelpers
{

    /**
     * \PhpOffice\PhpSpreadsheet\IOFactory::load别名
     * @param string $filename
     * @param int $flags
     * @param array|null $readers
     * @return Spreadsheet
     */
    public static function loadFile(string $filename, int $flags = 0, ?array $readers = null): Spreadsheet
    {
        return IOFactory::load($filename,$flags,$readers);
    }
}