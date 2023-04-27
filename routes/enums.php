<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuleResultEnum\RuleResultEnumController;


Route::get('ruleresultenums.fetch',[RuleResultEnumController::class,'fetch'])
    ->name('ruleresultenums.fetch')
    ->middleware('auth');