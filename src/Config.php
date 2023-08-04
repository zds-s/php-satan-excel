<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel;

use DeathSatan\SatanExcel\Annotation\DateFormat;
use DeathSatan\SatanExcel\Annotation\ExcelData;
use DeathSatan\SatanExcel\Annotation\ExcelIgnore;
use DeathSatan\SatanExcel\Annotation\ExcelProperty;
use DeathSatan\SatanExcel\Annotation\NumberFormat;
use DeathSatan\SatanExcel\Contacts\DateFormatContact;
use DeathSatan\SatanExcel\Contacts\ExcelDataContact;
use DeathSatan\SatanExcel\Contacts\ExcelIgnoreContanct;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;
use DeathSatan\SatanExcel\Contacts\NumberFormatContact;
use DeathSatan\SatanExcel\Contacts\ReadAttributeContact;

class Config
{
    public function __construct(
        public int $mode = Mode::MODE_PHP_OFFICE,
        public array $annotation = [
            ExcelPropertyContact::class => ExcelProperty::class,
            ExcelDataContact::class => ExcelData::class,
            ReadAttributeContact::class => null,
            ExcelIgnoreContanct::class => ExcelIgnore::class,
            DateFormatContact::class => DateFormat::class,
            NumberFormatContact::class => NumberFormat::class,
        ],
        public array $driver = [
            Driver::PHP_OFFICE => null,
            Driver::XLS_WRITER => null,
        ],
    ) {
        if (empty($this->annotation[ExcelPropertyContact::class]) || empty($this->annotation[ExcelDataContact::class])) {
            throw new \RuntimeException('Incorrect configuration. Annotation not mapped correctly');
        }

        $readAttribute = $this->annotation[ReadAttributeContact::class];
        if ($readAttribute === null) {
            $this->annotation[ReadAttributeContact::class] = new DefaultReadAttribute();
        } else {
            if (! $readAttribute instanceof ReadAttributeContact) {
                throw new \RuntimeException('Annotation reading configuration error');
            }
        }
    }

    public function getReadAttribute(): ReadAttributeContact
    {
        return $this->getAnnotation()[ReadAttributeContact::class];
    }

    public function getDriver(): array
    {
        return $this->driver;
    }

    public function getAnnotation(): array
    {
        return $this->annotation;
    }

    public function getMode(): int
    {
        return $this->mode;
    }

    public function setAnnotation(array $annotation): void
    {
        $this->annotation = $annotation;
    }

    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    public function setDriver(array $driver): void
    {
        $this->driver = $driver;
    }
}
