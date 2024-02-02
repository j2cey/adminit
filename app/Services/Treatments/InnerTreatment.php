<?php

namespace App\Services\Treatments;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;

class InnerTreatment
{
    private string $_key;
    private string $_code;
    private Treatment|null $treatment;
    private bool|null $_isSuccess = null;
    private string|null $_resultMessage = null;
    private Carbon $_startAt;
    private Carbon|null $_endAt = null;
    private string $_name;
    private string|null $_description = null;

    private CriticalityLevelEnum $criticalitylevel;
    private bool $is_last_subtreatment;
    private bool $can_end_uppertreatment;
    private bool $can_start_uppertreatment;

    public function __construct(Treatment $treatment, TreatmentCodeEnum $treatmentcode, CriticalityLevelEnum $criticalitylevel, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $can_start_uppertreatment, string|null $description, array $old_innertreatment_arr = [], string|null $key = null)
    {
        $this->setName($treatmentcode->toArray()['name']);
        $this->setCode($treatmentcode->value);
        $this->setDescription($description);

        $this->setCriticalitylevel($criticalitylevel);
        $this->setIsLastSubtreatment($is_last_subtreatment);
        $this->setCanEndUppertreatment($can_end_uppertreatment);
        $this->setCanStartUppertreatment($can_start_uppertreatment);
        $this->setTreatment($treatment);

        if ( empty($old_innertreatment_arr) ) {
            $this->setKey(null);
            $this->setStartAt(null);

            if ($this->canStartUppertreatment() && (!$treatment->isStarting) && (!$treatment->isRunning)) {
                $treatment->starting();
            }
            $this->registerInnerTreatment();
        } else {
            $this->setKey($key);
            $this->setStartAt( Carbon::createFromFormat("Y-m-d H:i:s", $old_innertreatment_arr['start_at'] ) );
        }
        ExecTrace::dispatch($treatment,$treatmentcode,"new inner-treatment: " . $this->getName(),$this->getDescription());
    }

    public function succeed(string|null $msg): static
    {
        return $this->endInnerTreatment(true, $msg);
    }
    public function failed(string $msg): static
    {
        return $this->endInnerTreatment(false, $msg);
    }

    private function registerInnerTreatment() {
        $innertreatments_arr = [];
        if ( ! is_null($this->getTreatment()->innertreatments) ) {
            $innertreatments_arr = json_decode($this->getTreatment()->innertreatments, true);
        }

        $innertreatments_arr[$this->getKey()] = [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'start_at' => $this->getStartAt()->toDateTimeString(),
            'start_at_timestamp' => $this->getStartAt()->timestamp,
            'end_at' => is_null( $this->getEndAt() ) ? null : $this->getEndAt()->toDateTimeString(),
            'end_at_timestamp' => is_null( $this->getEndAt() ) ? null : $this->getEndAt()->timestamp,
            'result' => is_null( $this->isSuccess() ) ? null : ($this->isSuccess() ? "success" : "FAILED"),
            'message' => $this->getResultMessage(),

            'criticality_level' => $this->getCriticalitylevel()->value,
            'is_last_subtreatment' => $this->isLastSubtreatment(),
            'can_end_uppertreatment' => $this->canEndUppertreatment(),
            'can_start_uppertreatment' => $this->canStartUppertreatment(),

            'description' => $this->getDescription(),
        ];

        $this->getTreatment()->update(['innertreatments' => json_encode($innertreatments_arr)]);
    }

    private function endInnerTreatment(bool $result, string|null $msg): static
    {
        $this->setEndAt();
        $this->setIsSuccess($result);
        if ( ! is_null($msg) ) {
            $this->setResultMessage($msg);
        }

        $this->registerInnerTreatment();

        if ( $this->isLastSubtreatment() && $this->canEndUppertreatment() ) {
            $this->endingTreatment();
        }

        ExecTrace::dispatch($this->getTreatment(), TreatmentCodeEnum::from( $this->getCode() ),"end inner-treatment: " . $this->getName(),$this->getDescription());

        return $this;
    }

    private function endingTreatment() {
        if ( $this->isSuccess() ) {
            $this->getTreatment()->endingWithSuccess( $this->getResultMessage() );
        } else {
            $this->getTreatment()->endingWithFailure( $this->getResultMessage() );
        }
    }

