<?php

namespace App\Contracts\DynamicAttribute;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\DynamicAttributes\DynamicAttributeType;

/**
 * @property DynamicAttribute latestDynamicattribute
 * @property DynamicAttribute oldestDynamicattribute
 */
interface IHasDynamicAttributes extends Auditable
{
    /**
     * @return morphMany
     */
    public function dynamicattributes();

    /**
     * @return morphMany
     */
    public function dynamicattributesOrdered();

    /**
     * @return morphOne
     */
    public function latestDynamicattribute();

    public function addDynamicAttribute($name,Model|DynamicAttributeType $dynamicattributetype, Status $status = null, string $description = null): DynamicAttribute;
    public function addDynamicAttributeMany(array $attributes);
}