<?php

namespace DeathSatan\SatanExcel\Annotation;

use Attribute;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;
use DeathSatan\SatanExcel\Converter\StringConverter;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::IS_REPEATABLE)]
class ExcelProperty implements ExcelPropertyContact
{
    public function __construct(public string $value,public int $order = PHP_INT_MAX,public int $index = -1,public string $converter = StringConverter::class){}

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getConverter(): string
    {
        return $this->converter;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): ExcelPropertyContact
    {
        $this->order = $order;
        return $this;
    }

    public function setIndex(int $index): ExcelPropertyContact
    {
        $this->index = $index;
        return $this;
    }
}