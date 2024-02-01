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

    public function setUpperNotificationResult(NotificationResult|null $uppernotificationresult) {
        if ( ! is_null( $uppernotificationresult ) ) {
            $uppernotificationresult->addSubNotificationResult($this);
        }
    }

    public function addSubNotificationResult(NotificationResult $notificationresult) {
        $notificationresult->posi = $this->subnotificationresults()->count() + 1;
        $notificationresult->uppernotificationresult()->associate($this)->save();
    }

    public function addToNotify(int $amount) {
        $this->update(['nb_to_notify' => $this->nb_to_notify += $amount,]
        );
        $this->setNotificationUpToDate(true);

        $this->uppernotificationresult?->addToNotify($amount);
    }

    public function setStarting(int|null $nb_to_notify, bool $force = false) {

        //$this->posi = 1;
        //$upper_notificationresult?->addSubNotificationResult($this);

        if ( ! is_null($nb_to_notify) ) {
            $this->addToNotify($nb_to_notify);
        }

        if ( is_null($this->start_at) || $force ) {
            $this->start_at = Carbon::now();
            $this->setNewAttempt();

            $this->incrementNotification(false);

            $this->save();
        }

        $this->uppernotificationresult?->setStarting(null, $force);

        //return $this;
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

        $this->uppernotificationresult?->itemNotificationSucceed($item);
    }

    public function itemNotificationFailed(int $item, string $message) {
        $this->last_notification_failed = $item;
        $this->last_failed_message = $message;
        $this->setNotificationDone("nb_notification_failed",1, 1);

        $this->uppernotificationresult?->itemNotificationFailed($item, $message);
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
        if ( is_null( $this->start_at ) ) {
            $this->setStarting($amount);
        }
        $this->last_notified = $last_item;
        $this->decrementNotification($notification_attribute, $amount, false);

        // adjust nb to notify if any
        if ( $this->{$notification_attribute} > $this->nb_to_notify ) {
            $this->nb_to_notify = $last_item;
        }

        $this->setNotificationUpToDate(false);

        $this->save();
    }

    private function setNotificationUpToDate(bool $save) {
        $this->notification_success_rate = ($this->nb_notification_success / $this->nb_to_notify) * 100;
        $this->notification_failed_rate = ($this->nb_notification_failed / $this->nb_to_notify) * 100;

        $this->saveObject($save);

        $this->notified = ( $this->notification_success_rate >= $this->min_notified_success_rate );
        $this->notification_done = ($this->nb_notification_success + $this->nb_notification_failed) >= $this->nb_to_notify;

        $this->endNotification();
    }

    private function endNotification() {
        if ($this->notification_done) {
            $duration = $this->getNewDuration($this->start_at, null);

            $this->end_at = $duration->getEndAt();
            $this->duration = $duration->getDuration();
            $this->duration_hhmmss = $duration->getDurationHhmmss();
        }
    }

    /**
     * @param int $id
     * @return NotificationResult|null
     */
    public static function getById(int $id) {
        return NotificationResult::find($id);
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->subnotificationresults()->each(function($subnotificationresult) {
                $subnotificationresult->delete(); // <-- direct deletion
            });
        });
    }
}
