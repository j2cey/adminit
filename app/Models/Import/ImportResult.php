<?php

namespace App\Models\Import;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\Time\HasDuration;
use App\Contracts\Import\IIsImportable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ImportResult
 * @package App\Models\Import
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Carbon|null $start_at
 *
 * @property int|null $nb_to_import
 * @property int|null $nb_import_success
 * @property float $import_success_rate
 * @property int|null $last_import_success
 * @property int|null $nb_import_failed
 * @property float $import_failed_rate
 * @property int|null $last_import_failed
 * @property int|null $last_import
 * @property int|null $nb_being_imported
 * @property int|null $nb_imported
 *
 * @property int $attempts
 * @property int $attempts_session_count
 *
 * @property float $min_imported_success_rate
 * @property int $imported
 * @property bool $import_done
 * @property Carbon|null $end_at
 * @property int|null $duration
 * @property string|null $duration_hhmmss
 *
 * @property string|null $importable_type
 * @property int|null $importable_id
 * @property int|null $posi
 *
 * @property string|null $last_failed_message
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property ImportResult|null $upperimportresult
 * @property IIsImportable $importable
 * @method static ImportResult create(array $data)
 */
class ImportResult extends BaseModel implements Auditable
{
    use HasFactory, HasDuration, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $casts = [
        'imported' => 'boolean',
        'start_at' => 'date',
        'end_at' => 'date',
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

    public function upperimportresult() {
        return $this->belongsTo(ImportResult::class, 'upper_importresult_id');
    }

    public function subimportresults() {
        return $this->hasMany(ImportResult::class, 'upper_importresult_id');
    }

    /**
     * @return MorphTo
     * Get the imported model.
     */
    public function importable()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createNew( array $data ): ImportResult {
        return ImportResult::create($data);
    }

    public function setUpperImportResult(ImportResult|null $upperimportresult) {
        if ( ! is_null( $upperimportresult ) ) {
            $upperimportresult->addSubImportResult($this);
        }
    }

    private function addSubImportResult(ImportResult $importresult) {
        $importresult->posi = $this->subimportresults()->count() + 1;
        $importresult->upperimportresult()->associate($this)->save();
    }

    public function addToImport(int $amount) {
        $this->update(['nb_to_import' => $this->nb_to_import+= $amount,]
        );
        $this->setImportUpToDate(true);

        $this->upperimportresult?->addToImport($amount);
    }

    public function setStarting(bool $force = false) {

        //$this->posi = 1;
        //$upper_importresult?->addSubImportResult($this);

        if ( is_null($this->start_at) || $force ) {
            $this->start_at = Carbon::now();
            $this->setNewAttempt();

            //$this->nb_to_import = $nb_to_import;
            $this->incrementImporting(false);

            $this->save();
        }

        $this->upperimportresult?->setStarting();

        //return $this;
    }

    private function setNewAttempt() {
        $this->attempts++;
        $this->attempts_session_count++;
    }

    public function incrementImporting(bool $save) {
        $this->nb_being_imported++;
        $this->saveObject($save);
    }

    /**
     * @param string $import_attribute import attribute to increment 'nb_import_success' or 'nb_import_failed'
     * @param int $amount items amount
     * @param bool $save
     * @return void
     */
    private function decrementImporting(string $import_attribute, int $amount, bool $save) {
        $this->{$import_attribute} += $amount;
        $this->nb_being_imported -= ($amount > $this->nb_being_imported) ? $this->nb_being_imported : $amount;
        $this->saveObject($save);
    }

    public function allImportSucceed() {
        $this->setAllImportDone("nb_import_success", "last_import_success");
    }

    public function allImportFailed(string $message) {
        $this->last_failed_message = $message;
        $this->setAllImportDone("nb_import_failed", "last_import_failed");
    }

    public function itemImportSucceed(int $item) {
        $this->last_import_success = $item;
        $this->setImportDone("nb_import_success",1, 1);

        $this->upperimportresult?->itemImportSucceed($item);
    }

    public function itemImportFailed(int $item, string $message) {
        $this->last_import_failed = $item;
        $this->last_failed_message = $message;
        $this->setImportDone("nb_import_failed",1, 1);

        $this->upperimportresult?->itemImportFailed($item, $message);
    }

    /**
     * @param string $nb_import_attribute import attribute to increment 'nb_import_success' or 'nb_import_failed'
     * @param string $last_import_attribute last import attribute to increment 'last_import_success' or 'last_import_failed'
     * @return void
     */
    private function setAllImportDone(string $nb_import_attribute, string $last_import_attribute) {
        $last_item = $this->nb_to_import - 1;

        $this->{$nb_import_attribute} = 0;
        $this->{$last_import_attribute} = $last_item;
        $this->nb_being_imported = $this->nb_to_import;
        $this->setImportDone($nb_import_attribute, $this->nb_to_import, $last_item);
    }

    private function setImportDone(string $import_attribute, int $amount, int $last_item) {
        //\Log::info("setImportDone (" . $this->id . "), amount: " . $amount . ", import_attribute: " . $import_attribute . ", importable: " . $this->importable_type . "(" . $this->importable_id . ")");
        if ( is_null( $this->start_at ) ) {
            $this->setStarting();
        }
        $this->last_import = $last_item;
        $this->decrementImporting($import_attribute, $amount, false);

        // adjust nb to import
        if ( $this->{$import_attribute} > $this->nb_to_import ) {
            $this->nb_to_import = $amount;
        }

        $this->setImportUpToDate(false);

        $this->save();
    }

    private function setImportUpToDate(bool $save) {
        $this->import_success_rate = ($this->nb_import_success / $this->nb_to_import) * 100;
        $this->import_failed_rate = ($this->nb_import_failed / $this->nb_to_import) * 100;

        $this->saveObject($save);

        $this->import_done = ($this->nb_import_success + $this->nb_import_failed) >= $this->nb_to_import;
        $this->imported = ( $this->import_success_rate >= $this->min_imported_success_rate );

        $this->endImport();
    }

    private function endImport() {
        if ($this->import_done) {
            $duration = $this->getNewDuration($this->start_at, null);

            $this->end_at = $duration->getEndAt();
            $this->duration = $duration->getDuration();
            $this->duration_hhmmss = $duration->getDurationHhmmss();
        }
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->subimportresults()->each(function($subimportresult) {
                $subimportresult->delete(); // <-- direct deletion
            });
        });
    }
}
