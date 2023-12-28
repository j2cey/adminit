<?php

namespace App\Models\Treatments\TreatmentResult;

use Illuminate\Support\Carbon;
use App\Traits\Time\HasDuration;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentStateEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\Treatments\TreatmentResult;

trait ResultEnding
{
    use HasDuration;

    public function setEnding(Treatment|null $child_treatment, $save = true) {
        if ( is_null($child_treatment) ) {
            $this->treatment->setState(TreatmentStateEnum::FIRSTENDING);
        } else {
            $this->treatment->setState(TreatmentStateEnum::ENDING);
        }
        if ($save) $this->save();
    }

    public function setEnded(Treatment|null $child_treatment, TreatmentResult|null $prev_treatmentresult, TreatmentResultEnum $treatmentresultenum, string $message = null, bool $complete_treatment = false) {

        $end_at = Carbon::now();

        $this->last_exec_end_at = Carbon::now();
        $this->setResult($treatmentresultenum, $message);

        if ($complete_treatment) {
            $this->treatment->setCompleted();

            $this->end_at = $end_at;

            $duration = $this->getNewDuration($this->start_at, $end_at);

            $this->duration = $duration->getDuration();
            $this->duration_hhmmss = $duration->getDurationHhmmss();
        } else {
            $this->treatment->setWaiting(true);
        }

        $this->treatment->updateRetries($child_treatment);
        $this->save();
    }

    public function setEnd(bool $save = true) {
        $this->end_at = Carbon::now();
        $this->treatment->setState(TreatmentStateEnum::COMPLETED);

        if ( $save ) $this->save();
    }
}
