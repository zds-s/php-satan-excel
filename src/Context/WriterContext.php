<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Context;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Mode;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class WriterContext implements \DeathSatan\SatanExcel\Contacts\WriterContext
{
    public function __construct(public mixed $rawValue, public int $rowIndex, public int $columnIndex, public Config $config, public object $driver)
    {
    }

    public function getDriver(): object
    {
        return $this->driver;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getRawValue(): mixed
    {
        return $this->rawValue;
    }

    public function getColumnIndex(): int
    {
        return $this->columnIndex;
    }

    public function getCell()
    {
        if ($this->isPhpOffice()) {
            $value = $this->getRawValue();
            if (is_array($value)) {
                /** @var Cell $cell */
                [$value,$cell] = $value;
                return $cell;
            }
            throw new \RuntimeException('php-office not found stlye');
        }
        throw new \RuntimeException('not found handler');
    }

    /**
     * {@inheritDoc}
     */
    public function getCellStyle()
    {
        if ($this->isXlsWriter()) {
            $value = $this->getRawValue();
            if (is_array($value)) {
                /* @var Cell $cell */
                [$value,$format] = $value;
                return $format;
            }
        }
        return $this->getCell()->getStyle();
    }

    /**
     * {@inheritDoc}
     */
    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    /**
     * {@inheritDoc}
     */
    public function isXlsWriter(): bool
    {
        return $this->getConfig()->getMode() === Mode::MODE_XLS_WRITER;
    }

    /**
     * {@inheritDoc}
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
