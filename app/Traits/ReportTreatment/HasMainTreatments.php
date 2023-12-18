<?php

namespace App\Traits\ReportTreatment;


use App\Models\SystemLog;
use App\Models\ReportTreatments\Treatment;

trait HasMainTreatments
{
    public static string $MAINTREATMENT_LOG_INFO_PART = "maintreatment";

    public function maintreatments() {
        return $this->hasMany(Treatment::class,'report_file_id')->whereNull('uppertreatment_id');
    }
    public function addMainTreatment(string $name, bool $dispatch_on_creation, array $payloads, string|null $description): ?Treatment {

        $treatment = Treatment::createMain($name, $dispatch_on_creation, $payloads, $this, $description);

        SystemLog::infoTreatments("HasMainTreatments addMainTreatment " . get_class($this) . "(" . $this->id . "), treatment created: " . $treatment?->name . " (" . $treatment?->id . ")", self::$MAINTREATMENT_LOG_INFO_PART);

        //$treatment->setReportFile($this);
        $treatment->createFirstStep();

        return $treatment;
    }
    public function firstTreatmentWaiting(): Treatment {
        return $this->maintreatments()->waiting()->first();
    }

    public function exec() {

        if ( $this->maintreatments()->waiting()->count() === 0 && $this->maintreatments()->running()->count() === 0 && $this->maintreatments()->queued()->count() === 0 ) {
            SystemLog::infoTreatments("HasMainTreatments exec. Create New Treatment for model: " . get_class($this) . "(" . $this->id . ")", self::$MAINTREATMENT_LOG_INFO_PART);
            /** Ce fichier n'a
             *      - aucun traitement en attente
             *      - aucun traitement en cours d'execution
             *      - aucun traitement en file d'attente
             *
             *  Alors, on peut lancer au nouveau Traitement pour ce fichier
             */
            $treatment = $this->createNewTreatment();
            SystemLog::infoTreatments("HasMainTreatments exec, NewTreatment created: " . $treatment->name . "(" . $treatment->id . ")", self::$MAINTREATMENT_LOG_INFO_PART);
            //$treatment->fresh();
            //$treatment->execSubsWaiting();
        } else {
            // On récupère les traitements en cours de ce fichier

            if ( $this->maintreatments()->notstarted()->count() > 0 || $this->maintreatments()->waiting()->count() > 0 ) {
                $waiting_treatment = $this->firstTreatmentWaiting();
                SystemLog::infoTreatments("HasMainTreatments exec. Dispatch 1st Treatment Waiting Or NotStarted for model: " . get_class($this) . " (" . $this->id . ") - Treatment: " . $waiting_treatment->name . "(" . $waiting_treatment->id . ")", self::$MAINTREATMENT_LOG_INFO_PART);
                $waiting_treatment->service->dispatch($this);
            } else {
                \Log::error();
                SystemLog::errorTreatments("HasMainTreatments CANNOT exec for model " . get_class($this) . " (" . $this->id . "). treatments, not started: " . $this->maintreatments()->notstarted()->count() . "; treatments, waiting: " . $this->maintreatments()->waiting()->count() . "; running: " . $this->maintreatments()->running()->count() . "; queued: " . $this->maintreatments()->queued()->count(), self::$MAINTREATMENT_LOG_INFO_PART);
            }
        }
    }

    /**
     * Create a new treatment (ReportTreatmentResult) for this file.
     * @return Treatment|null
     */
    public function createNewTreatment(): ?Treatment
    {
        if ( $this->maintreatments()->waiting()->count() === 0 && $this->maintreatments()->running()->count() === 0 && $this->maintreatments()->queued()->count() === 0 ) {
            SystemLog::infoTreatments("HasMainTreatments createNewTreatment for model " . get_class($this) . " (" . $this->id . ")", self::$MAINTREATMENT_LOG_INFO_PART);
            /** Ce fichier n'a
             *      - aucun traitement en attente
             *      - aucun traitement en cours d'execution
             *      - aucun traitement en file d'attente
             *
             *  Alors, on peut lancer au nouveau Traitement pour ce fichier
             */
            return $this->addMainTreatment("Traitement du fichier " . $this->name, true, [], null);
        } else {
            SystemLog::errorTreatments("HasMainTreatments createNewTreatment CANNOT create for model " . get_class($this) . " (" . $this->id . ")" . ". treatments, not started: " . $this->maintreatments()->notstarted()->count() . "; treatments, waiting: " . $this->maintreatments()->waiting()->count() . "; running: " . $this->maintreatments()->running()->count() . "; queued: " . $this->maintreatments()->queued()->count(), self::$MAINTREATMENT_LOG_INFO_PART);
            return null;
        }
    }

}
