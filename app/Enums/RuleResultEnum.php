<?php

namespace App\Enums;

enum RuleResultEnum: string
{
    case ALLWAYS = 'allways';
    case ALLOWED = 'allowed';
    case BROKEN = 'broken';
}
