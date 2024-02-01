<?php

namespace App\Models\Format;

use App\Contracts\Format\IIsFormattable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property bool $isFormatted
 * @property bool $isFormattingDone
 * @property bool $isMergingReady
 * @property FormattingResult $formattingresult
 *
 * @method static Builder formatted()
 */
trait IsFormattable
{
    abstract public function getFormattedSuccessRate(): float;
    abstract public function getUpperIsFormattable(): ?IIsFormattable;

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

    public function getIsMergingReadyAttribute() {
        return ($this->formattingresult && $this->formattingresult->merging_ready);
    }

    #endregion

    #region Scopes

    public function scopeFormatted($query) {
        return $query->whereHas('formattingresult', function (Builder $q) {
            $q->where('formatted', 1);
        });
    }

    #endregion

    public function reloadFormattingResult() {
        $this->load('formattingresult');
    }

    public function setFormattingResult() {
        if ( is_null($this->formattingresult) ) {
            $this->formattingresult()->save( FormattingResult::createNew([
                'posi' => 1,
                'min_formatted_success_rate' => $this->getFormattedSuccessRate()
            ]) );
            //$this->load('formattingresult');
            $this->setUpperFormattingResult($this->getUpperIsFormattable()?->formattingresult);
        }
    }

    public function setUpperFormattingResult(FormattingResult|null $upperformattingresult) {
        if ( is_null( $this->formattingresult ) ) {
            $this->refresh();
        }
        if ( is_null($upperformattingresult) ) {
            return;
        }
        $this->formattingresult?->setUpperFormattingResult($upperformattingresult);
    }

    public function addToFormat(int $amount) {
        $this->formattingresult?->addToFormat($amount);
    }

    public function startingFormatting(int|null $nb_to_format): FormattingResult {
        //$upper_formattable?->setFormattingResult();
        //$this->setFormattingResult();
        if ( ! is_null($nb_to_format) ) {
            $this->formattingresult->addToFormat($nb_to_format);
        }
        $this->formattingresult->setStarting();

        return $this->formattingresult;
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
    public function setMergingReady() {
        $this->formattingresult?->setMergingReady();
    }

    protected function initializeIsFormattable()
    {
        $this->with = array_unique(array_merge($this->with, ['formattingresult']));
    }

    public static function bootIsFormattable()
    {
        // after the model has been created
        static::created(function ($model) {
            // We rebuild the whole path
            $model->setFormattingResult();
        });

        static::deleting(function ($model) {
            $model->formattingresult?->delete();
        });
    }
}
