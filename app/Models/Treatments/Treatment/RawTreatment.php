<?php

namespace App\Models\Treatments\Treatment;

use App\Models\SystemLog;
use App\Enums\CriticalityLevelEnum;
use App\Events\LaunchTreatmentEvent;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Model;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentTypeEnum;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentStateEnum;
use function event;

trait RawTreatment
{
    public static string $RAW_TREATMENT_LOG_INFO_PART = "rawtreatment";


    #region Raw Treatment management
    public static function createNew(Treatment|null $uppertreatment, TreatmentTypeEnum|string $type, TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_on_creation, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, array $payloads, ReportFile|null $reportfile, string|null $description): ?Treatment {

        /*$treatment = Treatment::create([
            'type' => $type->value,
            'treatmenttype_class' => $type->toFullArray()['serviceclass'],
            'code' => $code->value,
            'name' => $code->toArray()['name'],
            'criticality_level' => $criticality_level->value,
            'state' => TreatmentStateEnum::NOTSTARTED,
            'dispatch_on_creation' => $dispatch_on_creation,
            'launch_exec_operation_on_creation' => $launch_exec_operation_on_creation,
            'description' => $description,
            //'num_ord' => is_null($num_ord) ? 0 : $num_ord,
            'exec_id' => $exec_id,
        ]);*/


        $treatment = new Treatment();
        $treatment->type = $type;
        $treatment->treatmenttype_class = $type->toFullArray()['serviceclass'];
        $treatment->code = $code;
        $treatment->name = $code->toArray()['name'];
        $treatment->criticality_level = $criticality_level;
        $treatment->state = TreatmentStateEnum::CREATING;
        $treatment->dispatch_on_creation = $dispatch_on_creation;
        $treatment->launch_exec_operation_on_creation = $launch_exec_operation_on_creation;
        $treatment->dispatch_exec_operation_on_creation = $dispatch_exec_operation_on_creation;
        $treatment->description = $description;
        $treatment->level = is_null($uppertreatment) ? 0 : $uppertreatment->level + 1;
        $treatment->exec_id = $exec_id;

        $treatment->uppertreatment_id = is_null( $uppertreatment ) ? null : $uppertreatment->id;
        $treatment->is_last_subtreatment = $is_last_subtreatment;
        $treatment->can_end_uppertreatment = $can_end_uppertreatment;
        $treatment->payload = json_encode( $payloads );

        $treatment->report_file_id = is_null( $reportfile ) ? null : $reportfile->id;

        try {
            $treatment->saveOrFail();

            SystemLog::infoTreatments( "Create New Treatment. " . $type->value . ": " . $code->toArray()['name'] . " (" . $treatment->id . "), uppertreatment: " . ( is_null($uppertreatment) ? "NULL" : $uppertreatment->id ), self::$RAW_TREATMENT_LOG_INFO_PART );

            return $treatment;
        } catch (\Throwable $e) {
            SystemLog::errorTreatments( "Create New Treatment Error: " . $e->getMessage()  . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() . "; \n" . "Trace: " . $e->getTraceAsString() , self::$RAW_TREATMENT_LOG_INFO_PART );
            return $treatment;
        }
    }

    public function saveSubTreatment(Treatment $subtreatment) {
        $subs_count = $this->subtreatments()->count();

        $this->subtreatments()->save($subtreatment);
        $subtreatment->num_ord = $subs_count + 1;
        $subtreatment->save();

        $subtreatment->setReportFile($this->reportfile)
            ->setCollectedReportFile($this->getMainTreatment()->collectedreportfile);
    }

    public function stepAddOrGet(TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool|null $is_last_subtreatment, bool|null $can_end_uppertreatment, bool $dispatch_on_creation, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, array $payloads, string|null $description): ?Treatment {
        if ($this->type == TreatmentTypeEnum::OPERATION) {
            SystemLog::errorTreatments( "Can NOT add a Step to an Operation - operation: " . $this->name . " (" . $this->id . ")", self::$RAW_TREATMENT_LOG_INFO_PART );
            return null;
        }
        return $this->subTreatmentAddOrGet(TreatmentTypeEnum::STEP, $code, $criticality_level, $exec_id, $is_last_subtreatment ?? false, $can_end_uppertreatment ?? false, $dispatch_on_creation, $launch_exec_operation_on_creation, $dispatch_exec_operation_on_creation, $payloads, $description);
    }
    public function operationAddOrGet(TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_on_creation, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, array $payloads, string|null $description): Treatment {
        return $this->subTreatmentAddOrGet(TreatmentTypeEnum::OPERATION, $code, $criticality_level, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, $dispatch_on_creation, $launch_exec_operation_on_creation, $dispatch_exec_operation_on_creation, $payloads, $description);
    }
    public function subTreatmentAddOrGet(TreatmentTypeEnum|string $type, TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_on_creation, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, array $payloads, string|null $description): Treatment|Model {
        $subtreatment = $this->subtreatments()->where('code', $code->value)->where('exec_id', $exec_id)->first();
        if ($subtreatment) {
            return $subtreatment;
        }
        return self::createNew($this, $type, $code, $criticality_level, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, $dispatch_on_creation, $launch_exec_operation_on_creation, $dispatch_exec_operation_on_creation, $payloads, null, $description);
    }

