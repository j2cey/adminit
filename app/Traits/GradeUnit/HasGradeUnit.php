<?php


namespace App\Traits\GradeUnit;


trait HasGradeUnit
{
    public function isSameOrAffiliated($unit_1_id, $unit_2_id) {
        if ($unit_1_id === $unit_2_id) {
            return 1;
        }
        // check if they are affiliated
        $unit_1_origin = $unit_1_id->getOriginUnit();
        $unit_2_origin = $unit_2_id->getOriginUnit();

        if ($unit_1_origin === $unit_2_origin) {
            return 1;
        } else {
            return -1;
        }
    }
}
