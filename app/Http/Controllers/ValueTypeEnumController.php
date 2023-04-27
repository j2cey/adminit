<?php

namespace App\Http\Controllers;


use App\Enums\ValueTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValueTypeEnumController extends Controller
{
    public function fetch() {
        return ValueTypeEnum::toAssociativeArray();
    }
}
