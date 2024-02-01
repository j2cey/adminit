<?php

namespace App\Contracts\Notify;

use App\Enums\NotificationTypeEnum;
use App\Models\Notify\NotificationResult;

/**
 * @property bool $isNotified
 * @property bool $isNotificationDone
 * @property NotificationResult $notificationresult
 */
interface IIsNotifiable
{
    public function startingNotification(int|null $nb_to_notify): NotificationResult;
    public function startingSubNotification(NotificationTypeEnum $notification_type, int|null $nb_to_notify): NotificationResult;
    public function itemNotificationSucceed(int $item);
    public function itemNotificationFailed(int $item, string $message);
    public function allNotificationSucceed();
    public function allNotificationFailed(string $message);
}
