<?php

namespace App\Contracts\Format;

use App\Models\Format\FormattingResult;

/**
 * @property bool $isFormatted
 * @property bool $isFormattingDone
 * @property FormattingResult $formattingresult
 */
interface IIsFormattable
{
    public function startingFormatting(int $nb_to_format, IIsFormattable|null $upper_formattable): FormattingResult;
    public function itemFormattingSucceed(int $item);
    public function itemFormattingFailed(int $item, string $message);
    public function allFormattingSucceed();
    public function allFormattingFailed(string $message);
}
