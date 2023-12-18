<?php

namespace App\Models\ReportTreatments\Treatment;

use Illuminate\Support\Carbon;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentStateEnum;
use function config;

trait TreatmentAttempting
{
    public function incrementAttempts(Treatment|null $child_treatment, bool $save) {
        if ( is_null($child_treatment) ) {
            $this->attempts += 1;
        } else {
            // upper treatment increment attempts
            if ($child_treatment->attempts > $this->attempts) {
                $this->attempts = $child_treatment->attempts;
            }
        }
        if ($save) $this->save();
        /*if ( ($this->isFailed && $this->isWaiting) || $this->isCompleted ) {
            $this->attempts += 1;
            if ($save) $this->save();
        }*/
    }

    /**
     * Update retries infos
     * @return void
     */
    public function updateRetries(Treatment|null $child_treatment) {
        if ( $this->attempts > 1 ) {

            // La deuxieme tentative marque le debtut des reessais
            if ( $this->attempts === 2 ) {
                $this->retry_start_at = Carbon::now();
            }

            $max_retries = config('Settings.treatment.max_retries');

            if ( $this->retries_session_count >= $max_retries ) {
                $this->setState(TreatmentStateEnum::ALLTRIED);
            }

            $this->incrementRetriesSessionCount($child_treatment, false);
            $this->retry_end_at = Carbon::now();

            $this->save();
        }
    }

    public function incrementRetriesSessionCount(Treatment|null $child_treatment, bool $save = true) {
        if ( is_null($child_treatment) ) {
            $this->retries_session_count += 1;
        } else {
            // upper treatment retries session count
            if ($child_treatment->retries_session_count > $this->retries_session_count) {
                $this->retries_session_count = $child_treatment->retries_session_count;
            }
        }

        if ($save) $this->save();
    }

    public function resetRetrySession() {
        $this->retries_session_count = 0;
        $this->save();
    }
}
