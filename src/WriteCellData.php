<?php

namespace DeathSatan\SatanExcel;

class WriteCellData
{
    public function __construct(public string $value){}

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}