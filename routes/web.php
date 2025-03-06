<?php

use App\Http\Controllers\admin\CompetitionsController;
use Illuminate\Http\Request;
use App\Models\Competitions;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\AthletsController;
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


Route::resource('posts',PostsController::class)
->middleware('auth')
->names([
    'index' => 'posts'
]);

Route::resource('competitions',CompetitionsController::class)
->middleware('auth')
->names([
    'index' => 'competitions'
]);

Route::resource('athlets',AthletsController::class)
->middleware('auth')
->names([
    'index' => 'athlets'
]);

Route::get('/competitions-available', function (Request $request) {
    if ($request->category === 'SPORT') {
        $competitions = Competitions::whereNotIn('id', function ($query) {
            $query->select('id_competition')->from('posts')->whereNotNull('id_competition');
        })->get();
        return response()->json($competitions);
    }
    return response()->json([]); // Return empty if category is not SPORT
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
