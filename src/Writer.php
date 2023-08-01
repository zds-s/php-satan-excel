<?php

namespace DeathSatan\SatanExcel;

use DeathSatan\SatanExcel\Contacts\ExcelDataContact;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;
use DeathSatan\SatanExcel\Contacts\HandlerContact;
use DeathSatan\SatanExcel\Traits\ModeTrait;

class Writer
{
    use ModeTrait;


    protected array $excelData = [];

    protected array $excelProperty = [];

    protected ?string $path;

    protected array $excel = [];

    protected HandlerContact $handler;

    /**
     * @param string|null $path
     * @return Writer
     */
    public function setPath(?string $path): static
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param HandlerContact $handler
     * @return static
     */
    public function setHandler(HandlerContact $handler): static
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * @return HandlerContact
     */
    public function getHandler(): HandlerContact
    {
        return $this->handler;
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
        if (is_array($excel))
        {
            foreach ($excel as $xls){
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
     * @param string $excel
     * @return Reader
     */
    public function setExcel(string $excel)
    {
        $this->excel[] = $excel;
        return $this;
    }

    /**
     * @return array
     */
    public function getExcel(): array
    {
        return $this->excel;
    }

    /**
     * @param array $excelData
     */
    protected function setExcelData(array $excelData): void
    {
        $this->excelData[] = $excelData;
    }

    /**
     * @param array $excelProperty
     */
    protected function setExcelProperty(array $excelProperty): void
    {
        $this->excelProperty[] = $excelProperty;
    }

    /**
     * @return array
     */
    protected function getExcelData(): array
    {
        return $this->excelData;
    }

    /**
     * @return array
     */
    protected function getExcelProperty(): array
    {
        return $this->excelProperty;
    }


    public function __construct(public Config $config){}

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function doSave(array|\Closure $data)
    {
        $excel = $this->getExcelData();
        $property = $this->getExcelProperty();
        $handler  = $this->getHandler();
        $handler->setExcelData($excel);
        $handler->setExcelProperty($property);
        $handler->setData($data);
        return $handler->save();
    }
}