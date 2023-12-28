<?php

namespace App\Enums\Treatments;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;
use App\Enums\Attributes\ServiceClass;
use App\Models\Treatments\TreatmentType\MainTreatmentType;
use App\Models\Treatments\TreatmentType\StepTreatmentType;
use App\Models\Treatments\TreatmentType\OperationTreatmentType;

enum TreatmentTypeEnum: string
{
    use EnumTrait;

    #[Description('Main Treatment')]
    #[ServiceClass(MainTreatmentType::class)]
    case Main = 'main';

    #[Description('Treatment Step')]
    #[ServiceClass(StepTreatmentType::class)]
    case STEP = 'step';

    #[Description('Treatment Operation')]
    #[ServiceClass(OperationTreatmentType::class)]
    case OPERATION = 'operation';
}
