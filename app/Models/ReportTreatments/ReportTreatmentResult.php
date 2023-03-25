<?php

namespace App\Models\ReportTreatments;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Enums\TreatmentStateEnum;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportTreatmentResult
 * @package App\Models\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $state
 *
 * @property string $description
 *
 * @property int $currentstep_num
 * @property int $currentstep_id
 * @property int $report_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Report $report
 * @property ReportTreatmentStepResult $currentstep
 *
 * @method static ReportTreatmentResult create(string[] $array)
 */
class ReportTreatmentResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'state' => TreatmentStateEnum::class,
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

    public function report() {
        return $this->belongsTo(Report::class, "report_id");
    }

    public function currentstep() {
        return $this->belongsTo(ReportTreatmentStepResult::class, "currentstep_id");
    }

    #endregion

    #region Custom Functions

    public static function createNew(Model|Report $report, Model|ReportTreatmentStepResult $currentstep = null, Carbon $start_at = null, Carbon $end_at = null, string $state = null, string $description = null): ReportTreatmentResult
    {
        $reporttreatmentresult = ReportTreatmentResult::create([
            'start_at' => $start_at ?? Carbon::now(),
            'end_at' => $end_at ?? Carbon::now(),
            'state' => $state ?? TreatmentStateEnum::WAITING->value,
            'description' => $description,
        ]);

        $reporttreatmentresult->report()->associate($report);
        if ( ! is_null($currentstep) ) $reporttreatmentresult->currentstep()->associate($currentstep);

        $reporttreatmentresult->save();

        return $reporttreatmentresult;
    }

    public function updateThis(Model|Report $report, Model|ReportTreatmentStepResult $currentstep = null, int $currentstep_num = null, Carbon $start_at = null, Carbon $end_at = null, string $state = null, string $description = null): ReportTreatmentResult
    {
        $this->start_at = $start_at ?? Carbon::now();
        $this->end_at = $end_at ?? Carbon::now();
        $this->state = $state ?? TreatmentStateEnum::WAITING->value;
        $this->currentstep_num = $currentstep_num;
        $this->description = $description;

        $this->report()->associate($report);
        if ( ! is_null($currentstep) ) $this->currentstep()->associate($currentstep);

        $this->save();

        return $this;
    }

    #endregion
}
