<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/noutati',[HomeController::class,'news'])->name('noutati');
Route::get('/noutati/{slug}',[HomeController::class,'post'])->name('NewsPost');
Route::get('/fotografii',[HomeController::class,'gallery'])->name('fotografii');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/contacte',[HomeController::class,'contacte'])->name('contacte');
