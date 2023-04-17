<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum CriticalityLevelEnum: string
{
    use EnumTrait;

    #[Description('Eleve')]
    case HIGH = 'high';

    #[Description('Moyen')]
    case MEDIUM = 'medium';

    #[Description('Bas')]
    case LOW = 'low';
}
