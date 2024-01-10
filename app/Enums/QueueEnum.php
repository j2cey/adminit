<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum QueueEnum: string
{
    use EnumTrait;

    #[Description('System LOG')]
    case SYSTEMLOG = 'systemlog';

    #[Description('Execution Trace')]
    case EXECTRACE = 'exectrace';

    #[Description('Update Progression')]
    case PROGRESSION = 'progression';

    #[Description('Treatment Starting or Ending')]
    case TREATMENTSTARTEND = 'treatmentstartend';

    #[Description('Execution de Listeners')]
    case LISTENER = 'listener';

    #[Description('Traitement Principal')]
    case MAIN = 'main';


    #[Description('Telechargement Fichiers')]
    case DOWNLOADFILE = 'downloadfile';

    #[Description('Importation Lignes Fichier')]
    case IMPORTFILE = 'importfile';

    #[Description('Formattage de Fichier')]
    case FORMATFILE = 'formatfile';

    #[Description('Merge des Lignes formatees de Fichier')]
    case MERGEFILE = 'mergefile';

    #[Description('Notifie les Fichiers')]
    case NOTIFYFILE = 'notifyfile';
}
