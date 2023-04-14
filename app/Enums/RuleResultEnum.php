<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;

enum RuleResultEnum: string
{
    use EnumTrait;

    case ALLWAYS = 'allways';
    case ALLOWED = 'allowed';
    case BROKEN = 'broken';
}
