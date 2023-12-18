<?php

namespace App\Traits\DynamicAttribute;

use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
use App\Models\DynamicValue\DynamicValue;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Contracts\DynamicAttribute\IInnerDynamicValue;

/**
 * @property DynamicValue $dynamicvalue
 * @method static IInnerDynamicValue create(array $array)
 */
trait InnerDynamicValue
{
    abstract public static function getFormattedValue($thevalue);

    #region Eloquent Relationships

    /**
     * @return BelongsTo
     */
    /*public function dynamicattributes() {
        return $this->belongsTo(DynamicAttribute::class,"dynamic_attribute_id");
    }*/

    public function dynamicrow() {
        return $this->belongsTo(DynamicRow::class,"dynamic_row_id");
    }

    public function dynamicvalue()
    {
        return $this->morphOne(DynamicValue::class, 'innerdynamicvalue');
    }

    #endregion

    #region Custom Methods

    /**
     * @return Model|DynamicValue
     */
    public function createDynamicValue(): Model|DynamicValue
    {
        return $this->dynamicvalue()
            ->create();
    }

    /**
     * @param $thevalue
     * @param DynamicAttribute $dynamicattribute
     * @param DynamicRow $row
     * @return IInnerDynamicValue
     */
    public static function createNew($thevalue, DynamicAttribute $dynamicattribute, DynamicRow $row): IInnerDynamicValue
    {
        $innervalue = self::create([
            'thevalue' => self::getFormattedValue($thevalue),
        ]);

        $dynamicvalue = $innervalue->createDynamicValue();                 // create a new DynamicValue wich will wrappe the current inner value

        $dynamicvalue->dynamicrow()->associate($row);                      // associate the created DynamicValue with the given row
        $dynamicvalue->dynamicattribute()->associate($dynamicattribute);    // associate the created DynamicValue with the given DynamicAttribute

        $dynamicvalue->save();                                                          // save the association from the DynamicValue (the wrapper)

        $row->setLastInserted();                                           // update the row's last inserted date

        return $innervalue;
    }

    public static function createFromDynamicValue(DynamicValue $dynamicvalue): IInnerDynamicValue
    {
        $innervalue = self::create([
            'thevalue' => self::getFormattedValue($dynamicvalue->raw_value),
        ]);

        $dynamicvalue->innerdynamicvalue_id = $innervalue->id;
        $dynamicvalue->save();

        //$dynamicvalue->innerdynamicvalue()->associate($innervalue);
        //$innervalue->dynamicvalue()->save();
        //$dynamicvalue = $innervalue->createDynamicValue();               // create a new DynamicValue wich will wrappe the current inner value
        //$dynamicvalue->dynamicrow()->associate($row);                      // associate the created DynamicValue with the given row
        //$dynamicvalue->dynamicattribute()->associate($dynamicattribute)    // associate the created DynamicValue with the given DynamicAttribute
        //->save();                                                          // save the association from the DynamicValue (the wrapper)

        $dynamicvalue->dynamicrow->setLastInserted();                                           // update the row's last inserted date

        return $innervalue;
    }

    public function setValue($thevalue, DynamicRow $row) {
        $this->update([
            'thevalue' => $this->getFormattedValue($thevalue),
        ]);

        $dynamicvalue = $this->dynamicvalue()
            ->create();                      // create a new DynamicValue wich will wrappe the current inner value
        $dynamicvalue->dynamicrow()->associate($row)   // associate the created DynamicValue with the given row
            ->save();                       // save the association from the DynamicValue (the wrapper)

        $row->setLastInserted();            // update the row's last inserted date

        $row->addColumnValue($this->dynamicvalue->dynamicattribute->name,$thevalue);    // add the value to the json columns values field

        return $dynamicvalue;
    }

    public function setValue_new($thevalue, DynamicRow $row) {
        $this->update([
            'thevalue' => $this->getFormattedValue($thevalue),
        ]);

        $row->setLastInserted();            // update the row's last inserted date

        $row->addColumnValue(
            $this->dynamicvalue->dynamicattribute->name,$thevalue
        );                                  // add the value to the json columns values field

        return $this;
    }

    #endregion

    protected function initializeHasDynamicValues()
    {
        $this->with = array_unique(array_merge($this->with, ['dynamicattributes']));
    }

    public static function bootInnerDynamicValue()
    {
        static::deleting(function ($model) {
            //$model->dynamicvalue()->delete();
        });
    }
}
