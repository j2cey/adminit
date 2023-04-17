<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum ValueTypeEnum:string
{
    use EnumTrait;

    #[Description('Chaine carateres')]
    case STRING = 'string';

    #[Description('Entier')]
    case INT = 'int';

    #[Description('Date-Heure')]
    case DATETIME = 'datetime';

    #[Description('Booleen')]
    case BOOLEAN = 'boolean';
}
