<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum TreatmentResultEnum: string
{
    use EnumTrait;

    #[Description('Auncun')]
    case NONE = 'none';

    #[Description('Succes')]
    case SUCCESS = 'success';

    #[Description('Echec')]
    case FAILED = 'failed';
}
