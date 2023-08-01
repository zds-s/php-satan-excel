<?php

namespace DeathSatan\SatanExcel\Traits;

use Closure;
use DeathSatan\SatanExcel\Config;
use DeathSatan\SatanExcel\Contacts\ListenerContact;

trait HandlerTrait
{
    /**
     * @var null|ListenerContact|Closure
     */
    protected  $listener = null;


    protected array $excelData = [];

    protected array $excelProperty = [];

    protected array $excel = [];

    protected int $startRow = 1;

    protected Closure|array $data = [];
    /**
     * @param array $excel
     * @return HandlerTrait
     */
    public function setExcel(array $excel): static
    {
        $this->excel = $excel;
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

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param array $excelData
     */
    public function setExcelData(array $excelData): void
    {
        $this->excelData = $excelData;
    }

    /**
     * @param array $excelProperty
     */
    public function setExcelProperty(array $excelProperty): void
    {
        $this->excelProperty = $excelProperty;
    }

    /**
     * @return array
     */
    public function getExcelData(): array
    {
        return $this->excelData;
    }

    /**
     * @return array
     */
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

    protected function handleListener(?object $entity,array $data,int $event = 0)
    {
        $listener = $this->getListener();
        if (empty($listener)){
            return;
        }
        $isCall = is_callable($listener);
        switch ($event){
            case 1:
                if ($isCall){
                    $listener($entity,$data);
                }else{
                    $listener->invoke($entity,$data);
                }
                break;
            case 2:
                if (!$isCall){
                    $listener->doAfterAllAnalysed($data);
                }
                break;
        }
    }

    public function setData(\Closure|array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getData(): array
    {
        $data = $this->data;
        if ($data instanceof Closure){
            $data = $data();
        }
        return $data;
    }
}