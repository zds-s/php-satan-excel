<?php

namespace DeathSatan\SatanExcel\Annotation;

use DeathSatan\SatanExcel\Contacts\ExcelIgnoreContanct;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ExcelIgnore implements ExcelIgnoreContanct
{
}