<?php

namespace App\Models\Reports;

use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FileHeader\HasFileHeader;
use App\Models\ReportFile\ReportFileType;
use App\Enums\Treatments\TreatmentStateEnum;
use App\Contracts\FileHeader\IHasFileHeader;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Traits\DynamicAttribute\HasDynamicAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;
use App\Traits\ReportTreatment\Workflow\HasTreatmentWorkflow;

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
 * @property string $state
 *
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Report create(string[] $array)
 */
class Report extends BaseModel implements Auditable, IHasFileHeader
{
    use HasFileHeader, HasTreatmentWorkflow, HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['reporttype'];
    //protected $appends = [];

    protected $casts = [
        'state' => TreatmentStateEnum::class,
    ];

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

    #region SCOPES based Custom Functions

    /**
     * @return ReportFile[]|null
     */
    public function getActiveReportFiles() {

        return $this->reportfiles()->active()->get();
    }

    /**
     * @return Report|null
     */
    public static function getActiveFirst() {
        return Report::active()->first();
    }
    /**
     * @return Report[]|null
     */
    public static function getActives() {
        return Report::active()->get();
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouvel objet Report
     * @param string $title Le Titre du Rapport
     * @param Model|ReportType $reporttype Le Type du Rapport
     * @param string $description La Description
     * @return Report
     */
    public static function createNew(string $title, Model|ReportType $reporttype, string $description): Report {
        $report = Report::create([
            'title' => $title,
            'description' => $description,
        ]);

        $report->reporttype()->associate($reporttype);
        $report->setFileheader()->setDefaultFormatSize();

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

    /**
     * @param Model|ReportFileType $reportfiletype
     * @param string $name
     * @param string $label
     * @param string|null $wildcard
     * @param string|null $description
     * @param string|null $remotedir_relative_path
     * @param string|null $remotedir_absolute_path
     * @param bool $use_file_extension
     * @return ReportFile
     */
    public function addReportFile(Model|ReportFileType $reportfiletype, string $name, string $label, string $wildcard = null, string $description = null, string $remotedir_relative_path = null, string $remotedir_absolute_path = null, bool $use_file_extension = true): ReportFile
    {
        return ReportFile::createNew(
            $this,
            $reportfiletype,
            Status::default()->first(),
            $name,
            $label,
            $wildcard,
            $description,
            $remotedir_relative_path,
            $remotedir_absolute_path,
            $use_file_extension
        );
    }

    public function exec() {

        $activereportfiles = $this->getActiveReportFiles();

        foreach ($activereportfiles as $activereportfile) {
            $activereportfile->exec();
            //break;
        }
    }

    /**
     * @param $reportId
     * @return Report|null
     */
    public static function getById($reportId) {
        return Report::find($reportId);
    }

    #endregion
}
