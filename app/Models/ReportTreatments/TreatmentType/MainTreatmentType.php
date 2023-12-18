<?php

namespace App\Models\ReportTreatments\TreatmentType;


use App\Models\SystemLog;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Contracts\ReportTreatment\ITreatmentType;

class MainTreatmentType implements ITreatmentType
{
    public static string $MAIN_TREATMENT_LOG_INFO_PART = "maintype";


    public static function preEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null): bool
    {
        if ( is_null( $child_treatment ) ) {
            \Log::error("Ending Main. NO Child");
            return false;
        }

        $can_switch_to_next = ($child_treatment->isCompleted && $child_treatment->isSuccess);
        $next_workflowstep = $treatment->getNextWorkflowStepFromTreatment($child_treatment);
        $next_treatmentstep = null;

        SystemLog::infoTreatments("Ending Main Treatment; - Child, state: " . $child_treatment?->state?->value . ", isCompleted: " . ( $child_treatment->isCompleted ? "yes" : "no" ) . ", result: " . $child_treatment?->treatmentresult?->result?->value . "; isSuccess: " . ( $child_treatment?->isSuccess ? "yes" : "no" ), self::$MAIN_TREATMENT_LOG_INFO_PART);

        if ( $can_switch_to_next ) {
            $next_treatmentstep = $treatment->switchToNextStep($next_workflowstep);
        }

        SystemLog::infoTreatments("Ending Main Treatment; " . ( is_null($next_treatmentstep) ? "NO Switch" : "Switching to Next Step: " . $next_treatmentstep->name ), self::$MAIN_TREATMENT_LOG_INFO_PART);

        /**  condition de Fin de Traitement:
         *      - tous les traitements enfants sont completes (celui-ci est le dernier)
         *      - on peut aller a l'etape suivante
         *      - et il n'y a pas d'etape a la suite
         */
        $complete_treatment = $child_treatment->isLastTreatmentToProcess() && $can_switch_to_next && is_null($next_workflowstep);

        //$next_workflowstep_from = $treatment->reportfile->report->getNextWorkflowStepFrom($next_treatmentstep->code);
        /*if ( is_null($next_treatmentstep) ) {
            $treatment->setAllSubTreatmentsLaunched(true);
        }*/

        SystemLog::infoTreatments("Ending Main Treatment; complete_treatment: " . ( $complete_treatment ? "yes" : "no" ), self::$MAIN_TREATMENT_LOG_INFO_PART);
        return $complete_treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false)
    {
        \Log::info("MainTreatmentType - postEnding");
    }
}
