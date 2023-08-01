<?php

namespace DeathSatan\SatanExcel\Traits;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Mode;

trait ModeTrait
{
    protected function isXlsWriter(): bool
    {
        if (property_exists($this,'config')){
            if ($this->config instanceof Config){
                return $this->config->getMode() === Mode::MODE_XLS_WRITER;
            }
        }
        return false;
    }

    protected function isPhpOffice(): bool
    {
        if (property_exists($this,'config')){
            if ($this->config instanceof Config){
                return $this->config->getMode() === Mode::MODE_PHP_OFFICE;
            }
        }
        return false;
    }
}