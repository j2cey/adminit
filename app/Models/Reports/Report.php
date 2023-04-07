<?php

namespace App\Models\Reports;


use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use App\Enums\TreatmentStateEnum;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ReportFile\ReportFileType;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Traits\DynamicAttribute\HasDynamicAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

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
 *
 * @property string|null $description
 * @property string|null $attributes_list
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ReportTreatmentResult[] $reporttreatmentresultswaiting
 *
 * @method static create(string[] $array)
 */
class Report extends BaseModel implements IHasDynamicAttributes
{
    use HasDynamicAttributes, HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['reporttype'];
    //protected $appends = [];

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

    public function reporttreatmentresults() {
        return $this->belongsTo(ReportTreatmentResult::class, "report_id");
    }
    public function reporttreatmentresultswaiting() {
        return $this->reporttreatmentresults()
            ->where('state', TreatmentStateEnum::WAITING->value);
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
     * @param string|null $wildcard
     * @param string|null $description
     * @param string|null $remotedir_relative_path
     * @param string|null $remotedir_absolute_path
     * @param bool $use_file_extension
     * @return ReportFile
     */
    public function addReportFile(Model|ReportFileType $reportfiletype, string $name, string $wildcard = null, string $description = null, string $remotedir_relative_path = null, string $remotedir_absolute_path = null, bool $use_file_extension = true): ReportFile
    {
        return ReportFile::createNew(
            $this,
            $reportfiletype,
            Status::default()->first(),
            $name,
            $wildcard,
            $description,
            $remotedir_relative_path,
            $remotedir_absolute_path,
            $use_file_extension
        );
    }

    /**
     * Rajoute un attribut à la liste JSON
     * @param DynamicAttribute $dynamicattribute
     * @return void
     */
    public function setAddAttributeToList(DynamicAttribute $dynamicattribute) {
        $attributes_list =  (array) json_decode( $this->attributes_list );
        $new_attribute = [
            'field' => $dynamicattribute->name,
            'key' => $dynamicattribute->name,
            'label' => $dynamicattribute->name,
            'numeric' => ($dynamicattribute->dynamicattributetype->code === ValueTypeEnum::INT->value),
            'searchable' => (bool)$dynamicattribute->searchable,
            'sortable' => (bool)$dynamicattribute->sortable,
            'date' => (bool)($dynamicattribute->dynamicattributetype->code === ValueTypeEnum::DATETIME->value),
        ];
        $attributes_list[] = $new_attribute;

        $this->attributes_list = json_encode( $attributes_list );

        $this->save();
    }

    /**
     * Reset puis refait la liste JSON des attributs
     * @return void
     */
    public function setAttributesList() {
        $this->attributes_list = "[]";
        $this->save();

        $dynamicattributes_ordered = $this->dynamicattributesOrdered;
        foreach ($dynamicattributes_ordered as $dynamicattribute) {
            $this->setAddAttributeToList($dynamicattribute);
        }
    }

    public function exec() {

        // On recherche récupère les traitements en cours (le cas échéant)
        $waitingtreatments = $this->reporttreatmentresultswaiting;
        //$nb_critical_waiting = 0;

        foreach ($waitingtreatments as $waitingtreatment) {
            // si l'étape en cours est success, on passe suivant

            // si l'étape en cours est waiting ou failed non critique
            // l'exécute
            // sinon on s'arrête
        }

        $reporttreatmentresult = ReportTreatmentResult::createNew($this,"Traitement Rapport " . $this->title);
        $first_step = $reporttreatmentresult->addStep("Récupération du fichier");
    }

    private function execStep(ReportTreatmentStepResult $step, int $step_no) {
        if ($step_no === 1) {
            // Récupération Fichier
        } elseif ($step_no === 2) {
            // Import
        } elseif ($step_no === 3) {
            // Formmat
        } elseif ($step_no === 4) {
            // Alert
        } else {
            return null;
        }
    }

    #endregion
}
