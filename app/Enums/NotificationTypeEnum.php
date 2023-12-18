<?php

namespace App\Enums;

use App\Traits\Enum\EnumTrait;
use App\Enums\Attributes\Description;

enum NotificationTypeEnum: string
{
    use EnumTrait;

    #[Description('E-Mail Notification')]
    case EMAIL = 'email';

    #[Description('Sms Notification')]
    case SMS = 'sms';
}
