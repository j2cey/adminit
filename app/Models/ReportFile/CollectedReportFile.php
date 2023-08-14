<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Enums\QueueEnum;
use App\Models\BaseModel;
use App\Enums\HtmlTagKey;
use Illuminate\Bus\Batch;
use Illuminate\Support\Carbon;
use App\Enums\TreatmentStepCode;
use App\Imports\ReportFilesImport;
use Illuminate\Support\Facades\Bus;
use App\Enums\CriticalityLevelEnum;
use App\Jobs\ReportFileImportedJob;
use App\Jobs\ReportFileNotifiedJob;
use Illuminate\Support\Facades\Mail;
use App\Jobs\FormatReportFileRowJob;
use App\Jobs\ReportFileFormattedJob;
use App\Mail\ReportFile\NotifyReport;
use Illuminate\Support\Facades\Storage;
use App\Models\DynamicValue\DynamicRow;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Events\ReportFileDownloadedEvent;
use App\Jobs\FormatReportFileRowColumnsJob;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Jobs\MergeReportFileFormattedRowsJob;
use App\Traits\DynamicAttribute\HasDynamicRows;
use App\Models\ReportTreatments\OperationResult;
use App\Traits\FormattedValue\HasFormattedValue;
use App\Models\ReportTreatments\ReportTreatment;
use App\Contracts\DynamicAttribute\IHasDynamicRows;
use App\Contracts\FormattedValue\IHasFormattedValue;
use App\Traits\AnalysisRules\HasMatchedAnalysisRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Contracts\AnalysisRules\IHasMatchedAnalysisRules;
use App\Models\ReportTreatments\ReportTreatmentStepResult;
use App\Traits\ReportTreatment\HasReportTreatmentSteps;
use App\Contracts\ReportTreatment\IHasReportTreatmentSteps;

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
class CollectedReportFile extends BaseModel implements Auditable, IHasDynamicRows, IHasFormattedValue, IHasFormatRules, IHasMatchedAnalysisRules, IHasReportTreatmentSteps
{
    use HasFactory, HasDynamicRows, HasFormattedValue, HasFormatRules, HasMatchedAnalysisRules, HasReportTreatmentSteps, \OwenIt\Auditing\Auditable;

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

    public function importToDb(ReportTreatment $reporttreatment, bool $reset_imported = false)
    {
        $reporttreatment->refresh();
        if ( $reporttreatment->canBeExecuted ) {
            $reporttreatmentstepresult = $this->addReportTreatmentStep($reporttreatment, TreatmentStepCode::IMPORTFILE, TreatmentStepCode::IMPORTFILE->toArray()['name'] . ", fichier " . $this->local_file_name, CriticalityLevelEnum::HIGH, true)
                ->startStepTreatment();

            $this->startImport($reporttreatmentstepresult, $reset_imported);

            try {

                if ($reporttreatmentstepresult->isSuccess) {

                    if ($reset_imported) {
                        $this->deleteImportedData($reporttreatmentstepresult);
                        if ($reporttreatmentstepresult->isFailed) {
                            $this->endImport($reporttreatmentstepresult, true);
                            $reporttreatmentstepresult->setMessage("Erreur Suppression Données importées . FILE: " . __FILE__ . "; LINE: " . __LINE__);
                        }
                    }

                    if ($reporttreatmentstepresult->isSuccess) {

                        $import_operation_result = $reporttreatmentstepresult->addOperationResult("Exécution du ReportFilesImport", CriticalityLevelEnum::HIGH);
                        $import = new ReportFilesImport($this, $import_operation_result);
                        $import->import($this->fileLocalAbsolutePath);
                        $import_operation_result->endWithSuccess();

                        if ($reporttreatmentstepresult->isSuccess) {
                            $this->mergeLinesValues($reporttreatmentstepresult);
                        }
                        $this->endImport($reporttreatmentstepresult, true);
                        ReportFileImportedJob::dispatch($this->reportfile->id, $reporttreatment)->onQueue(QueueEnum::IMPORTFILES->value);
                    }
                }
            } catch (\Exception $e) {
                $this->endImport($reporttreatmentstepresult, true);
                $reporttreatmentstepresult->endTreatmentWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            }
        }
    }

