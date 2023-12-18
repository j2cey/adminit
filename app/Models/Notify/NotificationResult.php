<?php

namespace App\Models\Notify;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\Time\HasDuration;
use App\Enums\NotificationTypeEnum;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\Notify\IIsNotifiable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class NotificationResult
 * @package App\Models\Notify
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Carbon|null $start_at
 *
 * @property string|null $notification_type
 * @property int|null $nb_to_notify
 * @property int|null $nb_notification_success
 * @property float $notification_success_rate
 * @property int|null $last_notification_success
 * @property int|null $nb_notification_failed
 * @property float $notification_failed_rate
 * @property int|null $last_notification_failed
 * @property int|null $last_notified
 * @property int|null $nb_being_notified
 * @property int|null $nb_notified
 * @property bool $notification_done
 *
 * @property int $attempts
 * @property int $attempts_session_count
 *
 * @property float $min_notified_success_rate
 * @property int $notified
 * @property Carbon|null $end_at
 * @property int|null $duration
 * @property string|null $duration_hhmmss
 *
 * @property string|null $notifiable_type
 * @property int|null $notifiable_id
 * @property string|null $last_failed_message
 *
 * @property int|null $posi
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property NotificationResult|null $uppernotificationresult
 * @property IIsNotifiable $notifiable
 * @method static NotificationResult create(array $data)
 */
class NotificationResult extends BaseModel implements Auditable
{
    use HasFactory, HasDuration, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $casts = [
        'notified' => 'boolean',
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [

        ];
    }

    #endregion

    #region Eloquent Relationships

    public function uppernotificationresult() {
        return $this->belongsTo(NotificationResult::class, 'upper_notificationresult_id');
    }

    public function subnotificationresults() {
        return $this->hasMany(NotificationResult::class, 'upper_notificationresult_id');
    }

    /**
     * @return MorphTo
     * Get the notified model.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createNew(array $data): NotificationResult {
        return NotificationResult::create($data);
    }

    private function addSubNotificationResult(NotificationResult $notificationresult) {
        $notificationresult->posi = $this->subnotificationresults()->count() + 1;
        $notificationresult->uppernotificationresult()->associate($this)->save();
    }

    public function setStarting(int $nb_to_notify, float $min_notified_success_rate, NotificationResult|null $upper_notificationresult) {

        $this->posi = 1;
        $upper_notificationresult?->addSubNotificationResult($this);

        $this->start_at = Carbon::now();
        $this->setNewAttempt();

        $this->nb_to_notify = $nb_to_notify;
        $this->min_notified_success_rate = $min_notified_success_rate;
        $this->incrementNotification(false);

        $this->save();

        return $this;
    }

    public function startingSubNotification(NotificationTypeEnum $notification_type, int $nb_to_notify, bool $increment_upper_nb_to_notify): NotificationResult {
        $sub_notification = NotificationResult::createNew([
            'notification_type' => $notification_type->value,
        ]);
        if ($increment_upper_nb_to_notify) {
            $this->nb_to_notify += 1;
        }
        $sub_notification->setStarting($nb_to_notify, $this->min_notified_success_rate, $this);

        return $sub_notification;
    }


    private function setNewAttempt() {
        $this->attempts++;
        $this->attempts_session_count++;
    }

    public function incrementNotification(bool $save) {
        $this->nb_being_notified++;
        $this->saveObject($save);
    }

    /**
     * @param string $notification_attribute notification attribute to increment 'nb_notification_success' or 'nb_notification_failed'
     * @param int $amount items amount
     * @param bool $save
     * @return void
     */
    private function decrementNotification(string $notification_attribute, int $amount, bool $save) {
        $this->{$notification_attribute} += $amount;
        $this->nb_being_notified -= ($amount > $this->nb_being_notified) ? $this->nb_being_notified : $amount;
        $this->saveObject($save);
    }

    public function allNotificationSucceed() {
        $this->setAllNotificationDone("nb_notification_success", "last_notification_success");
    }

    public function allNotificationFailed(string $message) {
        $this->last_failed_message = $message;
        $this->setAllNotificationDone("nb_notification_failed", "last_notification_failed");
    }

    public function itemNotificationSucceed(int $item) {
        $this->last_notification_success = $item;
        $this->setNotificationDone("nb_notification_success",1, 1);
    }

    public function itemNotificationFailed(int $item, string $message) {
        $this->last_notification_failed = $item;
        $this->last_failed_message = $message;
        $this->setNotificationDone("nb_notification_failed",1, 1);
    }


    /**
     * @param string $nb_notification_attribute notification attribute to increment 'nb_notification_success' or 'nb_notification_failed'
     * @param string $last_notification_attribute last notification attribute to increment 'last_notification_success' or 'last_notification_failed'
     * @return void
     */
    private function setAllNotificationDone(string $nb_notification_attribute, string $last_notification_attribute) {
        $last_item = $this->nb_to_notify - 1;

        $this->{$nb_notification_attribute} = 0;
        $this->{$last_notification_attribute} = $last_item;
        $this->nb_being_notified = $this->nb_to_notify;
        $this->setNotificationDone($nb_notification_attribute, $this->nb_to_notify, $last_item);
    }

    private function setNotificationDone(string $notification_attribute, int $amount, int $last_item) {
        $this->last_notified = $last_item;
        $this->decrementNotification($notification_attribute, $amount, false);
        $this->setNotified(false);

        $this->save();
    }

    private function setNotified(bool $save) {
        $this->notification_success_rate = ($this->nb_notification_success / $this->nb_to_notify) * 100;
        $this->notification_failed_rate = ($this->nb_notification_failed / $this->nb_to_notify) * 100;

        $this->notified = ( $this->notification_success_rate >= $this->min_notified_success_rate );
        $this->saveObject($save);

        $this->notification_done = ($this->nb_notification_success + $this->nb_notification_failed) >= $this->nb_to_notify;

        $this->endNotification();
    }

    private function endNotification() {
        if ($this->notification_done) {
            $duration = $this->getNewDuration($this->start_at, null);

            $this->end_at = $duration->getEndAt();
            $this->duration = $duration->getDuration();
            $this->duration_hhmmss = $duration->getDurationHhmmss();

            if ($this->notified) {
                $this->uppernotificationresult?->itemNotificationSucceed($this->posi);
            } else {
                $this->uppernotificationresult?->itemNotificationFailed($this->posi, $this->last_failed_message);
            }
        }
    }

    #endregion
}
