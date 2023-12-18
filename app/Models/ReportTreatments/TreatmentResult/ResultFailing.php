<?php

namespace App\Models\ReportTreatments\TreatmentResult;

use App\Enums\Treatments\TreatmentStateEnum;
use App\Enums\Treatments\TreatmentResultEnum;

trait ResultFailing
{
    public function setFailed(string $message, bool $save = true) {

        $this->result = TreatmentResultEnum::FAILED;
        $this->treatment->setState(TreatmentStateEnum::WAITING);

        $this->setMessage($message);

        if ( $save ) $this->save();
    }
}
