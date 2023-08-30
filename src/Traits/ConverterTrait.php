<?php

namespace DeathSatan\SatanExcel\Traits;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Mode;

trait ConverterTrait
{
    protected bool $isWriter = true;

    public function __construct(public Config $config,public mixed $handle){}

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

    public function isWriter(): bool
    {
        return $this->isWriter ?? true;
    }
}