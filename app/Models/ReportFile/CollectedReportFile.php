<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\HtmlTagKey;
use Illuminate\Support\Carbon;
use App\Imports\ReportFilesImport;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportFile\NotifyReport;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Traits\DynamicAttribute\HasDynamicRows;
use App\Models\ReportTreatments\OperationResult;
use App\Traits\FormattedValue\HasFormattedValue;
use App\Contracts\DynamicAttribute\IHasDynamicRows;
use App\Contracts\FormattedValue\IHasFormattedValue;
use App\Traits\AnalysisRules\HasMatchedAnalysisRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\AnalysisRules\IHasMatchedAnalysisRules;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class CollectedReportFile
 * @package App\Models\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $initial_file_name
 * @property string $local_file_name
 * @property string|null $file_size
 *
 * @property string|null $description
 *
 * @property integer|null $report_file_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int $nb_rows
 * @property int $nb_rows_import_success
 * @property int $nb_rows_import_failed
 * @property int $nb_rows_import_processing
 * @property int $nb_rows_import_processed
 * @property int $row_last_import_processed
 * @property int $nb_import_try
 * @property int $imported
 * @property int $import_processing
 *
 * @property string $lines_values
 *
 * @property int $nb_rows_format_success
 * @property int $nb_rows_format_failed
 * @property int $nb_rows_format_processing
 * @property int $nb_rows_format_processed
 * @property int $row_last_format_processed
 * @property int $nb_format_try
 * @property int $formatted
 * @property int $format_processing
 *
 * @property int $notification_processing
 * @property int $nb_notification_try
 * @property boolean $notified
 * @property Carbon $last_notification_success
 * @property Carbon $last_notification_failed
 *
 * @property ReportFile $reportfile
 * @property string $fileLocalRelativePath
 * @property string $fileLocalAbsolutePath
 *
 * @method static CollectedReportFile first()
 * @method static toImport()
 * @method static CollectedReportFile create(array $array)
 */
class CollectedReportFile extends BaseModel implements Auditable, IHasDynamicRows, IHasFormattedValue, IHasFormatRules, IHasMatchedAnalysisRules
{
    use HasFactory, HasDynamicRows, HasFormattedValue, HasFormatRules, HasMatchedAnalysisRules, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ['reportfile'];
    protected $casts = [
        'imported' => 'boolean',
        'formatted' => 'boolean',
        'notified' => 'boolean',
    ];

    public static function defaultRules() {
        return [
            'initial_file_name' => ['required'],
            'local_file_name' => ['required'],
            'file_size' => ['required'],
            'reportfile' => ['required'],
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
            'initial_file_name.required' => "Prière de renseigner le nom initial",
            'local_file_name.required' => "Prière de renseigner le nom de fichier en local",
            'file_size.required' => "Prière de renseigner la taille de ce fichier",
            'reportfile.required' => "Prière de renseigner le rapport de fichier",
        ];
    }

    #region Accessors & Mutators

    public function getFileLocalRelativePathAttribute() {
        $collectedreportfiles_folder = config('app.collectedreportfiles_folder');
        return $collectedreportfiles_folder . "/" . $this->local_file_name;
    }

    public function getFileLocalAbsolutePathAttribute() {
        $collectedreportfiles_folder = config('app.collectedreportfiles_folder');
        return Storage::disk('public')->path($collectedreportfiles_folder . "/" . $this->local_file_name);
    }

    #endregion

    #region Scopes

    public function scopeToImport($query) {
        return $query
            ->where('imported', 0)
            ->where('import_processing', 0);
    }

    #endregion

    #region Eloquent Relationships

    public function reportfile() {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }
    public function report() {
        return $this->reportfile->report;
    }

    #endregion

