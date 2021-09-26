<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/line/test', [App\Http\Controllers\LineAuthController::class, 'test'])->name('line-test');
Route::get('/line/auth/callback', [App\Http\Controllers\LineAuthController::class, 'authCallback'])->name('line-auth-callback');
Route::get('/line/auth', [App\Http\Controllers\LineAuthController::class, 'auth'])->name('line-auth');
