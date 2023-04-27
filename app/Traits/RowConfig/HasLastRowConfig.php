<?php

namespace App\Traits\RowConfig;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use App\Models\RowConfig\LastRowConfig;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property LastRowConfig $lastrowconfig
 */
trait HasLastRowConfig
{
    /**
     * @return MorphOne
     */
    public function lastrowconfig()
    {
        return $this->morphOne(LastRowConfig::class, 'haslastrowconfig');
    }

    public function setLastRowConfig(bool $ref_by_row_num = null,int $row_num = null,bool $ref_by_attribute_value = null, DynamicAttribute|Model $dynamicattribute = null, string $attribute_value = null, Status $status = null, string $description = null): ?LastRowConfig {

        if ( is_null( $this->lastrowconfig ) ) {
            $lastrowconfig = LastRowConfig::createNew($ref_by_row_num, $row_num, $ref_by_attribute_value, $dynamicattribute, $attribute_value, $status, $description);

            $this->lastrowconfig()->save($lastrowconfig);

            return $lastrowconfig;
        }
        return null;
    }
}
