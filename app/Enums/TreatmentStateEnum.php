<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum TreatmentStateEnum: string
{
    use EnumTrait;

    #[Description('En Attente')]
    case WAITING = 'waiting';

    #[Description('En Execution')]
    case RUNNING = 'running';

    #[Description('Succe')]
    case SUCCESS = 'success';

    #[Description('Echec')]
    case FAILED = 'failed';
}
