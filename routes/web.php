<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SqlInjectionDemoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sqli', [SqlInjectionDemoController::class, 'index'])->name('sqli.index');
Route::post('/sqli/vulnerable', [SqlInjectionDemoController::class, 'vulnerable'])->name('sqli.vulnerable');
Route::post('/sqli/secure', [SqlInjectionDemoController::class, 'secure'])->name('sqli.secure');
