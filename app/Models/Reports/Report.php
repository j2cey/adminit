<?php

namespace App\Models\Reports;


use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\DynamicAttribute\HasDynamicAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Report
 * @package App\Models\Report
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property integer|null $report_type_id
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Report extends BaseModel implements Auditable
{
    use HasDynamicAttributes, HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['reporttype'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => ['required'],
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

    public function reporttype() {
        return $this->belongsTo(ReportType::class, "report_type_id");
    }

    #endregion

    #region Custom Functions

    public static function createNew($title,ReportType $report_type,$description): Report {
        return Report::create([
            'title' => $title,
            'report_type_id' => $report_type->id,
            'description' => $description,
        ]);
    }

    #endregion
}
