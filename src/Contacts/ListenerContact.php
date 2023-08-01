<?php

namespace DeathSatan\SatanExcel\Contacts;

interface ListenerContact
{
    public function invoke(object $data,array $rawData);

    public function doAfterAllAnalysed(array $data);
}