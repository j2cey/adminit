<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileHeader\FileHeaderController;


Route::resource('fileheaders',FileHeaderController::class)->middleware('auth');
Route::get('fileheaders.fetch',[FileHeaderController::class,'fetch'])
    ->name('fileheaders.fetch')
    ->middleware('auth');
