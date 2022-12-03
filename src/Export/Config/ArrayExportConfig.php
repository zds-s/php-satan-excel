<?php

namespace DeathSatan\SatanExcel\Export\Config;

use Closure;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 数组导出配置
 */
class ArrayExportConfig
{
    // 要保存的类型
    private string $fileType = Xlsx::class;

    // 字段注释
    private ?array $firstFields = null;

    // 开始行数
    private int $startLine = 1;

    /** @var string 文件保存事件 */
    public const EVENT_SAVING = 'saving';

    /** @var string 单元格格式化事件 */
    public const EVENT_CELL_FORMAT = 'cell_format';

    private array $events = [
        self::EVENT_SAVING=>[],
        self::EVENT_CELL_FORMAT=>[],
    ];



    /**
     * @param string $event
     * @return array
     */
    public function getEvent(string $event = self::EVENT_SAVING) : array
    {
        return $this->getEvents()[$event] ?? [];
    }

    /**
     * 注册指定事件
     * @param string $event
     * @param Closure $closure
     * @return void
     */
    public function addEvent(string $event,Closure $closure)
    {
        $event_call = $this->getEvent($event);
        // 合并之前注册的回调
        $event_call = array_merge($event_call,[$closure]);
        $events = $this->getEvents();
        $events[$event] = $event_call;
        $this->setEvents($events);
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param array|array[] $events
     */
    public function setEvents(array $events): void
    {
        $this->events = $events;
    }

    /** @var bool 自动分批处理| 数据量大于1k */
    private bool $autoYield = true;

    /**
     * @return bool
     */
    public function isAutoYield(): bool
    {
        return $this->autoYield;
    }

    /**
     * @param bool $autoYield
     */
    public function setAutoYield(bool $autoYield): void
    {
        $this->autoYield = $autoYield;
    }



    // 是否使用生成器
    private bool $yield = false;

    /**
     * @return bool
     */
    public function isYield(): bool
    {
        return $this->yield;
    }

    /**
     * @param bool $yield
     */
    public function setYield(bool $yield): void
    {
        $this->yield = $yield;
    }

    /**
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType(string $fileType): void
    {
        $this->fileType = $fileType;
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return ?array
     */
    public function getFirstFields(): ?array
    {
        return $this->firstFields;
    }

    /**
     * @param array $firstFields
     */
    public function setFirstFields(array $firstFields): void
    {
        $this->firstFields = $firstFields;
    }

    /**
     * @return int
     */
    public function getStartLine(): int
    {
        return $this->startLine;
    }

    /**
     * @param int $startLine
     */
    public function setStartLine(int $startLine): void
    {
        $this->startLine = $startLine;
    }

    /**
     * @param int $activeSheetIndex
     */
    public function setActiveSheetIndex(int $activeSheetIndex): void
    {
        $this->activeSheetIndex = $activeSheetIndex;
    }


}