<?php

namespace App\Enums\Treatments;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;
use App\Enums\Attributes\ServiceClass;
use App\Models\ReportTreatments\TreatmentType\MainTreatmentType;
use App\Models\ReportTreatments\TreatmentType\StepTreatmentType;
use App\Models\ReportTreatments\TreatmentType\OperationTreatmentType;

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
