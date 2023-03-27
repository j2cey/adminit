<?php


namespace App\Traits\DynamicAttribute;

use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\DynamicAttributes\DynamicAttributeType;

/**
 * @property DynamicAttribute[] $dynamicattributes
 * @property DynamicAttribute[] $dynamicattributesOrdered
 */
trait HasDynamicAttributes
{
    public abstract function setAddAttributeToList(DynamicAttribute $dynamicattribute);
    public abstract function setAttributesList();

    /**
     * Get all of the model's dynamic attributes
     * @return mixed
     */
    public function dynamicattributes()
    {
        return $this->morphMany(DynamicAttribute::class, 'hasdynamicattribute');
    }
    /**
     * Get all of the model's dynamic attributes ordered
     * @return mixed
     */
    public function dynamicattributesOrdered()
    {
        return $this->dynamicattributes()
            ->orderBy('num_ord');
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

    /**
     * @param $name
     * @param Model|DynamicAttributeType $attribute_type
     * @param string|null $description
     * @return DynamicAttribute
     */
    public function addDynamicAttribute($name,Model|DynamicAttributeType $attribute_type, string $description = null): DynamicAttribute
    {
        $num_ord = $this->dynamicattributes()->count() + 1;         // set the attribute number order
        $dynamicattribute = $this->dynamicattributes()->create([
            'name' => $name,
            'num_ord' => $num_ord,
            'description' => $description,
        ])                                                  // create and attach a new DynamicAttribute to the current model object
        ->attributetype()->associate($attribute_type);      // associate the created DynamicAttribute with the given DynamicAttributeType
        $dynamicattribute->save();                          // save the association from the DynamicAttribute

        $this->setAddAttributeToList($dynamicattribute);

        return $dynamicattribute;
    }

    /**
     * Add Many DynamicAttribute at once
     * @param array $attributes Attributes array: [['name' => "name", 'type' => DynamicAttributeType, 'description' => "description"]]
     * @return int
     */
    public function addDynamicAttributeMany(array $attributes) {
        $nb_created = 0;

        foreach ($attributes as $attribute) {
            $this->addDynamicAttribute($attribute['name'], $attribute['type'], $attribute['description'] ?? null);
        }

        return $nb_created;
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
