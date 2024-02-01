<?php

namespace App\Contracts\ReportTreatment;

use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentResultEnum;

interface ITreatmentType
{
    public static function preEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, bool $child_completed = false): bool;
    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false);
}
