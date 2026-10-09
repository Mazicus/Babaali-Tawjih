<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AccountController, GoogleController, RecoveryController};
foreach (['/','/index.html','/index.php'] as $path) Route::view($path,'home');
Route::redirect('/dashboard.php','/Dashboard.php');
Route::middleware('guest')->group(function () {
    Route::get('/login.php',fn(\Illuminate\Http\Request $request)=>app(AccountController::class)->form($request));
    Route::get('/inscription.php',fn(\Illuminate\Http\Request $request)=>app(AccountController::class)->form($request,'inscription'));
    Route::post('/login.php',[AccountController::class,'login'])->middleware('throttle:10,1');
    Route::post('/inscription.php',[AccountController::class,'register'])->middleware('throttle:5,1');
});
Route::get('/auth-status.php',[AccountController::class,'status']);
Route::get('/favorites.php',[AccountController::class,'favorites']);
Route::middleware('auth')->group(function () {
    Route::get('/Dashboard.php',[AccountController::class,'dashboard']);
    Route::post('/Dashboard.php',[AccountController::class,'favorites']);
    Route::post('/favorites.php',[AccountController::class,'favorites']);
    Route::post('/profile.php',[AccountController::class,'profile']);
    Route::get('/avatar.php',[AccountController::class,'avatar']);
    Route::post('/logout.php',[AccountController::class,'logout']);
    Route::get('/logout.php',fn()=>redirect('/Dashboard.php'));
});
Route::post('/contact.php',[AccountController::class,'contact'])->middleware('throttle:5,1');
Route::get('/google-oauth.php',[GoogleController::class,'start']);
Route::get('/google-callback.php',[GoogleController::class,'callback']);
Route::get('/forgot-password.php',[RecoveryController::class,'form']);
Route::post('/forgot-password.php',[RecoveryController::class,'send'])->middleware('throttle:5,1');
Route::get('/reset-password.php',[RecoveryController::class,'resetForm']);
Route::post('/reset-password.php',[RecoveryController::class,'reset'])->middleware('throttle:5,1');
