<?php

namespace App\Traits\TreatmentResult;

use App\Enums\Treatments\TreatmentResultEnum;

trait IsTreatmentResultEnum
{
    public function succeed(): bool
    {
        return $this === TreatmentResultEnum::SUCCESS;
    }

    public function failed(): bool
    {
        return $this === TreatmentResultEnum::FAILED;
    }
}
