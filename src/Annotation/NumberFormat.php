<?php

namespace DeathSatan\SatanExcel\Annotation;

use DeathSatan\SatanExcel\Contacts\NumberFormatContact;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NumberFormat implements NumberFormatContact
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