<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum QueueEnum: string
{
    use EnumTrait;

    #[Description('Telechargement Fichiers')]
    case DOWNLOADFILES = 'downloadfiles';

    #[Description('Importation Fichiers')]
    case IMPORTFILES = 'importfiles';

    #[Description('Formattage Fichiers')]
    case FORMATFILES = 'formatfiles';

    #[Description('Notifie les Fichiers')]
    case NOTIFYFILES = 'notifyfiles';
}
