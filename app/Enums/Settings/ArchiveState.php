<?php

namespace App\Enums\Settings;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum ArchiveState: string
{
    use EnumTrait;

    #[Description('Enabled')]
    case ENABLED = 'enabled';

    #[Description('Disabled')]
    case DISABLED = 'disabled';
}
