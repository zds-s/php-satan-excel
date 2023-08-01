<?php

namespace DeathSatan\SatanExcel;

use Closure;
use DeathSatan\SatanExcel\Contacts\HandlerContact;
use DeathSatan\SatanExcel\Contacts\ListenerContact;
use DeathSatan\SatanExcel\Handler\PhpOfficeHandler;
use DeathSatan\SatanExcel\Handler\XlsWriterHandler;

class Excel
{


    protected HandlerContact $handler;

    /**
     * @var null|ListenerContact|Closure
     */
    protected  $listener = null;

    protected ?string $path = null;

    protected array $excelData = [];

    protected array $excelProperty = [];


    public function __construct(protected Config $config){
        $this->init();
    }



    /**
     * @return HandlerContact
     */
    public function getHandler(): HandlerContact
    {
        return $this->handler;
    }

    /**
     * @param HandlerContact $handler
     */
    public function setHandler(HandlerContact $handler): void
    {
        $this->handler = $handler;
    }

    protected function init()
    {
        $mode = $this->getConfig()->getMode() === Mode::MODE_PHP_OFFICE;
        if ($mode){
            $this->setHandler(new PhpOfficeHandler($this->getConfig()));
        }else{
            $this->setHandler(new XlsWriterHandler($this->getConfig()));
        }
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function read(string $path,$excel,null|ListenerContact|Closure $listener = null): Reader
    {
        if (!is_file($path) || !is_writable($path)){
            throw new \RuntimeException(sprintf('file [%s] not found',$path));
        }
        return (new  Reader($this->getConfig()))
            ->setHandler($this->getHandler())
            ->handleAttribute($excel)
            ->setListener($listener)
            ->setPath($path);
    }


    public function write($excel):Writer
    {
        $wirter = new Writer($this->getConfig());
        $wirter->setHandler($this->getHandler());
        $wirter->handleAttribute($excel);
        return $wirter;
    }
}