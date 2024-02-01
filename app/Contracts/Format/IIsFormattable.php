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
    public function formattingresult();
    public function setFormattingResult();

    public function addToFormat(int $amount);
    public function startingFormatting(int|null $nb_to_format): FormattingResult;

    public function itemFormattingSucceed(int $item);
    public function itemFormattingFailed(int $item, string $message);
    public function allFormattingSucceed();
    public function allFormattingFailed(string $message);
}
