<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportFile
 * @package App\Models\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string|null $wildcard
 * @property bool|null $retrieve_by_name
 * @property bool|null $retrieve_by_wildcard
 *
 * @property string|null $description
 *
 * @property integer|null $report_file_type_id
 * @property integer|null $report_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReportFile extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ["reportfiletype"];

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'wildcard' => [
                'without_spaces'
            ],
            'reportfiletype' => ['required'],
            'report' => ['required'],
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
            'name.required' => "Prière de renseigner le nom",
            'wildcard.required' => "Prière de renseigner le caractère générique",
            'wildcard.without_spaces' => "Le Wildcard ne doit pas comporter des espaces",
            'report.required' => "Prière de renseigner le rapport lié à ce fichier",
            'reportfiletype.required' => "Prière de renseigner un type de fichier",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function reportfiletype() {
        return $this->belongsTo(ReportFileType::class, 'report_file_type_id');
    }

    public function report() {
        return $this->belongsTo(Report::class, 'report_id');
    }

    #endregion

    #region Accessors & Mutators

    /**
     * Retourne le type de récupération
     *
     * @return string
     */
    public function getRetrieveByWildcardLabelAttribute() {
        return config('Settings.reportfile.retrieve_by_wildcard_label');
    }

    /**
     * Retourne le type de récupération
     *
     * @return string
     */
    public function getRetrieveByNameLabelAttribute() {
        return config('Settings.reportfile.retrieve_by_name_label');
    }

    #endregion


    #region Custom Functions

    /**
     * Crée (et stocker dans la base de données) un nouveau Fichier de Rapport
     * @param Report $report Le Rapport auquel le fichier appartient
     * @param ReportFileType $reportfiletype Le Type de fichier
     * @param Status $status Le statut du fichier
     * @param string $name Le Nomn du fichier
     * @param string|null $wildcard Le Wildcard
     * @param bool $retrieve_by_name Détermine si le fichier doit être récupéré par Nom
     * @param bool $retrieve_by_wildcard Détermine si le fichier doit être récupéré par Wildcard
     * @param string|null $description Description du Fichier
     * @return ReportFile
     */
    public static function createNew(Report $report, ReportFileType $reportfiletype, Status $status, string $name, string $wildcard = null, bool $retrieve_by_name = false, bool $retrieve_by_wildcard = false, string $description = null): ReportFile
    {
        $reportfile = ReportFile::create([
            'name' => $name,
            'wildcard' => $wildcard,
            'retrieve_by_name' => $retrieve_by_name,
            'retrieve_by_wildcard' => $retrieve_by_wildcard,
            'description' => $description,
        ]);

        // associate reportfiletype
        $reportfile->reportfiletype()->associate($reportfiletype);

        // associate report
        $reportfile->report()->associate($report);

        // associate status
        $reportfile->status()->associate($status);

        // save le new object
        $reportfile->save();

        return $reportfile;
    }

    /**
     * Crée (et stocker dans la base de données) un nouveau Fichier de Rapport
     * @param Report $report Le Rapport auquel le fichier appartient
     * @param ReportFileType $reportfiletype Le Type de fichier
     * @param Status $status Le statut du fichier
     * @param string $name Le Nomn du fichier
     * @param string|null $wildcard Le Wildcard
     * @param bool $retrieve_by_name Détermine si le fichier doit être récupéré par Nom
     * @param bool $retrieve_by_wildcard Détermine si le fichier doit être récupéré par Wildcard
     * @param string $description Description du Fichier
     * @return $this
     */
    public function updateOne(Report $report, ReportFileType $reportfiletype, Status $status, string $name, string $wildcard = null, bool $retrieve_by_name = false, bool $retrieve_by_wildcard = false, string $description = ""): ReportFile
    {
        $this->name = $name;
        $this->wildcard = $wildcard;
        $this->retrieve_by_name = $retrieve_by_name;
        $this->retrieve_by_wildcard = $retrieve_by_wildcard;
        $this->description = $description;

        // associate reportfiletype
        $this->reportfiletype()->associate($reportfiletype);

        // associate report
        $this->report()->associate($report);

        // associate status
        $this->status()->associate($status);

        // save le new object
        $this->save();

        return $this;
    }

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
        });
    }

    #endregion
}
