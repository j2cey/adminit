<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum TreatmentStepCode: string
{
    use EnumTrait;

    #[Description('Téléchargement Fichier')]
    case DOWNLOADFILE = 'downloadfile';

    #[Description('Importation Fichier')]
    case IMPORTFILE = 'importfile';

    #[Description('Préparation du Formattage')]
    case PREPAREFORMATTING = 'prepareformatting';

    #[Description('Formattage Colonnes par ligne')]
    case FORMATROWCOLUMNS = 'formatrowcolumns';

    #[Description('Merge colonnes Formatées')]
    case MERGECOLUMNS = 'mergecolumns';

    #[Description('Merge Lignes')]
    case MERGEROWS = 'mergerows';

    #[Description('Notification Fichier')]
    case NOTIFYFILE = 'notifyfile';
}
