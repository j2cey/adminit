<?php

namespace App\Enums\Attributes;

use Attribute;

#[Attribute]
class ServiceClass
{
    public function __construct(public string $serviceclass,) {
    }
}
