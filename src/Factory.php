<?php
namespace DeathSatan\SatanExcel;

class Factory
{
    public static function excel(?Config $config = null)
    {
        return new Excel($config ?? new Config());
    }
}