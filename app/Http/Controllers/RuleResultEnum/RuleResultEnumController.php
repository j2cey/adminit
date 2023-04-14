<?php

namespace App\Http\Controllers\RuleResultEnum;

use App\Enums\RuleResultEnum;
use App\Http\Controllers\Controller;

class RuleResultEnumController extends Controller
{
    public function fetch() {
        return RuleResultEnum::toAssociativeArray();
    }
}
