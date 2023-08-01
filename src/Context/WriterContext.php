<?php

namespace DeathSatan\SatanExcel\Context;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Mode;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Vtiful\Kernel\Format;

class WriterContext implements \DeathSatan\SatanExcel\Contacts\WriterContext
{

    public function __construct(public mixed $rawValue,public int $rowIndex,public int $columnIndex,public Config $config){}

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return mixed
     */
    public function getRawValue(): mixed
    {
        return $this->rawValue;
    }

    /**
     * @return int
     */
    public function getColumnIndex(): int
    {
        return $this->columnIndex;
    }

    /**
     * @inheritDoc
     */
    public function getCellStyle()
    {
        if ($this->isXlsWriter()){
            $value = $this->getRawValue();
            if (is_array($value))
            {
                /** @var Cell $cell */
                [$value,$format] = $value;
                return $format;
            }
        }
        if ($this->isPhpOffice()){
            $value = $this->getRawValue();
            if (is_array($value))
            {
                /** @var Cell $cell */
                [$value,$cell] = $value;
                return $cell->getStyle();
            }
            throw new \RuntimeException('php-office not found stlye');
        }
        throw new \RuntimeException('not found handler');
    }

    /**
     * @inheritDoc
     */
    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    /**
     * @inheritDoc
     */
    public function isXlsWriter(): bool
    {
        return $this->getConfig()->getMode() === Mode::MODE_XLS_WRITER;
    }

    /**
     * @inheritDoc
     */
    public function isPhpOffice(): bool
    {
        return $this->getConfig()->getMode() === Mode::MODE_PHP_OFFICE;
    }

    public function getValue(): mixed
    {
        return $this->getRawValue()[0];
    }

}