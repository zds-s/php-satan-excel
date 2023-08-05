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

class ReaderContext implements \DeathSatan\SatanExcel\Contacts\ReaderContext
{
    public function __construct(public mixed $rawValue, public int $rowIndex, public int $columnIndex, public Config $config)
    {
    }

    public function getRawValue(): mixed
    {
        return $this->rawValue;
    }

    public function getConfig(): Config
    {
        return $this->config;
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

    /**
     * {@inheritDoc}
     */
    public function getValue(): mixed
    {
        return $this->getRawValue();
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
    public function getColumnIndex(): int
    {
        return $this->columnIndex;
    }
}
