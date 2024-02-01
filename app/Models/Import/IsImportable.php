<?php

namespace App\Models\Import;

use App\Contracts\Import\IIsImportable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property bool $isImported
 * @property bool $isImportDone
 * @property ImportResult $importresult
 *
 * @method static Builder imported()
 */
trait IsImportable
{
    abstract public function getImportedSuccessRate(): float;
    abstract public function getUpperIsImportable(): ?IIsImportable;

    /**
     * @return MorphOne
     */
    public function importresult() {
        return $this->morphOne(ImportResult::class, 'importable');
    }

    #region Accessors & Mutators

    public function getIsImportedAttribute() {
        return ($this->importresult && $this->importresult->imported);
    }

    public function getIsImportDoneAttribute() {
        return ($this->importresult && $this->importresult->import_done);
    }

    #endregion

    #region Scopes

    public function scopeImported($query) {
        return $query->whereHas('importresult', function (Builder $q) {
            $q->where('imported', 1);
        });
    }

    #endregion

    public function reloadImportResult() {
        $this->load('importresult');
    }

    public function setImportResult() {
        if ( is_null($this->importresult) ) {
            $this->importresult()->save(ImportResult::createNew([
                'posi' => 1,
                'min_imported_success_rate' => $this->getImportedSuccessRate()
            ]));
            //$this->load('importresult');
            $this->setUpperImportResult($this->getUpperIsImportable()?->importresult);
        }
    }

    public function setUpperImportResult(ImportResult|null $upperimportresult) {
        if ( is_null( $this->importresult ) ) {
            $this->refresh();
        }
        if ( is_null($upperimportresult) ) {
            return;
        }
        $this->importresult?->setUpperImportResult($upperimportresult);
    }

    public function addToImport(int $amount) {
        $this->importresult?->addToImport($amount);
    }

    public function startingImport(int|null $nb_to_import): ImportResult {
        //$upper_importable?->setImportResult();
        //$this->setImportResult();
        if ( ! is_null($nb_to_import) ) {
            $this->importresult->addToImport($nb_to_import);
        }
        $this->importresult->setStarting();

        return $this->importresult;
    }

    public function itemImportSucceed(int $item) {
        if ( ! is_null($this->importresult) ) {
            $this->importresult->itemImportSucceed($item);
        }
    }

    public function itemImportFailed(int $item, string $message) {
        if ( ! is_null($this->importresult) ) {
            $this->importresult->itemImportFailed($item, $message);
        }
    }

    public function allImportSucceed() {
        if ( ! is_null($this->importresult) ) {
            $this->importresult->allImportSucceed();
        }
    }

    public function allImportFailed(string $message) {
        if ( ! is_null($this->importresult) ) {
            $this->importresult->allImportFailed($message);
        }
    }

    protected function initializeIsImportable()
    {
        $this->with = array_unique(array_merge($this->with, ['importresult']));
    }

    public static function bootIsImportable()
    {
        // after the model has been created
        static::created(function ($model) {
            // We set an import result for the model
            $model->setImportResult();
        });

        // when deleting the model
        static::deleting(function ($model) {
            $model->importresult?->delete();
        });
    }
}