    public function deleteImportedData(ReportTreatmentStepResult $reporttreatmentstepresult): OperationResult
    {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Suppression Données importées", CriticalityLevelEnum::HIGH)
            ->startOperation();
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
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @param bool $reset_imported
     * @return void
     */
    private function startImport(ReportTreatmentStepResult $reporttreatmentstepresult, bool $reset_imported = false) {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Update Import Infos for Starting", CriticalityLevelEnum::MEDIUM)
            ->startOperation();

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

        $operation_result->endWithSuccess();
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
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @param bool $is_last_operation
     * @return void
     */
    private function endImport(ReportTreatmentStepResult $reporttreatmentstepresult, bool $is_last_operation) {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Update Import Infos for Ending", CriticalityLevelEnum::MEDIUM, $is_last_operation)
            ->startOperation();

        $this->update([
            'import_processing' => 0,
            'imported' => ($this->nb_rows_import_processed > 0 && ( $this->nb_rows_import_success >= $this->nb_rows_import_processed )),
        ]);

        $operation_result->endWithSuccess();
    }

    /**
     * Merge and return all rows imported data
     * @return array
     */
    public function mergeLinesValues(ReportTreatmentStepResult $reporttreatmentstepresult) {
        $operation_result = $reporttreatmentstepresult->addOperationResult("Merge des Données importées", CriticalityLevelEnum::HIGH)
            ->startOperation();

        $this->lines_values = "";
        $merged_values = [];
        $dynamicrows = $this->dynamicrows;

        foreach ($dynamicrows as $dynamicrow) {
            $merged_values[] = $dynamicrow->mergeColumnsValues();
        }
        $this->lines_values = json_encode($merged_values);
        $this->save();

        $operation_result->endWithSuccess();

        return $merged_values;
    }

    #endregion

    #region Data formatting

    /*public function formatImportedValues(ReportTreatmentResult $reporttreatmentresult, bool $reset_formatted = true)
    {
        $reporttreatmentresult->refresh();
        if ( $reporttreatmentresult->canBeExecuted ) {
            $reporttreatmentstepresult = $this->addReportTreatmentStepResult($reporttreatmentresult, TreatmentStepCode::FORMATDATA, "Formattage Valeurs Importées, fichier " . $this->local_file_name, CriticalityLevelEnum::HIGH, true)
                ->startStepTreatment();

            try {
                if ($this->imported) {
                    $this->startFormat($reset_formatted);
                    $this->mergeLinesFormattedValues($reporttreatmentstepresult, true);
                    $this->endFormat();
                } else {
                    $reporttreatmentstepresult->endTreatmentWithFailure("File not imported. FILE: " . __FILE__ . "; LINE: " . __LINE__);
                }
            } catch (\Exception $e) {
                $this->endFormat();
                $reporttreatmentstepresult->endTreatmentWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            }
        }
    }*/

    public function pickRows(ReportTreatmentStepResult $formatstep) {
        // create pick rows & columns operation
        $pick_rowscolumns_operation = $formatstep->addOperationResult(TreatmentStepCode::PREPAREFORMATTING->toArray()['name'],CriticalityLevelEnum::HIGH)
            ->setAsCurrentOperation()
            ->startOperation();
        // set rowsListOperationId Payload
        $formatstep->addToPayload("currentOperation", TreatmentStepCode::PREPAREFORMATTING->value);
        $rows = [];
        $rowsPerforming = [];
        $dynamicrows = $this->dynamicrows;
        foreach ($dynamicrows as $row_index => $dynamicrow) {
            $rows[$dynamicrow->id] = [
                'rowIndex' => $row_index,
                'columns' => $dynamicrow->dynamicvalues()->get()->pluck('id'),
            ];
            $rowsPerforming[$dynamicrow->id] = [
                'rowIndex' => $row_index,
                'columns' => [],
            ];
        }
        $formatstep->addToPayload("rows", $rows);
        // create and prepare next operation
        $this->formatingSetNextOperation($formatstep,TreatmentStepCode::MERGECOLUMNS,$rows,$rowsPerforming);

        $pick_rowscolumns_operation->endWithSuccess(count($rows) . " rows to format.");
    }
    public function perfomFormating(ReportTreatmentStepResult $formatstep) {
        if ( $formatstep->code === TreatmentStepCode::FORMATROWCOLUMNS ) {
            $this->formatRowColumns($formatstep);
        } elseif ( $formatstep->code === TreatmentStepCode::MERGECOLUMNS ) {
            $this->mergeColumns($formatstep);
        } elseif ( $formatstep->code === TreatmentStepCode::MERGEROWS ) {
            $this->mergeRows($formatstep);
        } else {
            // end formatting
        }
    }

    public function formatRowColumns(ReportTreatmentStepResult $formatstep) {
        $operation = $formatstep->currentoperation;
        $rows_to_format = $operation->getPayloadEntry("rowsToFormat");
        $rows_formatting = $operation->getPayloadEntry("rowsFormatting");
        $dynamicrow_id = null;
        $dynamicvalue_id = null;
        foreach ($rows_to_format as $rowId => $row_to_format) {
            if ( count($row_to_format['columns']) > 0 ) {
                if ( ! in_array($row_to_format['columns'][0], $rows_formatting['columns']) ) {
                    $dynamicrow_id = $rowId;
                    $dynamicvalue_id = array_shift($rows_to_format['columns']);
                    $rows_formatting[$rowId]['columns'][] = $dynamicvalue_id;

                    $rows_to_format[$rowId] = $row_to_format;

                    $operation->addToPayload("rowsToFormat", $rows_to_format);
                    $operation->addToPayload("rowsFormatting", $rows_formatting);
                    break;
                }
            }
            if ( ! is_null($dynamicrow_id) ) {
                break;
            }
        }
    }

    public function mergeColumns(ReportTreatment $reporttreatment) {
        //$formatstep = $reporttreatmentresult->currentstep;
        $reporttreatment->refresh();
        if ( $reporttreatment->canBeExecuted ) {
            $mergecolumns_step = $reporttreatment->addStep(TreatmentStepCode::MERGECOLUMNS,TreatmentStepCode::MERGECOLUMNS->toArray()['name'] . " (" . $this->local_file_name . ")", CriticalityLevelEnum::HIGH,true);
            // get all dynamic row attached to this object
            $dynamicrows = $this->dynamicrows;
            $dynamicrows_count = $this->dynamicrows()->count();

            foreach ($dynamicrows as $row_index => $dynamicrow) {
                $is_last_operation = ($row_index + 1) >= $dynamicrows_count;
                $operation = $dynamicrow->mergeFormattedColumnsValues($mergecolumns_step, $is_last_operation, $row_index);
                if ($operation->isFailed) {
                    break;
                }
            }
        }
    }
    public function mergeRows(ReportTreatment $reporttreatment) {
        $reporttreatment->refresh();
        if ( $reporttreatment->canBeExecuted ) {
            $mergerows_step = $reporttreatment->addStep(TreatmentStepCode::MERGEROWS,TreatmentStepCode::MERGEROWS->toArray()['name'] . " (" . $this->local_file_name . ")", CriticalityLevelEnum::HIGH,true);
            $operation = $mergerows_step->addOperationResult("Merge File Rows - " . $this->local_file_name, CriticalityLevelEnum::HIGH,true,true)
                ->startOperation();

            try {
                // reset rawvalue from formatted values
                $this->resetRawValues();

                $this->insertHeadersRow($this->getHeaders(), $this->reportfile->report->fileheader->formatrules);

                // get all dynamic row attached to this object
                $dynamicrows = $this->dynamicrows;

                $last_row = null;

                $this->startFormat(true);
                foreach ($dynamicrows as $row_index => $dynamicrow) {

                    $can_merge_this_row = false;

                    if ( $this->reportfile->lastrowconfig ) {

                        if ( $this->reportfile->lastrowconfig->isLastRow($dynamicrow) ) {

                            if ( ! is_null($last_row) ) {
                                $this->mergeRawValueFromFormatted($last_row);
                            }
                            $last_row = $dynamicrow;
                        } else {
                            $can_merge_this_row = true;
                        }
                    } else {
                        $can_merge_this_row = true;
                    }

                    if ( $can_merge_this_row ) {
                        // merge object (this) formatted values with all rows formatted values
                        $this->mergeRawValueFromFormatted($dynamicrow);
                    }

                    $this->setRowFormatSuccess($row_index);
                }

                if ( ! is_null($last_row) ) {
                    $this->mergeRawValueFromFormatted($last_row);
                }
                $this->applyFormatFromRaw(null, $this->formatrules);

                $this->endFormat();

                ReportFileFormattedJob::dispatch( $this->reportfile->id, $reporttreatment )->onQueue(QueueEnum::FORMATFILES->value);

                return $operation->endWithSuccess();
            } catch (\Exception $e) {
                return $operation->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
            }
        }
    }

    /**
     * @param ReportTreatmentStepResult $formatstep
     * @param TreatmentStepCode $operation_code
     * @param array $full_rows
     * @param array $rows_columns_empty
     * @return OperationResult
     */
    private function formatingSetNextOperation(ReportTreatmentStepResult $formatstep, TreatmentStepCode $operation_code, array $full_rows, array $rows_columns_empty) {
        $next_operation = $formatstep->addOperationResult($operation_code->toArray()['name'],CriticalityLevelEnum::HIGH)
            ->setCode($operation_code)
            ->setAsCurrentOperation();
        $next_operation->addToPayload("rowsToPerform", $full_rows);
        $next_operation->addToPayload("rowsPerforming", $rows_columns_empty);

        return $next_operation;
    }



















    public function pickFileRowsToFormat(ReportTreatmentResult $reporttreatmentresult) {
        $reporttreatmentresult->refresh();
        if ( $reporttreatmentresult->canBeExecuted ) {

            $reporttreatmentstepresult = $this->addReportTreatmentStep($reporttreatmentresult, TreatmentStepCode::PICKFILEROWSTOFORMAT, TreatmentStepCode::PICKFILEROWSTOFORMAT->toArray()['name'] . " (" . $this->local_file_name.")", CriticalityLevelEnum::HIGH, true)
                ->startStepTreatment();

            $next_step = $this->addReportTreatmentStep($reporttreatmentresult, TreatmentStepCode::FORMATROWCOLUMNS, TreatmentStepCode::FORMATROWCOLUMNS->toArray()['name'] . " (" . $this->local_file_name . ")", CriticalityLevelEnum::HIGH, false);

            // get all dynamic row attached to this object
            $nb_rows = 0;
            $dynamicrows = $this->dynamicrows;
            foreach ($dynamicrows as $row_index => $dynamicrow) {
                $curr_operation = $next_step->addOperationResult("Format Row " . $dynamicrow->id . " (".$row_index.")",CriticalityLevelEnum::HIGH);
                $curr_operation->addToPayload("rowId", $dynamicrow->id);
                $curr_operation->addToPayload("rowIndex", $row_index);
                $curr_operation->addToPayload("valueIds", $dynamicrow->dynamicvalues()->pluck('id'));

                $curr_operation->addToPayload("batchId", "0");

                //$dynamicrow->pickRowColumnsToFormat($curr_operation, $row_index);
                $nb_rows += 1;
            }

            $reporttreatmentstepresult->endTreatmentWithSuccess($nb_rows . " rows to format");
            $reporttreatmentresult->setCurrentStep($next_step);
        }
    }

    public function formatRowColumns_old(ReportTreatmentResult $reporttreatmentresult) {
        $reporttreatmentresult->refresh();
        if ( $reporttreatmentresult->canBeExecuted ) {
            //$reporttreatmentresult->currentstep->startStepTreatment();

            $operations_waiting_count = $reporttreatmentresult->currentstep->operationresults()->waiting()->count();
            \Log::info("pickRowColumnsToFormat, currentstep:".$reporttreatmentresult->currentstep->code->value);
            \Log::info("waiting operations count:" . $operations_waiting_count);
            $operation = $reporttreatmentresult->currentstep->getFirstOperationWaiting();
            $operation?->setQueued();
            if (! is_null($operation) ) {
                $payload_arr = json_decode($operation->payload, true);
                $dynamicrow = DynamicRow::getById($payload_arr['rowId']);

                $dynamicrow->formatRowColumns($this, $operation, $payload_arr['rowIndex'], $payload_arr['batchId'], $payload_arr['valueIds']);
            } else {
                \Log::info("no waiting operations");
            }
        }
    }

    public function formatFileRows(ReportTreatment $reporttreatment, bool $reset_formatted = true) {
        $reporttreatment->refresh();
        if ( $reporttreatment->canBeExecuted ) {
            \Log::info("formatFileRows, currentstep:".$reporttreatment->currentstep->code->value);
            \Log::info("waiting operations count:".$reporttreatment->currentstep->operationresults()->waiting()->count());
            $operation = $reporttreatment->currentstep->getFirstOperationWaiting();
            $operation?->setQueued();
            if (! is_null($operation) ) {
                $payload_arr = json_decode($operation->payload, true);
                $dynamicrow = DynamicRow::getById($payload_arr['rowId']);
                $dynamicrow->formatDynamicValues($operation, $this, $payload_arr['rowIndex']);
            } else {
                \Log::info("no waiting operations");
            }
        }
    }

    public function formatFileRows_old(ReportTreatmentResult $reporttreatmentresult, bool $reset_formatted = true) {
        $reporttreatmentresult->refresh();
        if ( $reporttreatmentresult->canBeExecuted ) {
            $reporttreatmentstepresult = $this->addReportTreatmentStep($reporttreatmentresult, TreatmentStepCode::FORMATFILEROWS, "Formattage LIGNES Importées, fichier " . $this->local_file_name, CriticalityLevelEnum::HIGH, true);

            // get all dynamic row attached to this object
            $dynamicrows = $this->dynamicrows;
            $jobs = [];
            foreach ($dynamicrows as $row_index => $dynamicrow) {
                $jobs[] = new FormatReportFileRowJob($reporttreatmentstepresult, $this, $dynamicrow, $row_index);
                //dispatch(new FormatReportFileRowJob($reporttreatmentstepresult, $this, $dynamicrow, $row_index))->onQueue(QueueEnum::FORMATFILES->value);
                //dispatch(new FormatReportFileRowJob($reporttreatmentresult->id, $reporttreatmentstepresult->id, $this->id, $dynamicrow->id, $row_index))->onQueue(QueueEnum::FORMATFILES->value);
                //$jobs[] = new FormatReportFileRowJob($reporttreatmentresult->id, $reporttreatmentstepresult->id, $this->id, $dynamicrow->id, $row_index);
            }
            // Batching jobs 🥳
            Bus::batch($jobs)->then(function (Batch $batch) {
                dispatch(new MergeReportFileFormattedRowsJob())->onQueue(QueueEnum::FORMATFILES->value);
                // 👆 will be executed after all jobs finish successfully
            })->name('Format Rows File ' . $this->id)->onQueue(QueueEnum::FORMATFILES->value)->dispatch();
        }
    }





    /**
     * Merge all Rows formatted values into the formatted values of this object
     * @param ReportTreatment $reporttreatment
     * @return OperationResult
     */
    public function mergeLinesFormattedValues(ReportTreatment $reporttreatment): OperationResult
    {
        $reporttreatmentstepresult = $this->addReportTreatmentStep($reporttreatment, TreatmentStepCode::MERGEFILEFORMATTEDROWS, TreatmentStepCode::MERGEFILEFORMATTEDROWS->toArray()['name'] ." (" . $this->local_file_name . ")", CriticalityLevelEnum::HIGH, true);
        $operation_result = $reporttreatmentstepresult->addOperationResult("Formattage et Merge des Lignes du fichier", CriticalityLevelEnum::HIGH, true)
            ->startOperation();
        try {
            // reset rawvalue from formatted values
            $this->resetRawValues();

            $this->insertHeadersRow($this->getHeaders(), $this->reportfile->report->fileheader->formatrules);

            // get all dynamic row attached to this object
            $dynamicrows = $this->dynamicrows;

            $last_row = null;

            foreach ($dynamicrows as $row_index => $dynamicrow) {

                // get merged formatted values for each row
                //$dynamicrow->mergeColumnsFormattedValues();
                $can_merge_this_row = false;

                if ( $this->reportfile->lastrowconfig ) {

                    if ( $this->reportfile->lastrowconfig->isLastRow($dynamicrow) ) {

                        if ( ! is_null($last_row) ) {
                            $this->mergeRawValueFromFormatted($last_row);
                        }
                        $last_row = $dynamicrow;
                    } else {
                        $can_merge_this_row = true;
                    }
                } else {
                    $can_merge_this_row = true;
                }

                if ( $can_merge_this_row ) {
                    // merge object (this) formatted values with all rows formatted values
                    $this->mergeRawValueFromFormatted($dynamicrow);
                }

                $this->setRowFormatSuccess($row_index);
            }

            if ( ! is_null($last_row) ) {
                $this->mergeRawValueFromFormatted($last_row);
            }
            $this->applyFormatFromRaw(null, $this->formatrules);

            return $operation_result->endWithSuccess();
        } catch (\Exception $e) {
            return $operation_result->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
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

    public function notify(ReportTreatment $reporttreatment, bool $format_if_any = false)
    {
        $reporttreatment->refresh();
        if ( $reporttreatment->canBeExecuted ) {
            $reporttreatmentstepresult = $this->addReportTreatmentStep($reporttreatment, TreatmentStepCode::NOTIFYFILE, TreatmentStepCode::NOTIFYFILE->toArray()['name'] . " (" . $this->local_file_name.")", CriticalityLevelEnum::HIGH, true)
                ->startStepTreatment();

            try {
                if ($this->formatted) {
                    if (count($this->matchedanalysisrules) > 0) {

                        $this->startNotification();

                        $receivers = ["J.NGOMNZE@moov-africa.ga", "jud10parfait@gmail.com", "F.ONDONKOGHE@moov-africa.ga", "djoni.ondo@gmail.com"];

                        foreach ($receivers as $receiver) {
                            Mail::to($receiver)
                                ->send(new NotifyReport($this));
                        }

                        $this->resetMatchedAnalysisRules();

                        $this->endNotification(true);
                    } else {
                        $reporttreatmentstepresult->setMessage("No Analysis Rules matched. FILE: " . __FILE__ . "; LINE: " . __LINE__);
                    }

                    $reporttreatmentstepresult->endTreatmentWithSuccess();

                    ReportFileNotifiedJob::dispatch($this->reportfile->id, $reporttreatment)->onQueue(QueueEnum::NOTIFYFILES->value);

                } else {
                    $reporttreatmentstepresult->endTreatmentWithFailure("File not formatted. FILE: " . __FILE__ . "; LINE: " . __LINE__);
                }
            } catch (\Exception $e) {
                $this->endNotification(false);
                $reporttreatmentstepresult->endTreatmentWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            }
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
