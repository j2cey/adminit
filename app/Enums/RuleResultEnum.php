<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum RuleResultEnum: string
{
    use EnumTrait;

    #[Description('Toujours')]
    case ALLWAYS = 'allways';

    #[Description('Suivie')]
    case ALLOWED = 'allowed';

    #[Description('Brisée')]
    case BROKEN = 'broken';
}
