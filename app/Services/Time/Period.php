<?php

namespace App\Services\Time;

use Illuminate\Support\Carbon;

class Period
{
    private Carbon $_start_at;
    private Carbon $_end_at;
    private \DateInterval $_duration;
    private float $_duration_seconds;
    private float $_duration_milliseconds;
    private float $_duration_microseconds;
    private string $_duration_hhmmss;

    public function __construct(Carbon $start_at)
    {
        $this->setStartAt($start_at);
    }

    public static function start(Carbon $start_at = null): Period
    {
        if ( is_null($start_at) ) {
            return new Period(Carbon::now());
        }
        return new Period($start_at);
    }

    public function end(Carbon $end_at = null): static
    {
        $this->setEndAt(is_null($end_at) ? Carbon::now() : $end_at);

        $this->setDuration( $this->getStartAt()->diff($this->getEndAt()) );
        $this->setDurationSeconds( $this->getStartAt()->diffInSeconds( $this->getEndAt() ) );
        $this->setDurationMilliseconds( $this->getStartAt()->diffInMilliseconds( $this->getEndAt() ) );
        $this->setDurationMicroseconds( $this->getStartAt()->diffInMicroseconds( $this->getEndAt() ) );
        $this->setDurationHhmmss( gmdate( 'H:i:s', $this->getDurationSeconds() ) );

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getStartAt(): Carbon
    {
        return $this->_start_at;
    }

    /**
     * @param Carbon $start_at
     */
    public function setStartAt(Carbon $start_at): void
    {
        $this->_start_at = $start_at;
    }

    /**
     * @return Carbon
     */
    public function getEndAt(): Carbon
    {
        return $this->_end_at;
    }

    /**
     * @param Carbon $end_at
     */
    public function setEndAt(Carbon $end_at): void
    {
        $this->_end_at = $end_at;
    }

    /**
     * @return float
     */
    public function getDuration(): \DateInterval
    {
        return $this->_duration;
    }

    /**
     * @param float $duration
     */
    public function setDuration(\DateInterval $duration): void
    {
        $this->_duration = $duration;
    }

    /**
     * @return string
     */
    public function getDurationHhmmss(): string
    {
        return $this->_duration_hhmmss;
    }

    /**
     * @param string $duration_hhmmss
     */
    public function setDurationHhmmss(string $duration_hhmmss): void
    {
        $this->_duration_hhmmss = $duration_hhmmss;
    }

    /**
     * @return float
     */
    public function getDurationSeconds(): float
    {
        return $this->_duration_seconds;
    }

    /**
     * @param float $duration_seconds
     */
    public function setDurationSeconds(float $duration_seconds): void
    {
        $this->_duration_seconds = $duration_seconds;
    }

    /**
     * @return float
     */
    public function getDurationMicroseconds(): float
    {
        return $this->_duration_microseconds;
    }

    /**
     * @param float $duration_microseconds
     */
    public function setDurationMicroseconds(float $duration_microseconds): void
    {
        $this->_duration_microseconds = $duration_microseconds;
    }

    /**
     * @return float
     */
    public function getDurationMilliseconds(): float
    {
        return $this->_duration_milliseconds;
    }

    /**
     * @param float $duration_milliseconds
     */
    public function setDurationMilliseconds(float $duration_milliseconds): void
    {
        $this->_duration_milliseconds = $duration_milliseconds;
    }
}
