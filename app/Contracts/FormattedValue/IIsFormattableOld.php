<?php

namespace App\Contracts\FormattedValue;

interface IIsFormattableOld
{
    public function setFormatted();

    public function setMerged();

    public function setIsNextToMerge(IIsFormattableOld $previous = null);

    public function unsetIsNextToMerge(IIsFormattableOld $previous = null);
}
