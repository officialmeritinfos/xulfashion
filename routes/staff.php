<?php

use App\Http\Controllers\Staff\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::domain('staff.localhost')->group(function () {

    Route::get('/',[LoginController::class,'landingPage'])->name('login');


});
