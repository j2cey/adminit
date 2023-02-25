<?php


namespace App\Traits\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\DynamicAttributes\DynamicAttributeType;

trait HasDynamicAttributes
{
    use HasDynamicRows;

    /**
     * Get all of the model's dynamic attributes
     * @return mixed
     */
    public function dynamicattributes()
    {
        return $this->morphMany(DynamicAttribute::class, 'hasdynamicattribute');
    }


    /**
     * Get the lastets of the model's dynamic attributes
     * @return mixed
     */
    public function latestDynamicattribute()
    {
        return $this->morphOne(DynamicAttribute::class, 'hasdynamicattribute')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic attributes
     * @return mixed
     */
    public function oldestDynamicattribute()
    {
        return $this->morphOne(DynamicAttribute::class, 'hasdynamicattribute')->oldest('id');
    }

    #region Custom Functions

    public function addDynamicAttribute($name,DynamicAttributeType $attribute_type,$description) {
        $num_ord = $this->dynamicattributes()->count() + 1;         // set the attribute number order
        $dynamicattribute = $this->dynamicattributes()->create([
            'name' => $name,
            'num_ord' => $num_ord,
            'description' => $description,
        ])                                                  // create and attach a new DynamicAttribute to the current model object
        ->attributetype()->associate($attribute_type);      // associate the created DynamicAttribute with the given DynamicAttributeType
        $dynamicattribute->save();                          // save the association from the DynamicAttribute

        return $dynamicattribute;
    }

    #endregion

    protected function initializeHasDynamicAttributes()
    {
        $this->with = array_unique(array_merge($this->with, ['dynamicattributes']));
    }

    public static function bootHasDynamicAttributes()
    {
        static::deleting(function ($model) {
            $model->dynamicattributes()->delete();
        });
    }
}
