<?php

namespace App\Enums\Treatments;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum TreatmentStateEnum: string
{
    use EnumTrait;

    #[Description('Pas encore demarre')]
    case NOTSTARTED = 'notstarted';

    #[Description('En Attente')]
    case WAITING = 'waiting';

    #[Description('En cours de recuperation (pick-upping)')]
    case PICKING = 'picking';

    #[Description('En Attente de Dispatch')]
    case TODISPATCH = 'todispatch';

    #[Description('En File Attente')]
    case QUEUED = 'queued';

    #[Description('En cours de Demarrage')]
    case STARTING = 'starting';

    #[Description('En Exécution')]
    case RUNNING = 'running';

    #[Description('ending treatment by first')]
    case FIRSTENDING = 'firstending';

    #[Description('En cours d arret')]
    case ENDING = 'ending';

    #[Description('Terminé')]
    case COMPLETED = 'completed';

    #[Description('En cours de réessai')]
    case RETRYING = 'retrying';

    #[Description('Terminé & tout rééssayé')]
    case ALLTRIED = 'alltried';
}
