<?php

namespace App\Traits\Notify;

use App\Contracts\Notify\IIsNotifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Notify\NotificationResult;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property bool $isNotified
 * @property bool $isNotificationDone
 * @property NotificationResult $notificationresult
 *
 * @method static Builder notified()
 */
trait IsNotifiable
{
    abstract public function getNotifiedSuccessRate(): float;

    /**
     * @return MorphOne
     */
    public function notificationresult() {
        return $this->morphOne(NotificationResult::class, 'notifiable');
    }

    #region Accessors & Mutators

    public function getIsNotifiedAttribute() {
        return ($this->notificationresult && $this->notificationresult->notified);
    }

    public function getIsNotificationDoneAttribute() {
        return ($this->notificationresult && $this->notificationresult->notification_done);
    }

    #endregion

    #region Scopes

    public function scopeNotified($query) {
        return $query->whereHas('notificationresult', function (Builder $q) {
            $q->where('notified', 1);
        });
    }

    #endregion

    public function setNotificationResult() {
        if ( is_null($this->notificationresult) ) {
            $this->notificationresult()->save( NotificationResult::createNew([]) );
            $this->load('notificationresult');
        }
    }

    public function startingNotification(int $nb_to_notify, IIsNotifiable|null $upper_notifiable): NotificationResult {
        $upper_notifiable?->setNotificationResult();
        $this->setNotificationResult();
        return $this->notificationresult->setStarting($nb_to_notify, $this->getNotifiedSuccessRate(), $upper_notifiable?->notificationresult);
    }

    public function itemNotificationFailed(int $item, string $message) {
        if ( ! is_null($this->notificationresult) ) {
            $this->notificationresult->itemNotificationFailed($item, $message);
        }
    }

    public function itemNotificationSucceed(int $item) {
        if ( ! is_null($this->notificationresult) ) {
            $this->notificationresult->itemNotificationSucceed($item);
        }
    }

    public function allNotificationSucceed() {
        if ( ! is_null($this->notificationresult) ) {
            $this->notificationresult->allNotificationSucceed();
        }
    }

    public function allNotificationFailed(string $message) {
        if ( ! is_null($this->notificationresult) ) {
            $this->notificationresult->allNotificationFailed($message);
        }
    }

    protected function initializeIsNotifiable()
    {
        $this->with = array_unique(array_merge($this->with, ['notificationresult']));
    }

    public static function bootIsNotifiable()
    {
        static::deleting(function ($model) {
            $model->notificationresult?->delete();
        });
    }
}
