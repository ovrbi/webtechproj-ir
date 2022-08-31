<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SpeedrunController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SpeedrunController::class, 'index'])->name('home');
Route::get('/users/{id}', [SpeedrunController::class, 'index'])->name('userview');

Route::get('/dashboard', 
    [SpeedrunController::class, 'dashboard']
)->middleware(['auth', 'verified'])->name('dashboard');
Route::delete('/speedruns/delete/{id}', [SpeedrunController::class, 'destroy'])->middleware(['auth', 'verified'])->name('speedrun_delete');
Route::post('/speedruns/change', [SpeedrunController::class, 'update'])->middleware(['auth', 'verified'])->name('speedrun_update');
Route::put('/speedruns/confirm/{id}', [SpeedrunController::class, 'confirm'])->middleware(['auth', 'verified'])->name('speedrun_confirm');
Route::get('/speedruns/{id}', [SpeedrunController::class, 'show'])->name('speedruns');


require __DIR__.'/auth.php';
