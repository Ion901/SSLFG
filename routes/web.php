<?php

use App\Http\Controllers\admin\CompetitionsController;
use Illuminate\Http\Request;
use App\Models\Competitions;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\PremiantsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Models\Athlets;
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

Route::resource('premiants',PremiantsController::class)
->middleware('auth')
->names([
    'index' => 'premiants'
]);

Route::get('/competitions-available', function (Request $request) {
    if ($request->category === 'SPORT') {
        //toata competitiile disponibile care nu au fost incluse intr-o postare
        $competitions = Competitions::whereNotIn('id', function ($query) {
            $query->select('id_competition')->from('posts')->whereNotNull('id_competition');
        })->get();
        return response()->json($competitions);
    }
    return response()->json([]); // Return empty if category is not SPORT
});

Route::get('/athlets-available', function (Request $request){
    $idCompetition = Competitions::where('name',$request->competition)->value('id');
    // dd($request->competition);
    if($idCompetition)
    //afiseaza lista sportivillor care nu au luat loc la competitia selectata(venita din request);
    $athlets = Athlets::whereNotIn('id', function($query) use ($idCompetition){
        $query->select('id_athlet')->from('premiants')->whereNotNull('id_athlet')->where('id_competition',$idCompetition);
    })->get();
    return response()->json($athlets);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
