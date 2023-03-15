<?php

namespace App\Models\Reports;


use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
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

    public function reportfiles() {
        return $this->hasMany(ReportFile::class, "report_id");
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouvel objet Report
     * @param string $title Le Titre du Rapport
     * @param ReportType $reporttype Le Type du Rapport
     * @param string $description La Description
     * @return Report
     */
    public static function createNew(string $title, ReportType $reporttype, string $description): Report {
        $report = Report::create([
            'title' => $title,
            'description' => $description,
        ]);

        $report->reporttype()->associate($reporttype);

        $report->save();

        return $report;
    }

    /**
     * Met à jour (et modifie dans la base de données) cet objet Report
     * @param string $title
     * @param ReportType $reporttype
     * @param string $description
     * @return $this
     */
    public function updateOne(string $title, ReportType $reporttype, string $description): Report
    {
        $this->title = $title;
        $this->description = $description;

        $this->reporttype()->associate($reporttype);

        $this->save();

        return $this;
    }

    #endregion
}
