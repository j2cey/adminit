<?php

namespace App\Models\Treatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Enums\QueueDispatchMode;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Treatments\TreatmentResultEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Treatments\TreatmentResult\ResultEnding;
use App\Models\Treatments\TreatmentResult\ResultFailing;

/**
 * Class TreatmentResult
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $num_ord
 * @property string|TreatmentResultEnum $result
 * @property string|QueueDispatchMode $subs_dispatch_mode
 *
 * @property Carbon|null $start_at
 * @property Carbon|null $last_exec_end_at
 * @property Carbon|null $end_at
 * @property int|null $duration
 * @property string|null $duration_hhmmss
 *
 * @property string $message
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property boolean $isSuccess
 * @property boolean $isFailed
 * @property boolean $isHighCritical
 *
 * @method static Builder failed()
 * @method static Builder notFailed()
 * @method static Builder success()
 *
 * @property Treatment $treatment
 * @method static TreatmentResult create(string[] $array)
 */
class TreatmentResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, ResultEnding, ResultFailing;

    protected $guarded = [];

    protected $casts = [
        'result' => TreatmentResultEnum::class,
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
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

    #region Accessors & Mutators

    public function getIsSuccessAttribute() {
        return $this->result == TreatmentResultEnum::SUCCESS;
    }
    public function getIsFailedAttribute() {
        return $this->result == TreatmentResultEnum::FAILED;
    }

    #endregion

    #region Scopes

    public function scopeFailed($query) {
        return $query->where('result', TreatmentResultEnum::FAILED->value);
    }

    public function scopeNotFailed($query) {
        return $query->whereNotIn('result', [TreatmentResultEnum::FAILED->value]);
    }

    public function scopeSuccess($query) {
        return $query->where('result', TreatmentResultEnum::SUCCESS->value);
    }

    #endregion

    #region Eloquent Relationships

    /**
     * treatment. For history
     * @return BelongsTo
     */
    public function treatment() {
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }

    #endregion

    #region Custom Functions

    public static function createNew(Treatment $treatment, $num_ord): TreatmentResult {
        return TreatmentResult::create([
            'num_ord' => $num_ord
        ]);
        // associacte to treatment (History purpose)
        //$treatmentresult->treatment()->associate($treatment)->save();

        //return $treatmentresult;
    }

    public function setResult(TreatmentResultEnum $treatmentresultenum, string $message = null, bool $save = true) {
        $this->result = $treatmentresultenum;
        if ( ! is_null($message) ) {
            $this->message = $message;
        }

        if ($save) $this->save();
    }

    public function setMessage(string $message, bool $save = true) {
        $this->message = $message;

        if ( $save ) $this->save();
    }

    #endregion
}
