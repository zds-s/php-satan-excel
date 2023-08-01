<?php

namespace DeathSatan\SatanExcel\Contacts;

interface ReadAttributeContact
{
    public function getAttributeExcelProperty(string $class, string $attribute): array;

    public function getAttributeExcelData(string $class, string $attribute): array;
}