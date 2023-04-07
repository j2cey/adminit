<?php


namespace App\Traits\DynamicAttribute;

use App\Models\Status;
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

    public function getModelTypeAttribute(): string
    {
        return static::class;
    }

    /**
     * Get all of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function dynamicattributes()
    {
        return $this->morphMany(DynamicAttribute::class, 'hasdynamicattribute');
    }
    /**
     * Get all of the model's dynamic dynamicattributes ordered
     * @return mixed
     */
    public function dynamicattributesOrdered()
    {
        return $this->dynamicattributes()
            ->orderBy('num_ord');
    }


    /**
     * Get the lastets of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function latestDynamicattribute()
    {
        return $this->morphOne(DynamicAttribute::class, 'hasdynamicattribute')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic dynamicattributes
     * @return mixed
     */
    public function oldestDynamicattribute()
    {
        return $this->morphOne(DynamicAttribute::class, 'hasdynamicattribute')->oldest('id');
    }

    #region Custom Functions

    /**
     * @param $name
     * @param Model|DynamicAttributeType $dynamicattributetype
     * @param Status|null $status
     * @param string|null $description
     * @param int|null $offset
     * @param int|null $max_length
     * @param bool|null $searchable
     * @param bool|null $sortable
     * @return DynamicAttribute
     */
    public function addDynamicAttribute(
        $name,Model|DynamicAttributeType $dynamicattributetype,
        Status $status = null,
        string $description = null,
        int $offset = null,
        int $max_length = null,
        bool $searchable = null,
        bool $sortable = null
    ): DynamicAttribute
    {
        $num_ord = $this->dynamicattributes()->count() + 1;                     // set the attribute number order
        $data = [
            'name' => $name,
            'num_ord' => $num_ord,
            'description' => $description,
        ];
        if ( ! is_null($offset) ) $data['offset'] = $offset;
        if ( ! is_null($max_length) ) $data['max_length'] = $max_length;
        if ( ! is_null($searchable) ) $data['searchable'] = $searchable;
        if ( ! is_null($sortable) ) $data['sortable'] = $sortable;

        $dynamicattribute = $this->dynamicattributes()->create($data)           // create and attach a new DynamicAttribute to the current model object
        ->dynamicattributetype()->associate($dynamicattributetype);             // associate the created DynamicAttribute with the given DynamicAttributeType

        if ( ! is_null($status) ) {
            $dynamicattribute->status()->associate($status);                    // set status
        }

        $dynamicattribute->save();                                              // save the association from the DynamicAttribute

        $this->setAddAttributeToList($dynamicattribute);

        return $dynamicattribute;
    }

    /**
     * Add Many DynamicAttribute at once
     * @param array $attributes Attributes array: [['name' => "string", 'type' => DynamicAttributeType, 'status' => Status, 'description' => "string", 'offset' => int, 'max_length' => int, 'searchable' => bool, 'sortable' => bool]]
     * @return int
     */
    public function addDynamicAttributeMany(array $attributes) {
        $nb_created = 0;

        foreach ($attributes as $attribute) {
            $this->addDynamicAttribute(
                $attribute['name'],
                $attribute['type'],
                $attribute['status'] ?? null,
                $attribute['description'] ?? null,
                $attribute['offset'] ?? null,
                $attribute['max_length'] ?? null,
                $attribute['searchable'] ?? null,
                $attribute['sortable'] ?? null
            );
        }

        return $nb_created;
    }

    #endregion

    protected function initializeHasDynamicAttributes()
    {
        $this->with = array_unique(array_merge($this->with, ['dynamicattributes']));
        $this->appends = array_unique(array_merge($this->appends, ['modelType']));
    }

    public static function bootHasDynamicAttributes()
    {
        static::deleting(function ($model) {
            $model->dynamicattributes()->delete();
        });
    }
}
