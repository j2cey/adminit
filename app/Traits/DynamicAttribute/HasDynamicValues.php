<?php

namespace App\Traits\DynamicAttribute;

use App\Contracts\DynamicAttribute\IHasDynamicAttributes;

trait HasDynamicValues
{
    public abstract function dynamicvalues();

    public function addValues(IHasDynamicAttributes $hasdynamicattributes, array $raw_value) {
        //\Log::info("HasDynamicValues - addValues, hasdynamicattributes: " . $hasdynamicattributes->id);
        $this->dynamicvalues()->createMany( $this->getDataArray($hasdynamicattributes, $raw_value) );
    }

    private function getDataArray(IHasDynamicAttributes $hasdynamicattributes, array $raw_value) {
        $dataarray = [];
        foreach ($hasdynamicattributes->dynamicattributesOrdered as $dynamicattribute) {
            $index = $dynamicattribute->num_ord - 1;
            //\Log::info("HasDynamicValues - getDataArray, index: " . $index);
            $dataarray[] = [
                'raw_value' => $raw_value[$index],
                'dynamic_attribute_id' => $dynamicattribute->id,
                'dynamic_row_id' => $this->id,

                'innerdynamicvalue_type' => $dynamicattribute->dynamicattributetype->model_type,
            ];
        }
        return $dataarray;
    }

    public function setValuesImported() {
        //\Log::info("setValuesImported - dynamicvalues count: " . $this->dynamicvalues()->count() . ", raw_value count: " . count( json_decode($this->raw_value) ) );
        $this->is_imported = $this->dynamicvalues()->count() >= count( json_decode($this->raw_value) );
        $this->save();

        return $this->is_imported;
    }
}
