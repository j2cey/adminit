<?php

namespace App\Enums;

enum ValueTypeEnum:string
{
    case STRING = 'string';
    case INT = 'int';
    case DATETIME = 'datetime';
}
