<?php

namespace App\Traits\Time;

use Illuminate\Support\Carbon;

class Duration
{
    private Carbon $_start_at;
    private Carbon $_end_at;
    private float $_duration;
    private string $_duration_hhmmss;

    public function __construct(Carbon $start_at)
    {
        $this->setStartAt($start_at);
    }

    public function end(Carbon|null $end_at): static
    {
        $this->setEndAt($end_at ?? Carbon::now());

        $this->setDuration( $this->getEndAt()->diffInSeconds($this->getStartAt()) );
        $this->setDurationHhmmss( gmdate('H:i:s', $this->getDuration()) );

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
    public function getDuration(): float
    {
        return $this->_duration;
    }

    /**
     * @param float $duration
     */
    public function setDuration(float $duration): void
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
}
