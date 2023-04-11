<?php

namespace App\Contracts\FormattedValue;

use App\Enums\HtmlTagKey;

interface IFormattedValueHtml extends IFormattedValue
{
    public function setMainTag(HtmlTagKey $tag_key);
}