    public function launchNewSubTreatment(TreatmentTypeEnum|string $type, TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $payloads, bool $dispatch_on_creation, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, string|null $description): Treatment {
        $subtreatment = $this->subTreatmentAddOrGet($type, $code, $criticality_level, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, $dispatch_on_creation, $launch_exec_operation_on_creation, $dispatch_exec_operation_on_creation, $payloads, $description);

        $subtreatment->setIsLastSubtreatment($is_last_subtreatment, $this);
        $subtreatment->setCanEndUpperTreatment($can_end_uppertreatment);

        //$subtreatment->service->setReportFile($this->service->reportfile);

        event( new LaunchTreatmentEvent($subtreatment, $this->service->getReportfile()) );

        return $subtreatment;
    }
    public function launchNewSubStep(TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, array $payloads, string|null $description): Treatment {
        return $this->launchNewSubTreatment(TreatmentTypeEnum::STEP, $code, $criticality_level, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, $payloads, false, $launch_exec_operation_on_creation, $dispatch_exec_operation_on_creation, $description);
    }
    public function launchNewSubOperation(TreatmentCodeEnum|string $code, CriticalityLevelEnum|string $criticality_level, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $payloads, bool $dispatch_on_creation, bool $launch_exec_operation_on_creation, bool $dispatch_exec_operation_on_creation, string|null $description): Treatment {
        return $this->launchNewSubTreatment(TreatmentTypeEnum::OPERATION, $code, $criticality_level, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, $payloads, $dispatch_on_creation, $launch_exec_operation_on_creation, $dispatch_exec_operation_on_creation, $description);
    }

    /**
     * @param TreatmentCodeEnum $uppertreatment_code
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param array $nexttreatment_payloads
     * @param bool $dispatch_exec_operation_on_creation
     * @return void
     */
    public function launchToGivenUpperStep(TreatmentCodeEnum $uppertreatment_code, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_exec_operation_on_creation) {
        $stepTreatment = $this->getMainTreatment()->stepAddOrGet($uppertreatment_code, CriticalityLevelEnum::HIGH, 0, false, true, false, true, $dispatch_exec_operation_on_creation, $nexttreatment_payloads, null);

        /*
        if ( is_null($stepTreatment) ) {
            SystemLog::errorTreatments( "launchToGivenUpperStep. STEP NOT CREATED. Treatment " . $this->name . " (" . $this->id. ") ", self::$RAW_TREATMENT_LOG_INFO_PART );
            return null;
        }
        $max_waits = 0;
        while ( is_null($stepTreatment->service) && ( $max_waits < 10 ) ) {
            sleep(5);
            $max_waits++;
        }
        if ( is_null($stepTreatment->service) ) {
            SystemLog::errorTreatments( "launchToGivenUpperStep. SERVICE NOT CREATED. after " . ( 5 * $max_waits ) . " sec. Treatment: " . $stepTreatment->name . " (" . $stepTreatment->id. ") ", self::$RAW_TREATMENT_LOG_INFO_PART );
            return null;
        }
        return $stepTreatment->service->launchExecOpertion($nexttreatment_payloads, $stepTreatment->service->getNextExecId(), $is_last_subtreatment, $can_end_uppertreatment, $dispatch_on_creation);
        */
    }

    public function launchUpperStep(TreatmentCodeEnum $uppertreatment_code, array $payloads, bool $dispatch_on_creation, string|null $description): ?Treatment
    {
        return $this->getMainTreatment()->stepAddOrGet($uppertreatment_code, CriticalityLevelEnum::HIGH, 0, false, true, $dispatch_on_creation, false, false, $payloads, $description);
    }

    public static function getById(int|null $id): ?Treatment {
        if ( is_null($id) ) {
            return null;
        }
        return Treatment::find($id);
    }
    #endregion
}
