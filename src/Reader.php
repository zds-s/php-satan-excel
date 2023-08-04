<?php

namespace DeathSatan\SatanExcel;

use Closure;
use DeathSatan\SatanExcel\Annotation\ExcelIgnore;
use DeathSatan\SatanExcel\Annotation\ExcelIgnoreUnannotated;
use DeathSatan\SatanExcel\Contacts\ExcelDataContact;
use DeathSatan\SatanExcel\Contacts\ExcelIgnoreContanct;
use DeathSatan\SatanExcel\Contacts\ExcelIgnoreUnannotatedContact;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyContact;
use DeathSatan\SatanExcel\Contacts\ExcelPropertyFormatContact;
use DeathSatan\SatanExcel\Contacts\HandlerContact;
use DeathSatan\SatanExcel\Contacts\ListenerContact;
use DeathSatan\SatanExcel\Contacts\NumberFormatContact;
use DeathSatan\SatanExcel\Traits\ModeTrait;

class Reader
{
    use ModeTrait;

    protected array $excelData = [];

    /** @var array Property注解 */
    protected array $excelProperty = [];

    /** @var array 其他注解 */
    protected array $excelPropertyOther = [];

    protected ?string $path;

    protected array $excel = [];

    protected HandlerContact $handler;

    protected int $startRow = 1;

    /**
     * @var null|ListenerContact|Closure
     */
    protected  $listener = null;

    /** @var array 默认会进行读取的ExcelProperty类 */
    protected array $propertyAttributes = [
        ExcelPropertyContact::class,
        ExcelIgnoreContanct::class,
        ExcelIgnoreUnannotatedContact::class,
        NumberFormatContact::class,
        ExcelPropertyFormatContact::class
    ];

    /**
     * @param array $excelPropertyOther
     * @return self
     */
    public function setExcelPropertyOther(array $excelPropertyOther): self
    {
        $this->excelPropertyOther = $excelPropertyOther;
        return $this;
    }

    /**
     * @return array
     */
    public function getExcelPropertyOther(): array
    {
        return $this->excelPropertyOther;
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

    public function __construct(public Config $config){}

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param string|null $path
     * @return static
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
     * @param Closure|ListenerContact|null $listener
     * @return static
     */
    public function setListener(ListenerContact|Closure|null $listener): static
    {
        $this->listener = $listener;
        return $this;
    }

    /**
     * @return Closure|ListenerContact|null
     */
    public function getListener(): ListenerContact|Closure|null
    {
        return $this->listener;
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

    public function headRowNumber(int $startRow = 1)
    {
        $this->startRow = $startRow;
    }

    /**
     * @return int
     */
    public function getStartRow(): int
    {
        return $this->startRow;
    }
    public function doRead()
    {
        $handler = $this->getHandler()
        ->openFile($this->getPath())
        ->setListener($this->getListener());
        $handler->setExcelData($this->getExcelData());
        $handler->setExcelProperty($this->getExcelProperty());
        $handler->setStartRow($this->getStartRow());
        return $handler
            ->setExcel($this->getExcel())
            ->getRawData();
    }
}