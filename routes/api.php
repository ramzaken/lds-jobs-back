<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Job\JobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::post('/socialLogin', [AuthController::class, 'socialLogin']);

    Route::get('/google', [AuthController::class, 'redirectToGoogleLogin']);
    Route::get('/google/login/callback', [AuthController::class, 'handleGoogleLoginCallback']);
    Route::get('/google/register/employer', [AuthController::class, 'redirectToGoogleRegisterEmployer']);
    Route::get('/google/register', [AuthController::class, 'redirectToGoogleRegisterStaff']);
    Route::get('/google/register/employer/callback', [AuthController::class, 'handleGoogleRegisterEmployerCallback']);
    Route::get('/google/register/callback', [AuthController::class, 'handleGoogleRegisterStaffCallback']);
    Route::get('/disconnectGoogle', [AuthController::class, 'disconnectGoogle']);

    Route::get('/facebook', [AuthController::class, 'redirectToFacebook']);
    Route::get('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    Route::get('/disconnectFacebook', [AuthController::class, 'disconnectFacebook']);
});


Route::group(['namespace' => 'Job'], function() {
    Route::get('/jobs/fetch', [JobController::class, 'fetch']);  
});