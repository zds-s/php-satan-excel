<?php

namespace DeathSatan\SatanExcel\Traits;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Mode;

trait ConverterTrait
{
    public function __construct(public Config $config){}

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function isXlsWriter(): bool
    {
        return $this->getConfig()->getMode() === Mode::MODE_XLS_WRITER;
    }

    public function isPhpOffice(): bool
    {
        return $this->getConfig()->getMode() === Mode::MODE_PHP_OFFICE;
    }
}