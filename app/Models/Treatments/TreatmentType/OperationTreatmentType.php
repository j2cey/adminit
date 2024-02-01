<?php

namespace App\Models\Treatments\TreatmentType;

use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Contracts\ReportTreatment\ITreatmentType;

class OperationTreatmentType implements ITreatmentType
{

    public static function preEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, bool $child_completed = false): bool
    {
        return $treatment->defaultPreEnding($treatmentresultenum, $child_treatment, $child_completed);
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false)
    {

    }
}
