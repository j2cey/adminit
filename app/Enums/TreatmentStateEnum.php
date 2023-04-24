<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum TreatmentStateEnum: string
{
    use EnumTrait;

    #[Description('En Attente')]
    case WAITING = 'waiting';

    #[Description('En File Attente')]
    case QUEUED = 'queued';

    #[Description('En Execution')]
    case RUNNING = 'running';

    #[Description('Termine')]
    case COMPLETED = 'completed';
}
