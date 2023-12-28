<?php

namespace App\Services;

use App\Jobs\ExecTraceJob;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;

class ExecTrace
{
    private string $_key;
    private string|null $_code = null;
    private Treatment|null $treatment;
    private Carbon $_traceAt;
    private string $_message;
    private string|null $_description = null;

    public function __construct(Treatment|null $treatment, TreatmentCodeEnum|null $treatmentcode, string $message, string|null $description)
    {
        $this->setKey(null);
        $this->setTreatment($treatment);
        $this->setCode($treatmentcode?->value);
        $this->setMessage($message);
        $this->setDescription($description);

        $this->setTraceAt(null);
    }

    private function registerTreatment(): static
    {
        $exectrace_arr = [];
        if ( ! is_null($this->getTreatment()->exectrace) ) {
            $exectrace_arr = json_decode($this->getTreatment()->exectrace, true);
        }

        $exectrace_arr[$this->getKey()] = [
            'code' => $this->getCode(),
            'trace_at' => $this->getTraceAt()->toDateTimeString(),
            'trace_at_timestamp' => $this->getTraceAt()->timestamp,
            'message' => $this->getMessage(),
            'description' => $this->getDescription(),
        ];

        $this->getTreatment()->update(['exectrace' => json_encode($exectrace_arr)]);

        return $this;
    }

    public static function dispatch(Treatment $treatment, TreatmentCodeEnum|null $treatmentcode, string $message, string|null $description) {
        dispatch(new ExecTraceJob($treatment, $treatmentcode, $message, $description));
    }

    public static function register(Treatment $treatment, TreatmentCodeEnum|null $treatmentcode, string $message, string|null $description): ExecTrace
    {
        return ( new ExecTrace($treatment, $treatmentcode, $message, $description) )->registerTreatment();
    }

    private function getArrayAsc(array $exectrace_arr): array
    {
        return $exectrace_arr[$this->getKey()] = [
            'code' => $this->getCode(),
            'trace_at' => $this->getTraceAt()->toDateTimeString(),
            'trace_at_timestamp' => $this->getTraceAt()->timestamp,
            'message' => $this->getMessage(),
            'description' => $this->getDescription(),
        ];
    }

    private function getArrayDesc(array $exectrace_arr): array
    {
        return array_merge( [$this->getKey() => [
            'code' => $this->getCode(),
            'trace_at' => $this->getTraceAt()->toDateTimeString(),
            'trace_at_timestamp' => $this->getTraceAt()->timestamp,
            'message' => $this->getMessage(),
            'description' => $this->getDescription(),
        ]] , $exectrace_arr);
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
     * @param string|null $key
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
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->_code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->_code = $code;
    }

    /**
     * @return Treatment|null
     */
    public function getTreatment(): ?Treatment
    {
        return $this->treatment;
    }

    /**
     * @param Treatment|null $treatment
     */
    public function setTreatment(?Treatment $treatment): void
    {
        $this->treatment = $treatment;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->_message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->_message = $message;
    }

    /**
     * @return Carbon
     */
    public function getTraceAt(): Carbon
    {
        return $this->_traceAt;
    }

    /**
     * @param Carbon|null $traceAt
     */
    public function setTraceAt(Carbon|null $traceAt): void
    {
        if ( is_null( $traceAt ) ) {
            $this->_traceAt = Carbon::now();
        } else {
            $this->_traceAt = $traceAt;
        }
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
    public function setDescription(?string $description): void
    {
        $this->_description = is_null( $description ) ? null : $description;
    }
    #endregion
}
