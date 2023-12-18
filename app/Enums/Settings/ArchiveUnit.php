<?php

namespace App\Enums\Settings;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum ArchiveUnit: string
{
    use EnumTrait;

    #[Description('Second')]
    case SECOND = 'sec';

    #[Description('Minute')]
    case MINUTE = 'min';

    #[Description('Hour')]
    case HOUR = 'hour';

    #[Description('Day')]
    case DAY = 'day';
}
