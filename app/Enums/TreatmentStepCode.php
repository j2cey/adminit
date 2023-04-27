<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum TreatmentStepCode: string
{
    use EnumTrait;

    #[Description('Telechargement Fichier')]
    case DOWNLOADFILE = 'downloadfile';

    #[Description('Importation Fichier')]
    case IMPORTFILE = 'importfile';

    #[Description('Formattage données')]
    case FORMATDATA = 'formatdata';

    #[Description('Notification Rapport')]
    case NOTIFYREPORT = 'notifyreport';
}
