<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Annotation;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class DateFormat implements \DeathSatan\SatanExcel\Contacts\DateFormatContact
{
    public function __construct(public string $format){}

    public function getValue(): string
    {
        return $this->format;
    }
}
