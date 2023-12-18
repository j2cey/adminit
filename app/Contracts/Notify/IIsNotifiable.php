<?php

namespace App\Contracts\Notify;

use App\Models\Notify\NotificationResult;

/**
 * @property bool $isNotified
 * @property bool $isNotificationDone
 * @property NotificationResult $notificationresult
 */
interface IIsNotifiable
{
    public function startingNotification(int $nb_to_notify, IIsNotifiable|null $upper_notifiable): NotificationResult;
    public function itemNotificationSucceed(int $item);
    public function itemNotificationFailed(int $item, string $message);
    public function allNotificationSucceed();
    public function allNotificationFailed(string $message);
}
