<?php

namespace App\Traits\Notify;

use App\Enums\NotificationTypeEnum;
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

    public function reloadNotificationResult() {
        $this->load('notificationresult');
    }

    public function setNotificationResult() {
        if ( is_null($this->notificationresult) ) {
            $this->notificationresult()->save( NotificationResult::createNew([
                'posi' => 1,
                'min_notified_success_rate' => $this->getNotifiedSuccessRate(),
            ]) );
            //$this->load('notificationresult');
        }
    }

    public function startingSubNotification(NotificationTypeEnum $notification_type, int|null $nb_to_notify): NotificationResult {
        $sub_notification = NotificationResult::createNew([
            'notification_type' => $notification_type->value,
        ]);
        $this->notificationresult->addSubNotificationResult($sub_notification);
        /*if ($increment_upper_nb_to_notify) {
            $this->nb_to_notify += 1;
        }*/
        $sub_notification->setStarting($nb_to_notify);

        return $sub_notification;
    }

    public function startingNotification(int|null $nb_to_notify): NotificationResult {

        $this->notificationresult->setStarting($nb_to_notify);

        return $this->notificationresult;
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
        // after the model has been created
        static::created(function ($model) {
            // We set a notifictaion result for the model
            $model->setNotificationResult();
        });

        static::deleting(function ($model) {
            $model->notificationresult?->delete();
        });
    }
}
