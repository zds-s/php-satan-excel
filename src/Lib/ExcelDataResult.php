<?php

namespace DeathSatan\SatanExcel\Lib;

class ExcelDataResult
{
    public string $sheetName;

    public array $sheetData;

    /**
     * @return string
     */
    public function getSheetName(): string
    {
        return $this->sheetName;
    }

    /**
     * @param string $sheetName
     */
    public function setSheetName(string $sheetName): void
    {
        $this->sheetName = $sheetName;
    }

    /**
     * @return array
     */
    public function getSheetData(): array
    {
        return $this->sheetData;
    }

    /**
     * @param array $sheetData
     */
    public function setSheetData(array $sheetData): void
    {
        $this->sheetData = $sheetData;
    }

    public function appendSheetData($data): void
    {
        $this->sheetData[] = $data;
    }
}