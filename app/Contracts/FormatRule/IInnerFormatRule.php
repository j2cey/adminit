<?php

namespace App\Contracts\FormatRule;

use App\Models\FormatRule\FormatRule;
use OwenIt\Auditing\Contracts\Auditable;

interface IInnerFormatRule extends Auditable
{
    public static function createNew();
    public static function getList() : array;

    public function formatrule();
    public function attachUpperFormatRule(FormatRule $upperformatrule);
    public function updateOne(string|IInnerFormatRule $innerformatrule);

    public function getFormatValue();
}
