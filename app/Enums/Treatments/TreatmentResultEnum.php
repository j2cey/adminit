<?php

namespace App\Enums\Treatments;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;
use App\Traits\TreatmentResult\IsTreatmentResultEnum;

enum TreatmentResultEnum: string
{
    use EnumTrait, IsTreatmentResultEnum;

    #[Description('Auncun')]
    case NONE = 'none';

    #[Description('Succes')]
    case SUCCESS = 'success';

    #[Description('Echec')]
    case FAILED = 'failed';
}
