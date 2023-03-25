<?php

namespace App\Enums;

enum TreatmentStateEnum: string
{
    case WAITING = 'waiting';
    case RUNNING = 'running';
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
