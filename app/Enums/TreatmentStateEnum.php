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

    #[Description('En Exécution')]
    case RUNNING = 'running';

    #[Description('Terminé')]
    case COMPLETED = 'completed';

    #[Description('En cours de réessai')]
    case RETRYING = 'retrying';

    #[Description('Terminé & tout rééssayé')]
    case ALLTRIED = 'alltried';
}
