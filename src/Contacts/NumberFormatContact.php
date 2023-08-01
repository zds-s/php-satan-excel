<?php

namespace DeathSatan\SatanExcel\Contacts;

interface NumberFormatContact
{
    public function __construct(string $value);

    public function getValue();
}