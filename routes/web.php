<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [PersonController::class, 'index']);
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');

Route::middleware(['auth'])->group(function () {
    Route::post('/people', [PersonController::class, 'store'])->name('people.store');
    Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');
    Route::get('/degree-between/{id1}/{id2}', [PersonController::class, 'getDegreeBetween'])->name('degree.between');
    Route::post('/show-degree-form', [PersonController::class, 'showDegreeForm'])->name('show.degree.form');
});
