<?php

namespace App\Traits\Import;

use App\Models\Import\ImportResult;
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

    public function setImportResult() {
        if ( is_null($this->importresult) ) {
            $this->importresult()->save(ImportResult::createNew([]));
            $this->load('importresult');
        }
    }

    public function startingImport(int $nb_to_import, IIsImportable|null $upper_importable): ImportResult {
        $upper_importable?->setImportResult();
        $this->setImportResult();
        return $this->importresult->setStarting($nb_to_import, $this->getImportedSuccessRate(), $upper_importable?->importresult);
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
        static::deleting(function ($model) {
            $model->importresult?->delete();
        });
    }
}
