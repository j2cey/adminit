<?php

namespace App\Traits\Enum;

trait EnumTrait
{
    public static function toAssociativeArray(): array
    {
        foreach(self::cases() as $case) {
            $array[] = ['name' => $case->name, 'value' => $case->value];
        }
        return $array;
    }

    public function toArray() {
        return ['name' => $this->name, 'value' => $this->value];
    }
}
