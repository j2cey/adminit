<?php


namespace App\Traits\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicRow;
use App\Models\DynamicAttributes\DynamicValue;
use App\Models\DynamicAttributes\DynamicAttribute;

trait HasDynamicValues
{
    abstract public function getFormattedValue($thevalue);

    #region Eloquent Relationships

    public function dynamicattribute() {
        return $this->belongsTo(DynamicAttribute::class,"dynamic_attribute_id");
    }

    public function valuerow() {
        return $this->belongsTo(DynamicRow::class,"dynamic_row_id");
    }

    public function dynamicvalue()
    {
        return $this->morphOne(DynamicValue::class, 'hasdynamicvalue');
    }

    #endregion

    #region Custom Methods

    public function setValue($thevalue, DynamicRow $row) {
        $this->update([
            'thevalue' => $this->getFormattedValue($thevalue),
        ]);

        $this->dynamicvalue()
            ->create()                      // create a new DynamicValue wich will wrappe the current inner value
            ->valuerow()->associate($row)   // associate the created DynamicValue with the given row
            ->save();                       // save the association from the DynamicValue (the wrapper)

        $row->setLastInserted();            // update the row's last inserted date

        return $this;
    }

    #endregion

    protected function initializeHasDynamicValues()
    {
        $this->with = array_unique(array_merge($this->with, ['dynamicattribute']));
    }

    public static function bootHasDynamicValues()
    {
        static::deleting(function ($model) {
            $model->dynamicvalue()->delete();
        });
    }
}
