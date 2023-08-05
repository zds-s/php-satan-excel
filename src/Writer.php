<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel;

use DeathSatan\SatanExcel\Annotation\ExcelIgnore;
use DeathSatan\SatanExcel\Contacts\DateFormatContact;
use DeathSatan\SatanExcel\Contacts\ExcelDataContact;
use DeathSatan\SatanExcel\Contacts\ExcelIgnoreUnannotatedContact;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;
use DeathSatan\SatanExcel\Contacts\HandlerContact;
use DeathSatan\SatanExcel\Contacts\NumberFormatContact;
use DeathSatan\SatanExcel\Traits\ModeTrait;

class Writer
{
    use ModeTrait;

    protected array $excelClassData = [];

    protected array $excelData = [];

    protected array $excelProperty = [];

    protected array $excelPropertyOther = [
        ExcelIgnore::class,
        NumberFormatContact::class,
        ExcelIgnoreUnannotatedContact::class,
        DateFormatContact::class,
    ];

    protected ?string $path;

    protected array $excel = [];

    protected HandlerContact $handler;

    public function __construct(public Config $config)
    {
    }

    /**
     * @return array|string[]
     */
    public function getExcelPropertyOther(): array
    {
        return $this->excelPropertyOther;
    }

    public function setExcelClassData(array $excelClassData): void
    {
        $this->excelClassData = array_merge($this->excelClassData, $excelClassData);
    }

    public function getExcelClassData(): array
    {
        return $this->excelClassData;
    }

    /**
     * @param array|string[] $excelPropertyOther
     */
    public function setExcelPropertyOther(array $excelPropertyOther): self
    {
        $this->excelPropertyOther = array_merge($this->excelPropertyOther, $excelPropertyOther);
        return $this;
    }

    /**
     * @return Writer
     */
    public function setPath(?string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setHandler(HandlerContact $handler): static
    {
        $this->handler = $handler;
        return $this;
    }

    public function getHandler(): HandlerContact
    {
        return $this->handler;
    }

    public function handleAttributeProperty($excel)
    {
        $annotation = $this->getConfig()->getAnnotation();
        foreach ($this->getExcelPropertyOther() as $contact) {
            if (! empty($annotation[$contact])) {
                $attribute = $annotation[$contact];
                if (is_string($excel)) {
                    $excel = [$excel];
                }
                foreach ($excel as $excelClass) {
                    $excelProperty = $this->getConfig()->getReadAttribute()->getAttributeExcelProperty($excelClass, $attribute);
                    $this->setExcelPropertyOther([
                        $excelClass => $excelProperty,
                    ]);
                }
            }
        }
    }

    public function handleAttribute($excel)
    {
        $excelDataAttribute = $this->getConfig()->getAnnotation()[ExcelDataContact::class];
        $excelPropertyAttribute = $this->getConfig()->getAnnotation()[ExcelPropertyContact::class];
        if (is_string($excel)) {
            $excelData = $this->getConfig()->getReadAttribute()->getAttributeExcelData($excel, $excelDataAttribute);
            $excelProperty = $this->getConfig()->getReadAttribute()->getAttributeExcelProperty($excel, $excelPropertyAttribute);
            $this->setExcelData($excelData);
            $this->setExcelProperty($excelProperty);
            $this->setExcel($excel);
        }
        if (is_array($excel)) {
            foreach ($excel as $xls) {
                $excelData = $this->getConfig()->getReadAttribute()->getAttributeExcelData($xls, $excelDataAttribute);
                $excelProperty = $this->getConfig()->getReadAttribute()->getAttributeExcelProperty($xls, $excelPropertyAttribute);
                $this->setExcelData($excelData);
                $this->setExcelProperty($excelProperty);
                $this->setExcel($xls);
            }
        }

        return $this;
    }

    /**
     * @return Writer
     */
    public function setExcel(string $excel)
    {
        $this->excel[] = $excel;
        return $this;
    }

    public function getExcel(): array
    {
        return $this->excel;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function doSave(array|\Closure $data)
    {
        $excel = $this->getExcelData();
        $property = $this->getExcelProperty();
        $handler = $this->getHandler();
        $handler->setExcelData($excel);
        $handler->setExcelProperty($property);
        $handler->setExcelPropertyOther($this->getExcelPropertyOther());
        $handler->setExcelClassData($this->getExcelClassData());
        $handler->setData(count($excel) === 1 ? [$data] : $data);
        return $handler->save();
    }

    protected function setExcelData(array $excelData): void
    {
        $this->excelData[] = $excelData;
    }

    protected function setExcelProperty(array $excelProperty): void
    {
        $this->excelProperty[] = $excelProperty;
    }

    protected function getExcelData(): array
    {
        return $this->excelData;
    }

    protected function getExcelProperty(): array
    {
        return $this->excelProperty;
    }
}
