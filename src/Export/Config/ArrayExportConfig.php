<?php

declare(strict_types=1);
/**
 * This is an extension of Death-Satan
 * Name PHP-Excel
 *
 * @link     https://www.cnblogs.com/death-satan
 */
namespace DeathSatan\SatanExcel\Export\Config;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 数组导出配置.
 */
class ArrayExportConfig
{
    /** @var string 文件保存事件 */
    public const EVENT_SAVING = 'saving';

    /** @var string 单元格格式化事件 */
    public const EVENT_CELL_FORMAT = 'cell_format';

    // 要保存的类型
    private string $fileType = Xlsx::class;

    // 字段注释
    private ?array $firstFields = null;

    // 开始行数
    private int $startLine = 1;

    private array $events = [
        self::EVENT_SAVING => [],
        self::EVENT_CELL_FORMAT => [],
    ];

    /** @var bool 自动分批处理| 数据量大于1k */
    private bool $autoYield = true;

    // 是否使用生成器
    private bool $yield = false;

    private array $data = [];

    public function getEvent(string $event = self::EVENT_SAVING): array
    {
        return $this->getEvents()[$event] ?? [];
    }

    /**
     * 注册指定事件.
     */
    public function addEvent(string $event, \Closure $closure)
    {
        $event_call = $this->getEvent($event);
        // 合并之前注册的回调
        $event_call = array_merge($event_call, [$closure]);
        $events = $this->getEvents();
        $events[$event] = $event_call;
        $this->setEvents($events);
    }

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

    public function isAutoYield(): bool
    {
        return $this->autoYield;
    }

    public function setAutoYield(bool $autoYield): void
    {
        $this->autoYield = $autoYield;
    }

    public function isYield(): bool
    {
        return $this->yield;
    }

    public function setYield(bool $yield): void
    {
        $this->yield = $yield;
    }

    public function getFileType(): string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): void
    {
        $this->fileType = $fileType;
    }

    public function getData(): array
    {
        return $this->data;
    }

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

    public function setFirstFields(array $firstFields): void
    {
        $this->firstFields = $firstFields;
    }

    public function getStartLine(): int
    {
        return $this->startLine;
    }

    public function setStartLine(int $startLine): void
    {
        $this->startLine = $startLine;
    }
}
