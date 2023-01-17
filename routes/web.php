<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;

// Middleware 

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

// Route::get('/', function () {
//     return view('welcome');
// });

// landing
Route::get('/', [LandingController::class, 'page_homeLanding'])->name('landing');

// auth
Route::group(['middleware' => ['guest']], function () {
    Route::get('/auth', [AuthenticationController::class, 'page_loginAuthentication'])->name('auth');
    Route::get('/auth/login', [AuthenticationController::class, 'page_loginAuthentication'])->name('auth.login');
    Route::post('/auth/login/act', [AuthenticationController::class, 'act_loginAuthentication'])->name('auth.login.act');
});

// auth
Route::group(['middleware' => ['auth','prevent-back-history']], function () {
    Route::get('/auth/logout', [AuthenticationController::class, 'logoutAuthentication'])->name('auth.logout');
});

// dashboard
Route::group(['middleware' => ['verified']], function () {
    Route::get('/dash', [DashboardController::class, 'page_admDashboard'])->name('dash');
});
