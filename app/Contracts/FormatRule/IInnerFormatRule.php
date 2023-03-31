<?php

namespace App\Contracts\FormatRule;

use App\Models\FormatRule\FormatRule;

interface IInnerFormatRule
{
    public static function createNew();
    public static function getList() : array;

    public function formatrule();
    public function attachUpperFormatRule(FormatRule $upperformatrule);
}
