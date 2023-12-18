<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum QueueDispatchMode: string
{
    use EnumTrait;

    #[Description('Dispatch in any Queue')]
    case ANYQUEUE = 'anyqueue';

    #[Description('Dispatch in same Queue')]
    case SAMEQUEUE = 'samequeue';
}
