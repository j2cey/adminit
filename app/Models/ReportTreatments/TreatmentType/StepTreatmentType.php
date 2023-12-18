<?php

namespace App\Models\ReportTreatments\TreatmentType;

use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Contracts\ReportTreatment\ITreatmentType;

class StepTreatmentType implements ITreatmentType
{

    public static function preEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null): bool
    {
        return $treatment->defaultPreEnding($treatmentresultenum, $child_treatment);
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false)
    {
        \Log::info("StepTreatmentType - postEnding");
    }
}
