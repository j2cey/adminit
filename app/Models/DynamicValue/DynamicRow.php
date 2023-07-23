<?php

namespace App\Models\DynamicValue;

use App\Enums\QueueEnum;
use App\Models\BaseModel;
use Illuminate\Bus\Batch;
use Illuminate\Support\Carbon;
use App\Enums\CriticalityLevelEnum;
use App\Jobs\FormatDynamicValueJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Jobs\MergeReportFileFormattedRowsJob;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\FormattedValue\HasFormattedValue;
use App\Models\ReportTreatments\OperationResult;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\DynamicAttribute\IHasDynamicRows;
use App\Contracts\FormattedValue\IHasFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Contracts\AnalysisRules\IHasMatchedAnalysisRules;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class DynamicRow
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $line_uuid
 * @property integer $line_num
 *
 * @property Carbon $firstinserted_at
 * @property Carbon $lastinserted_at
 *
 * @property string $hasdynamicrow_type
 * @property integer $hasdynamicrow_id
 *
 * @property array $columns_values
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicValue[] $dynamicvalues
 * @property IHasDynamicRows|IHasMatchedAnalysisRules $hasdynamicrow
 * @method static DynamicRow create(array $array)
 */
class DynamicRow extends BaseModel implements Auditable, IHasFormattedValue, IHasFormatRules
{
    use HasFactory, HasFormattedValue, HasFormatRules, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['dynamicvalues'];
    protected $casts = [
        'columns_values' => 'array'
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'line_uuid' => ['required'],
            'line_num' => ['required'],
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

    public function hasdynamicrow()
    {
        return $this->morphTo();
    }

    public function dynamicvalues() {
        return $this->hasMany(DynamicValue::class, "dynamic_row_id");
    }

    #endregion

    #region Custom Functions

    /**
     * @param $line_num
     * @return Model|DynamicRow
     */
    public static function createNew($line_num): Model|DynamicRow
    {
        //$related_object->dynamicrows()->save($dynamicrow);
        //$dynamicrow->setFormattedValue(HtmlTagKey::TABLE_ROW);

        return DynamicRow::create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'columns_values' => "[]",
        ]);
    }

    /**
     * Set the last inserted date
     * @param null $newdate
     */
    public function setLastInserted($newdate = null) {
        $finaldate = $newdate ?? Carbon::now();
        $this->update([
            'lastinserted_at' => $finaldate,
        ]);
    }

    public function isValueEqual(DynamicAttribute $dynamicattribute, mixed $attribute_value): bool {
        $result = false;
        $dynamicvalues = $this->dynamicvalues;
        foreach ($dynamicvalues as $dynamicvalue) {
            if ( $dynamicvalue->dynamicattribute->id === $dynamicattribute->id ) {
                $result = $dynamicvalue->isValueEqual($attribute_value);
            }
        }
        return $result;
    }

    public function mergeColumnsValues() {
        $this->columns_values = [];
        $merged_values = [];
        $dynamicvalues = $this->dynamicvalues;

        foreach ($dynamicvalues as $dynamicvalue) {
            $new_arr = [ $dynamicvalue->dynamicattribute->name => $dynamicvalue->innerdynamicvalue->getValue() ];
            $merged_values = array_merge($new_arr, $merged_values);
        }
        $this->columns_values = array_merge( $merged_values, $this->columns_values );
        $this->save();

        return $merged_values;
    }

    public function mergeFormattedColumnsValues(ReportTreatmentStepResult $step, bool $is_last_operation, int $row_index = null) {
        $operation = $step->addOperationResult("Merge " . $row_index . " (" . $this->line_num . ") ",CriticalityLevelEnum::HIGH,$is_last_operation,true);
        $operation->startOperation();
        try {
            // reset rawvalue from formatted values
            $this->resetRawValues();

            // get all dynamic values attached to this row
            $dynamicvalues = $this->dynamicvalues;

            foreach ($dynamicvalues as $dynamicvalue) {
                if ($dynamicvalue->dynamicattribute->can_be_notified) {
                    // merge each row (this) formatted value with all dynamic values formatted values
                    $this->mergeRawValueFromFormatted($dynamicvalue);
                }
            }
            $this->applyFormatFromRaw(null, $this->formatrules, true);
            return $operation->endWithSuccess("Ligne " . $row_index . " (" . $this->line_num . ") " . "merged");
        } catch (\Exception $e) {
            return $operation->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    public function formatRowColumns(CollectedReportFile $collectedreportfile, OperationResult $operation, int $row_index, string $batch_id, array $valueIds = null) {
        \Log::info("pickRowColumnForBatch, operation:".$operation->id);
        if ( is_null($valueIds) ) {
            \Log::info("valueIds is null");
        } else {
            $jobs = [];
            $append_batch_max = config('Settings.reporttreatment.formatcolumns.append_batch_max');
            for ($i = 1; $i <= $append_batch_max; $i++) {
                if(count($valueIds) > 0) {
                    $value_id = array_shift($valueIds);
                    $last_treatment = empty($valueIds);
                    $jobs[] = new FormatDynamicValueJob($operation, $this, $row_index, $value_id, $last_treatment);
                }
            }

            //$childopertion = $operation->addChildOperation("Format Dynamic Value ".$value_id." for File " . $collectedreportfile->local_file_name . ', Row ' . $this->id, CriticalityLevelEnum::HIGH);
            \Log::info("pickRowColumnForBatch, operation:" . $operation->id);
            //\Log::info("row_index:" . $row_index . ", value_id:" . $value_id . ", batch_id:" . $batch_id);
            // remove first id from values ids list
            $operation->addToPayload("valueIds", $valueIds);

            if ($batch_id == "0") {
                \Log::info("creating New Batch");
                // create new batch
                // Batching jobs 🥳
                $batch = Bus::batch(
                    $jobs
                )->name('Format File ' . $collectedreportfile->local_file_name . ', Row ' . $row_index . "(" . $this->id . ")")->onQueue(QueueEnum::FORMATFILES->value)->dispatch();
                $operation->addToPayload("batchId", $batch->id);
            } else {
                \Log::info("Add to Existing Batch " . $batch_id);
                // add new job to the batch
                $batch = Bus::findBatch($batch_id);
                $batch->add(
                    $jobs
                );
            }
        }
    }

    public function pickRowColumnsToFormat(OperationResult $operation, int $row_index) {
        // get all dynamic values attached to this row
        $dynamicvalues = $this->dynamicvalues;
        $childopertion =new OperationResult();
        foreach ($dynamicvalues as $col_index => $dynamicvalue) {
            //$jobs[] = new FormatDynamicValueJob($operation, $this, $row_index, $dynamicvalue);
            //FormatDynamicValueJob::dispatchSync($operation, $this, $row_index, $dynamicvalue);
            $childopertion = $operation->addChildOperation("Format Dynamic Value " . $col_index . " (".$dynamicvalue->id.")", CriticalityLevelEnum::HIGH);
            $childopertion->addToPayload("dynamicrowId",$this->id);
            $childopertion->addToPayload("dynamicvalueId",$dynamicvalue->id);
            $childopertion->addToPayload("rowIndex", $row_index);
        }
        $childopertion->setAsLastOperation();
    }

    public function formatDynamicValues(OperationResult $operation, CollectedReportFile $collectedreportfile, int $row_index = null) {
        //$operation_name = "Format File Row Columns - " . $collectedreportfile->local_file_name . is_null($row_index) ? " (".$this->line_num.")" : " Line ".$this->line_num."(".$row_index.")";
        $is_last_operation = ($operation->reporttreatmentstepresult->operationresults()->count() + 1) >= $collectedreportfile->dynamicrows()->count();

        //$operation_result = $reporttreatmentstepresult->addOperationResult($operation_name, CriticalityLevelEnum::HIGH, $is_last_operation);

        if ( $is_last_operation ) {
            $operation->setAsLastOperation();
        }

        try {
            $operation->startOperation();

            // reset rawvalue from formatted values
            $this->resetRawValues();

            // get all dynamic values attached to this row
            $dynamicvalues = $this->dynamicvalues;
            $dynamicvalues_ids = $this->dynamicvalues()->pluck('id');

            //$jobs = [];
            foreach ($dynamicvalues as $dynamicvalue) {
                //$jobs[] = new FormatDynamicValueJob($operation, $this, $row_index, $dynamicvalue);
                FormatDynamicValueJob::dispatchSync($operation, $this, $row_index, $dynamicvalue);
            }
            // Batching jobs 🥳
            /*Bus::batch($jobs)->then(function (Batch $batch) {
                //dispatch(new MergeReportFileFormattedRowsJob());
                // 👆 will be executed after all jobs finish successfully
            })->name('Format Dynamic Values - '. $row_index)->onQueue(QueueEnum::FORMATFILES->value)->dispatch();*/
            //Bus::chain($jobs)->onQueue(QueueEnum::FORMATFILES->value)->dispatch();
        } catch (\Exception $e) {
            return $operation->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    public function formatDynamicValue(OperationResult $operation, int $dynamicvalueId, int $row_index = null, bool $last_treatment = false) {
        try {
            $operation->startOperation();

            // apply formating (without rule) for each value
            $dynamicvalue = DynamicValue::getById($dynamicvalueId);
            $dynamicvalue->resetRawValues();
            $dynamicvalue->applyFormatFromRaw($dynamicvalue->getValue(), $dynamicvalue->getFormatRulesForNotification($this->hasdynamicrow), true);
            if ($dynamicvalue->dynamicattribute->can_be_notified) {
                // merge each row (this) formatted value with all dynamic values formatted values
                $this->mergeRawValueFromFormatted($dynamicvalue);
            }

            $operation->reporttreatmentstepresult->reporttreatmentresult->setWaiting();
            $operation->endWithSuccess("value ".$dynamicvalueId." formatted, row ".$this->id." (".$row_index.")",$last_treatment);
        } catch (\Exception $e) {
            return $operation->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    public function mergeColumnsFormattedValues(ReportTreatmentStepResult $reporttreatmentstepresult, CollectedReportFile $collectedreportfile, int $row_index = null) {
        $operation_name = "Format File Row Columns - " . $collectedreportfile->local_file_name . is_null($row_index) ? " (".$this->line_num.")" : " Line ".$this->line_num."(".$row_index.")";
        $is_last_operation = ($reporttreatmentstepresult->operationresults()->count() + 1) >= $collectedreportfile->dynamicrows()->count();

        $operation_result = $reporttreatmentstepresult->addOperationResult($operation_name, CriticalityLevelEnum::HIGH, $is_last_operation)
            ->startOperation();
        try {
            // reset rawvalue from formatted values
            $this->resetRawValues();

            // get all dynamic values attached to this row
            $dynamicvalues = $this->dynamicvalues;

            foreach ($dynamicvalues as $dynamicvalue) {
                // apply formating (without rule) for each value
                $dynamicvalue->resetRawValues();
                $dynamicvalue->applyFormatFromRaw($dynamicvalue->getValue(), $dynamicvalue->getFormatRulesForNotification($this->hasdynamicrow), true);
                if ($dynamicvalue->dynamicattribute->can_be_notified) {
                    // merge each row (this) formatted value with all dynamic values formatted values
                    $this->mergeRawValueFromFormatted($dynamicvalue);
                }
            }
            $this->applyFormatFromRaw(null, $this->formatrules, true);
            if ( $reporttreatmentstepresult->operationresults()->failed()->count() > 0 ) {
                $operation_result->endWithFailure("There is at least 1 operation failed for this Step");
            } else {
                $operation_result->endWithSuccess("Ligne ".$this->line_num . "formatted");
            }
        } catch (\Exception $e) {
            return $operation_result->endWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    /**
     * @param int $id
     * @return DynamicRow|null
     */
    public static function getById(int $id) {
        return DynamicRow::find($id);
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->dynamicvalues()->each(function($dynamicvalue) {
                $dynamicvalue->delete(); // <-- direct deletion
            });
            $model->columns_values = "[]";
        });
    }
}