    #region Custom Functions

    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type CollectedReportFile
     * @param ReportFile $reportfile
     * @param string $initial_file_name
     * @param string $local_file_name
     * @param int $file_size
     * @param Status|null $status
     * @param null $description
     * @param string $lines_values
     * @return CollectedReportFile
     */
    public static function createNew(ReportFile $reportfile, string $initial_file_name, string $local_file_name, int $file_size, Status $status = null, $description = null, string $lines_values = "[]") : CollectedReportFile
    {
        $collectedreportfile = CollectedReportFile::create([
            'initial_file_name' => $initial_file_name,
            'local_file_name' => $local_file_name,
            'file_size' => $file_size,
            'description' => $description,
            'lines_values' => $lines_values,
        ]);

        // Assignation du type de report file
        $collectedreportfile->reportfile()->associate($reportfile);

        // Assignation du statut du report file
        $collectedreportfile->status()->associate(is_null($status) ? Status::default()->first() : $status);

        $collectedreportfile->save();

        $collectedreportfile->setFormattedValue(HtmlTagKey::TABLE);

        $collectedreportfile->setDefaultFormatSize();

        return $collectedreportfile;
    }

    /**
     * @param ReportFile $reportfile
     * @param string $initial_file_name
     * @param string $local_file_name
     * @param string $file_size
     * @param Status|null $status
     * @param null $description
     * @return $this
     */
    public function updateOne(ReportFile $reportfile, string $initial_file_name, string $local_file_name, string $file_size, Status $status = null, $description = null): CollectedReportFile
    {
        $this->initial_file_name = $initial_file_name;
        $this->local_file_name = $local_file_name;
        $this->file_size = $file_size;
        $this->description = $description;

        //Assignation  du type de report file
        $this->reportfile()->associate($reportfile);

        // Assignation du statut de report file
        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );

        $this->save();

