<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;

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

    Route::get('/auth/forgot', [AuthenticationController::class, 'page_forgotAuthentication'])->name('auth.forgot');
    Route::post('/auth/forgot/send_verif', [AuthenticationController::class, 'act_forgotAuthentication'])->name('auth.forgot.send_verif');

    Route::get('/auth/reset/{token}', [AuthenticationController::class, 'page_resetAuthentication'])->name('auth.reset');
    Route::post('/auth/reset/act', [AuthenticationController::class, 'act_resetAuthentication'])->name('auth.reset.act');    
});

Route::get('/auth/verify/{token}', [AuthenticationController::class, 'act_verifyAuthentication'])->name('auth.verify.act');

// auth
Route::group(['middleware' => ['auth','prevent-back-history']], function () {
    Route::get('/auth/logout', [AuthenticationController::class, 'logoutAuthentication'])->name('auth.logout');

    Route::get('/auth/verify', [AuthenticationController::class, 'page_verifyAuthentication'])->name('auth.verify');
    Route::get('/auth/verify/resend', [AuthenticationController::class, 'act_verifyresendAuthentication'])->name('auth.verify.resend');

    // dashboard
    Route::group(['middleware' => ['user_verified']], function () {
        Route::get('/dash', [DashboardController::class, 'page_admDashboard'])->name('home');
    });
});


