<?php

namespace App\Services;

use JetBrains\PhpStorm\Pure;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;

/**
 * Class TreatmentStage Encapsulates a treatment execution logic
 * @package App\Services
 */
class TreatmentStage
{
    private object $_service_object;
    private int $_stageId = 1;  // The ID/Number (in the execution order) of this stage
    private bool $_is_beark_point;

    private string $_name;
    private ?TreatmentStageFunction $_stage_function = null;
    private ?TreatmentStage $_next_stage_on_success = null;
    private ?TreatmentStage $_next_stage_on_failure = null;
    private ?TreatmentStage $_previous_stage = null;
    private ?int $_stage_result = null;

    private Treatment $_treatment;

    public function __construct(Treatment $treatment, object $service_object, string $name, TreatmentStageFunction|null $stage_function, bool $is_beark_point)
    {
        $this->setTreatment($treatment);
        $this->setServiceClass($service_object);
        $this->setName($name);
        $this->setStageFunction($stage_function);
        $this->setIsBearkPoint($is_beark_point);
    }

    public function addNextStageOnSuccess(string $name, bool $is_beark_point, string $function_name, CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, array|null $append_args, string|null $function_description): TreatmentStage
    {
        $this->setNextStageOnSuccess($this->newSubStage($name, $is_beark_point, $function_name, $criticality_level, $is_last_subtreatment, $can_end_uppertreatment, $append_args, $function_description));

        return $this->getNextStageOnSuccess();
    }
    public function addNetStageOnFailure(string $name, bool $is_beark_point, string $function_name, CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, array|null $append_args, string|null $function_description): TreatmentStage
    {
        $this->setNextStageOnFailure($this->newSubStage($name, $is_beark_point, $function_name, $criticality_level, $is_last_subtreatment, $can_end_uppertreatment, $append_args, $function_description));

        return $this->getNextStageOnFailure();
    }

    private function newSubStage(string $name, bool $is_beark_point, string $function_name, CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, array|null $append_args, string|null $function_description): TreatmentStage {
        $sub_stage = new TreatmentStage($this->getTreatment(), $this->getServiceObject(), $name, null, $is_beark_point);
        $sub_stage->setPreviousStage($this);
        $sub_stage->setFunction($function_name, $criticality_level, $is_last_subtreatment, $can_end_uppertreatment, $append_args, $function_description);
        $sub_stage->setStageId($this->getStageId() + 1);

        return $sub_stage;
    }

    public function setFunction(string $function_name, CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, array|null $append_args, string|null $description): TreatmentStageFunction
    {
        $this->setStageFunction(new TreatmentStageFunction($this, $function_name, $criticality_level, $is_last_subtreatment, $can_end_uppertreatment, $append_args, $description));
        return $this->getStageFunction();
    }

    #region Public Functions
    public function exec(int $break_point): ?int
    {
        $this->getTreatment()->progressionSetCurrentStep( $this->getStageFunction()->getFunctionName() ?? $this->getName() );
        //\Log::info("exec Stage: " . $this->getName() . ", Function: " . $this->getStageFunction()->getFunctionName());
        // exec this stage's function
        if ( $this->getStageId() > $break_point ) {
            $this->setStageResult($this->getStageFunction()->exec());
        }
        //\Log::info("func_result: " . $this->getStageResult());

        // get next stage if any
        $next_stage = $this->getNextStage($break_point);

        if ( is_null( $next_stage ) ) {
            //\Log::info("END of STAGES func_result: " . $this->getStageResult());
            return $this->getStageResult();
        } else {
            $this->setStageResult(1);
        }

        // exec next stage
        return $next_stage->exec($break_point);
    }
    #endregion

    #region Private Functions

    #[Pure] private function getNextStage(int &$break_point): ?TreatmentStage
    {
        if ( is_null($this->getStageResult()) ) {
            return null;
        }
        if ( $this->getStageResult() > 0 ) {
            if ( $this->isBearkPoint() ) {
                $break_point = $this->getStageId();
                $this->getTreatment()->setBreakPoint($break_point);
            }
            return $this->getNextStageOnSuccess();
        }
        return $this->getNextStageOnFailure();
    }

    #endregion

    #region Getters & Setters
    /**
     * @return object
     */
    public function getServiceObject(): object
    {
        return $this->_service_object;
    }

    /**
     * @param object $service_object
     */
    public function setServiceClass(object $service_object): void
    {
        $this->_service_object = $service_object;
    }

    /**
     * @return int
     */
    public function getStageId(): int
    {
        return $this->_stageId;
    }

    /**
     * @param int $stageId
     */
    public function setStageId(int $stageId): void
    {
        $this->_stageId = $stageId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @return TreatmentStageFunction
     */
    public function getStageFunction(): TreatmentStageFunction
    {
        return $this->_stage_function;
    }

    /**
     * @param TreatmentStageFunction|null $stage_function
     */
    public function setStageFunction(TreatmentStageFunction|null $stage_function): void
    {
        if ( ! is_null( $stage_function ) ) {
            $stage_function->setStage($this);
            $this->_stage_function = $stage_function;
        }
    }

    /**
     * @return TreatmentStage|null
     */
    public function getNextStageOnSuccess(): ?TreatmentStage
    {
        return $this->_next_stage_on_success;
    }

    /**
     * @param TreatmentStage $next_stage
     */
    public function setNextStageOnSuccess(TreatmentStage $next_stage): void
    {
        $this->_next_stage_on_success = $next_stage;
    }

    /**
     * @return TreatmentStage|null
     */
    public function getNextStageOnFailure(): ?TreatmentStage
    {
        return $this->_next_stage_on_failure;
    }

    /**
     * @param TreatmentStage $alternative_stage
     */
    public function setNextStageOnFailure(TreatmentStage $alternative_stage): void
    {
        $this->_next_stage_on_failure = $alternative_stage;
    }

    /**
     * @return TreatmentStage|null
     */
    public function getPreviousStage(): ?TreatmentStage
    {
        return $this->_previous_stage;
    }

    /**
     * @param TreatmentStage|null $previous_stage
     */
    public function setPreviousStage(?TreatmentStage $previous_stage): void
    {
        $this->_previous_stage = $previous_stage;
    }

    /**
     * @return int|null
     */
    public function getStageResult(): ?int
    {
        return $this->_stage_result;
    }

    /**
     * @param int|null $stage_result
     */
    public function setStageResult(?int $stage_result): void
    {
        $this->_stage_result = $stage_result;
    }

    /**
     * @return Treatment
     */
    public function getTreatment(): Treatment
    {
        return $this->_treatment;
    }

    /**
     * @param Treatment $treatment
     */
    public function setTreatment(Treatment $treatment): void
    {
        $this->_treatment = $treatment;
    }

    /**
     * @return bool
     */
    public function isBearkPoint(): bool
    {
        return $this->_is_beark_point;
    }

    /**
     * @param bool $is_beark_point
     */
    public function setIsBearkPoint(bool $is_beark_point): void
    {
        $this->_is_beark_point = $is_beark_point;
    }
    #endregion
}