    public function unsetTreatment(): static
    {
        $this->treatment = null;
        return $this;
    }
    public static function getByKey(Treatment $treatment, string $key): ?InnerTreatment
    {
        $innertreatments_arr = json_decode($treatment->innertreatments, true);
        if ( key_exists($key, $innertreatments_arr) ) {
            $innertreatment_arr = $innertreatments_arr[$key];
            return new InnerTreatment($treatment, TreatmentCodeEnum::from($innertreatment_arr['code']), CriticalityLevelEnum::from($innertreatment_arr['criticality_level']), (bool)$innertreatment_arr['is_last_subtreatment'], (bool)$innertreatment_arr['can_end_uppertreatment'], (bool)$innertreatment_arr['can_start_uppertreatment'], null, $innertreatment_arr, $key );
        }
        return null;
    }

    #region Getters & Setters
    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->_key;
    }

    /**
     */
    public function setKey(string|null $key): void
    {
        if ( is_null( $key ) ) {
            $this->_key = Str::orderedUuid();
        } else {
            $this->_key = $key;
        }
    }
    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->_code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->_code = $code;
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
     * @return bool|null
     */
    public function isSuccess(): ?bool
    {
        return $this->_isSuccess;
    }

    /**
     * @param bool $isSuccess
     */
    public function setIsSuccess(bool $isSuccess): void
    {
        $this->_isSuccess = $isSuccess;
    }

    /**
     * @return Treatment
     */
    public function getTreatment(): Treatment
    {
        return $this->treatment;
    }

    /**
     * @param Treatment $treatment
     */
    public function setTreatment(Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    /**
     * @return string|null
     */
    public function getResultMessage(): ?string
    {
        return $this->_resultMessage;
    }

    /**
     * @param string $resultMessage
     */
    public function setResultMessage(string $resultMessage): void
    {
        $this->_resultMessage = $resultMessage;
    }

    /**
     * @return Carbon
     */
    public function getStartAt(): Carbon
    {
        return $this->_startAt;
    }

    /**
     */
    public function setStartAt(Carbon|null $start_time): void
    {
        if ( is_null( $start_time ) ) {
            $this->_startAt = Carbon::now();
        } else {
            $this->_startAt = $start_time;
        }
    }

    /**
     */
    public function setEndAt()
    {
        $this->_endAt = Carbon::now();
    }

    /**
     * @return Carbon|null
     */
    public function getEndAt(): ?Carbon
    {
        return $this->_endAt;
    }

    /**
     * @return CriticalityLevelEnum
     */
    public function getCriticalitylevel(): CriticalityLevelEnum
    {
        return $this->criticalitylevel;
    }

    /**
     * @param CriticalityLevelEnum $criticalitylevel
     */
    public function setCriticalitylevel(CriticalityLevelEnum $criticalitylevel): void
    {
        $this->criticalitylevel = $criticalitylevel;
    }

    /**
     * @return bool
     */
    public function isLastSubtreatment(): bool
    {
        return $this->is_last_subtreatment;
    }

    /**
     * @param bool $is_last_subtreatment
     */
    public function setIsLastSubtreatment(bool $is_last_subtreatment): void
    {
        $this->is_last_subtreatment = $is_last_subtreatment;
    }

    /**
     * @return bool
     */
    public function canEndUppertreatment(): bool
    {
        return $this->can_end_uppertreatment;
    }

    /**
     * @param bool $can_end_uppertreatment
     */
    public function setCanEndUppertreatment(bool $can_end_uppertreatment): void
    {
        $this->can_end_uppertreatment = $can_end_uppertreatment;
    }
    /**
     * @return bool
     */
    public function canStartUppertreatment(): bool
    {
        return $this->can_start_uppertreatment;
    }

    /**
     * @param bool $can_start_uppertreatment
     */
    public function setCanStartUppertreatment(bool $can_start_uppertreatment): void
    {
        $this->can_start_uppertreatment = $can_start_uppertreatment;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->_description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(string|null $description): void
    {
        $this->_description = is_null( $description ) ? null : $description;
    }
    #endregion
}
