<?php

namespace App\Services;

use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;

class TreatmentStageFunction
{
    private TreatmentStage $_stage;
    private string $_function_name;
    private ?string $_description;

    // default parameters
    private CriticalityLevelEnum $_criticality_level;
    private bool $_is_last_subtreatment;
    private bool $_can_end_uppertreatment;

    public function __construct(TreatmentStage $stage, string $function_name, CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, string|null $description)
    {
        $this->setStage($stage);
        $this->setFunctionName($function_name);

        $this->setCriticalityLevel($criticality_level);
        $this->setIsLastSubtreatment($is_last_subtreatment);
        $this->setCanEndUppertreatment($can_end_uppertreatment);

        $this->setDescription($description);
    }

    #region Public Functions
    public function exec() {
        if ( is_callable(array($this->getStage()->getServiceObject(), $this->getFunctionName())) ) {
            $args = [
                'criticality_level' => $this->getCriticalityLevel(),
                'is_last_subtreatment' => $this->isLastSubtreatment(),
                'can_end_uppertreatment' => $this->canEndUppertreatment(),
            ];
            return call_user_func_array(array($this->getStage()->getServiceObject(), $this->getFunctionName()), $args);
        } else {
            \Log::error($this->getStage()->getServiceObject(). ", " . $this->getFunctionName() . " is not callable !");
        }
        return null;
    }

    public function exec_old() {
        if ( is_callable(array($this->getStage()->getServiceObject(), $this->getFunctionName())) ) {
            return $this->getStage()->getServiceObject()->{$this->getFunctionName()}(criticality_level: $this->getCriticalityLevel(), is_last_subtreatment: $this->isLastSubtreatment(), can_end_uppertreatment: $this->canEndUppertreatment());
        } else {
            \Log::error($this->getStage()->getServiceObject(). ", " . $this->getFunctionName() . " is not callable !");
        }
        return null;
    }
    #endregion

    #region Private Functions
    #endregion

    #region Getters & Setters
    /**
     * @return TreatmentStage
     */
    public function getStage(): TreatmentStage
    {
        return $this->_stage;
    }

    /**
     * @param TreatmentStage $stage
     */
    public function setStage(TreatmentStage $stage): void
    {
        $this->_stage = $stage;
    }

    /**
     * @return string
     */
    public function getFunctionName(): string
    {
        return $this->_function_name;
    }

    /**
     * @param string $function_name
     */
    public function setFunctionName(string $function_name): void
    {
        $this->_function_name = $function_name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->_description = $description;
    }
    #endregion

    #region Getters & Setters
    /**
     * @return bool
     */
    public function canEndUppertreatment(): bool
    {
        return $this->_can_end_uppertreatment;
    }

    /**
     * @param bool $can_end_uppertreatment
     */
    public function setCanEndUppertreatment(bool $can_end_uppertreatment): void
    {
        $this->_can_end_uppertreatment = $can_end_uppertreatment;
    }

    /**
     * @return bool
     */
    public function isLastSubtreatment(): bool
    {
        return $this->_is_last_subtreatment;
    }

    /**
     * @param bool $is_last_subtreatment
     */
    public function setIsLastSubtreatment(bool $is_last_subtreatment): void
    {
        $this->_is_last_subtreatment = $is_last_subtreatment;
    }

    /**
     * @return CriticalityLevelEnum
     */
    public function getCriticalityLevel(): CriticalityLevelEnum
    {
        return $this->_criticality_level;
    }

    /**
     * @param CriticalityLevelEnum $criticality_level
     */
    public function setCriticalityLevel(CriticalityLevelEnum $criticality_level): void
    {
        $this->_criticality_level = $criticality_level;
    }
    #endregion
}