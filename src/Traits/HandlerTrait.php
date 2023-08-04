<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Traits;

use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Contacts\ListenerContact;

trait HandlerTrait
{
    /**
     * @var null|\Closure|ListenerContact
     */
    protected $listener;

    protected array $excelData = [];

    protected array $excelProperty = [];

    protected array $excelPropertyOther = [];

    protected array $excel = [];

    protected int $startRow = 1;

    protected \Closure|array $data = [];

    protected array $excelClassData = [];
    /**
     * @param array $excelClassData
     */
    public function setExcelClassData(array $excelClassData): self
    {
        $this->excelClassData = array_merge($this->excelClassData,$excelClassData);
        return $this;
    }

    /**
     * @return array
     */
    public function getExcelClassData(): array
    {
        return $this->excelClassData;
    }

    public function setExcelPropertyOther(array $excelPropertyOther): void
    {
        $this->excelPropertyOther = $excelPropertyOther;
    }

    /**
     * @return HandlerTrait
     */
    public function setExcel(array $excel): static
    {
        $this->excel = $excel;
        return $this;
    }

    public function getExcel(): array
    {
        return $this->excel;
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

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function setExcelData(array $excelData): void
    {
        $this->excelData = $excelData;
    }

    public function setExcelProperty(array $excelProperty): void
    {
        $this->excelProperty = $excelProperty;
    }

    public function getExcelData(): array
    {
        return $this->excelData;
    }

    public function getExcelProperty(): array
    {
        return $this->excelProperty;
    }

    public function setStartRow(int $startRow): static
    {
        $this->startRow = $startRow;
        return $this;
    }

    public function getStartRow(): int
    {
        return $this->startRow;
    }

    public function setData(\Closure|array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getData(): array
    {
        $data = $this->data;
        if ($data instanceof \Closure) {
            $data = $data();
        }
        return $data;
    }

    protected function getExcelPropertyOther(): array
    {
        return $this->excelPropertyOther;
    }

    protected function getPropertyAttribute(string $excelClass, string $property)
    {
        $other = $this->getExcelPropertyOther();
        if (! empty($other[$excelClass])) {
            $excelClassProperty = $other[$excelClass];
            foreach ($excelClassProperty as $key => $propertyAttribute) {
                if ($key === $property) {
                    return $propertyAttribute;
                }
            }
        }
        return false;
    }

    protected function handleListener(?object $entity, array $data, int $event = 0)
    {
        $listener = $this->getListener();
        if (empty($listener)) {
            return;
        }
        $isCall = is_callable($listener);
        switch ($event) {
            case 1:
                if ($isCall) {
                    $listener($entity, $data);
                } else {
                    $listener->invoke($entity, $data);
                }
                break;
            case 2:
                if (! $isCall) {
                    $listener->doAfterAllAnalysed($data);
                }
                break;
        }
    }
}
