<?php

namespace App\Traits\Format;

use App\Models\Format\FormattingResult;
use App\Contracts\Format\IIsFormattable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property bool $isFormatted
 * @property bool $isFormattingDone
 * @property FormattingResult $formattingresult
 *
 * @method static Builder formatted()
 */
trait IsFormattable
{
    abstract public function getFormattedSuccessRate(): float;

    /**
     * @return MorphOne
     */
    public function formattingresult() {
        return $this->morphOne(FormattingResult::class, 'formattable');
    }

    #region Accessors & Mutators

    public function getIsFormattedAttribute() {
        return ($this->formattingresult && $this->formattingresult->formatted);
    }

    public function getIsFormattingDoneAttribute() {
        return ($this->formattingresult && $this->formattingresult->formatting_done);
    }

    #endregion

    #region Scopes

    public function scopeFormatted($query) {
        return $query->whereHas('formattingresult', function (Builder $q) {
            $q->where('formatted', 1);
        });
    }

    #endregion

    public function setFormattingResult() {
        if ( is_null($this->formattingresult) ) {
            $this->formattingresult()->save( FormattingResult::createNew([]) );
            $this->load('formattingresult');
        }
    }

    public function startingFormatting(int $nb_to_format, IIsFormattable|null $upper_formattable): FormattingResult {
        $upper_formattable?->setFormattingResult();
        $this->setFormattingResult();
        return $this->formattingresult->setStarting($nb_to_format, $this->getFormattedSuccessRate(), $upper_formattable?->formattingresult);
    }

    public function itemFormattingFailed(int $item, string $message) {
        if ( ! is_null($this->formattingresult) ) {
            $this->formattingresult->itemFormattingFailed($item, $message);
        }
    }

    public function itemFormattingSucceed(int $item) {
        if ( ! is_null($this->formattingresult) ) {
            $this->formattingresult->itemFormattingSucceed($item);
        }
    }

    public function allFormattingSucceed() {
        if ( ! is_null($this->formattingresult) ) {
            $this->formattingresult->allFormattingSucceed();
        }
    }

    public function allFormattingFailed(string $message) {
        if ( ! is_null($this->formattingresult) ) {
            $this->formattingresult->allFormattingFailed($message);
        }
    }

    protected function initializeIsFormattable()
    {
        $this->with = array_unique(array_merge($this->with, ['formattingresult']));
    }

    public static function bootIsFormattable()
    {
        static::deleting(function ($model) {
            $model->formattingresult?->delete();
        });
    }
}
