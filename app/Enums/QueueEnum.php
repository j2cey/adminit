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

    #[Description('Importation Valeurs de Ligne de Fichier')]
    case IMPORTDATA = 'importdata';

    #[Description('Formattage des Valeurs de Ligne de Fichier')]
    case FORMATDATA = 'formatdata';

    #[Description('Merge des Lignes formatees de Fichier')]
    case MERGEFILE = 'mergefile';

    #[Description('Merge colonnes formatees')]
    case MERGECOLUMNS = 'mergecolumns';

    #[Description('Notifie les Fichiers')]
    case NOTIFYFILE = 'notifyfile';
}
