<?php

namespace DeathSatan\SatanExcel\Contacts;

use DeathSatan\SatanExcel\Config;

interface DriverContact
{
    public function __construct(Config $config);
}