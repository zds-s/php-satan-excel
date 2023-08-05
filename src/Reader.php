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
    protected array $excelPropertyOther = [
        ExcelIgnore::class,
        NumberFormatContact::class,
        ExcelIgnoreUnannotatedContact::class,
        DateFormatContact::class,
    ];

    protected ?string $path;

    protected array $excel = [];

    protected HandlerContact $handler;

    protected int $startRow = 1;

    protected array $excelClassData = [];

    /**
     * @var null|\Closure|ListenerContact
     */
    protected $listener;

    public function __construct(public Config $config)
    {
    }

    public function setExcelClassData(array $excelClassData): self
    {
        $this->excelClassData = array_merge($this->excelClassData, $excelClassData);
        return $this;
    }
    
    /**
     * @param array|string[] $excelPropertyOther
     */
    public function setExcelPropertyOther(array $excelPropertyOther): self
    {
        $this->excelPropertyOther = array_merge($this->excelPropertyOther, $excelPropertyOther);
        return $this;
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
        return $this;
    }

    public function getExcelPropertyOther(): array
    {
        return $this->excelPropertyOther;
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

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setListener(ListenerContact|\Closure|null $listener): static
    {
        $this->listener = $listener;
        return $this;
    }

    public function getListener(): ListenerContact|\Closure|null
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
     * @return Reader
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

    public function headRowNumber(int $startRow = 1)
    {
        $this->startRow = $startRow;
    }

    public function getStartRow(): int
    {
        return $this->startRow;
    }

    public function getExcelClassData(): array
    {
        return $this->excelClassData;
    }

    public function doRead()
    {
        $handler = $this->getHandler()
            ->openFile($this->getPath())
            ->setListener($this->getListener());
        $handler->setExcelData($this->getExcelData());
        $handler->setExcelProperty($this->getExcelProperty());
        $handler->setStartRow($this->getStartRow());
        $handler->setExcelPropertyOther($this->getExcelPropertyOther());
        $handler->setExcelClassData($this->getExcelClassData());
        return $handler
            ->setExcel($this->getExcel())
            ->getRawData();
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
