<?php

namespace App\Contracts\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicRow;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface IInnerDynamicValue
{
    /**
     * @return belongsTo
     */
    public function dynamicrow();

    /**
     * @return morphOne
     */
    public function dynamicvalue();

    /**
     * @param $thevalue
     * @param DynamicRow $row
     * @return IInnerDynamicValue
     */
    public function setValue($thevalue, DynamicRow $row);

    public function getValue();
}
