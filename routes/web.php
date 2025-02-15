<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/noutati',[HomeController::class,'news'])->name('noutati');
Route::get('/noutati/{slug}',[HomeController::class,'post'])->name('NewsPost');
Route::get('/fotografii',[HomeController::class,'gallery'])->name('fotografii');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/contacte',[HomeController::class,'contacte'])->name('contacte');


Route::get('/admin',function(){
     return redirect()->route('login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