        return $this;
    }

    #region Data Importation

    public function importToDb(ReportTreatmentStepResult $reporttreatmentstepresult, bool $reset_imported = false): OperationResult
    {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Importion des Données du fichier");

        $this->startImport($reset_imported);

        if ($reset_imported) {
            $delete_operation_result = $this->deleteImportedData($reporttreatmentstepresult);
            if ($delete_operation_result->isFailed) {
                $this->endImport();
                return $operation_result->endWithFailure("Erreur Suppression Données importées");
            }
        }

        try {
            $import = new ReportFilesImport($this, $reporttreatmentstepresult);
            $import->import($this->fileLocalAbsolutePath);

            $this->mergeLinesValues();

            $this->endImport();
            return $operation_result->endWithSuccess();
        } catch (\Exception $e) {
            $this->endImport();
            return $operation_result->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    public function deleteImportedData(ReportTreatmentStepResult $reporttreatmentstepresult): OperationResult
    {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Suppression Données importées");
        try {
            $this->deleteRows();
            $this->lines_values = "[]";

            return $operation_result->endWithSuccess();
        } catch (\Exception $e) {
            return $operation_result->endWithFailure($e->getMessage());
        }
    }

    /**
     * Prépare l'objet pour démarrer une importation
     * @param bool $reset_imported
     * @return void
     */
    private function startImport(bool $reset_imported = false) {
        $this->import_processing = 1;
        $this->nb_import_try += 1;

        if ($reset_imported) {

            $this->nb_rows = 0;
            $this->nb_rows_import_success = 0;
            $this->nb_rows_import_failed = 0;
            $this->nb_rows_import_processing = 0;
            $this->nb_rows_import_processed = 0;
            $this->row_last_import_processed = 0;
            $this->imported = false;
        }

        $this->save();
    }

    public function setRowImportSuccess($row) {
        $this->row_last_import_processed = $row;
        $this->nb_rows_import_processed += 1;
        $this->nb_rows_import_success += 1;

        $this->save();
    }

    /**
     * Marque la fin d'une importation
     * @return void
     */
    private function endImport() {
        /*$this->import_processing = 0;
        $this->imported = ($this->nb_rows_import_processed > 0 && ( $this->nb_rows_import_success >= $this->nb_rows_import_processed ));

        $this->save();*/
        $this->update([
            'import_processing' => 0,
            'imported' => ($this->nb_rows_import_processed > 0 && ( $this->nb_rows_import_success >= $this->nb_rows_import_processed )),
        ]);
    }

    /**
     * Merge and return all rows imported data
     * @return array
     */
    public function mergeLinesValues() {
        $this->lines_values = "";
        $merged_values = [];
        $dynamicrows = $this->dynamicrows;

        foreach ($dynamicrows as $dynamicrow) {
            $merged_values[] = $dynamicrow->mergeColumnsValues();
        }
        $this->lines_values = json_encode($merged_values);
        $this->save();

        return $merged_values;
    }

    #endregion

    #region Data formatting

    /**
     * Launch data formatting
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @param bool $reset_formatted
     * @return OperationResult
     */
    public function formatImportedValues(ReportTreatmentStepResult $reporttreatmentstepresult, bool $reset_formatted = false): OperationResult
    {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Merge Lines Formatted Values");

        try {

            if ( $this->imported ) {
                $this->startFormat($reset_formatted);
                $this->mergeLinesFormattedValues();
                $this->endFormat();

                return $operation_result->endWithSuccess();
            } else {
                return $operation_result->endWithSuccess("File not imported");
            }
        } catch (\Exception $e) {
            $this->endFormat();
            return $operation_result->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    /**
     * Merge all Rows formatted values into the formatted values of this object
     * @return void
     */
    public function mergeLinesFormattedValues() {
        // reset rawvalue from formatted values
        $this->resetRawValues();
        $this->insertHeadersRow($this->getHeaders(), $this->reportfile->report->fileheader->formatrules);

        // get all dynamic row attached to this object
        $dynamicrows = $this->dynamicrows;

        foreach ($dynamicrows as $row_index => $dynamicrow) {
            // get merged formatted values for each row
            $dynamicrow->mergeColumnsFormattedValues();
            // merge object (this) formatted values with all rows formatted values
            $this->mergeRawValueFromFormatted($dynamicrow);
            $this->setRowFormatSuccess($row_index);
        }
        $this->applyFormatFromRaw(null, $this->formatrules);
    }

    public function getHeaders(): array {
        $headers = [];
        foreach ($this->reportfile->report->dynamicattributes as $dynamicAttribute) {
            if ($dynamicAttribute->can_be_notified) {
                $headers[] = $dynamicAttribute->title;
            }
        }
        return $headers;
    }

    private function startFormat(bool $reset_formatted = false) {
        $this->format_processing = 1;
        $this->nb_format_try += 1;

        if ($reset_formatted) {
            $this->nb_rows_format_success = 0;
            $this->nb_rows_format_failed = 0;
            $this->nb_rows_format_processing = 0;
            $this->nb_rows_format_processed = 0;
            $this->row_last_format_processed = 0;
            $this->formatted = false;
        }

        $this->save();
    }

    /**
     * Marque la fin d'une importation
     * @return void
     */
    private function endFormat() {
        $this->update([
            'format_processing' => 0,
            'formatted' => ($this->nb_rows_format_processed > 0 && ( $this->nb_rows_format_success >= $this->nb_rows_format_processed )),
        ]);
    }

    public function setRowFormatSuccess($row) {
        $this->row_last_format_processed = $row;
        $this->nb_rows_format_processed += 1;
        $this->nb_rows_format_success += 1;

        $this->save();
    }

    #endregion


    #region Notification

    public function notify(ReportTreatmentStepResult $report_treatment_step_result, bool $format_if_any = false): OperationResult
    {
        $operation_result = $report_treatment_step_result->addOperationResult("Notify Report");

        try {

            if ( $this->formatted ) {
                if ( count( $this->matchedanalysisrules ) > 0 ) {

                    $this->startNotification();

                    Mail::to("J.NGOMNZE@moov-africa.ga")
                        ->send(new NotifyReport($this));

                    $this->resetMatchedAnalysisRules();

                    $this->endNotification(true);
                }

                return $operation_result->endWithSuccess();
            } else {
                return $operation_result->endWithSuccess("File not formatted");
            }
        } catch (\Exception $e) {
            $this->endNotification(false);
            return $operation_result->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    private function startNotification(bool $reset_notified = false) {
        $this->notification_processing = 1;
        $this->nb_notification_try += 1;

        if ($reset_notified) {
            $this->notified = false;
        }

        $this->save();
    }

    private function endNotification(bool $success = true) {
        $data = [
            'notification_processing' => 0,
            'notified' => $success,
        ];
        if ($success) {
            $data['last_notification_success'] = Carbon::now();
        } else {
            $data['last_notification_failed'] = Carbon::now();
        }

        $this->update(
            $data
        );
    }

    #endregion

    #endregion

    #region Private Functions

    #endregion

    /*protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
            $model->setFormalizedExtension();
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
            $model->setFormalizedExtension();
        });
    }*/
}
