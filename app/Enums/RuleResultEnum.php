<?php

namespace App\Enums;

enum RuleResultEnum: string
{
    case ALLOWED = 'allowed';
    case BROKEN = 'broken';
}
