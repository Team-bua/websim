<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LoginController;
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
Route::group(['middleware' => 'user'], function () {
    Route::get('/admin',[AdminController::class,'viewindex'])->name('admin');
});
//Login
Route::get('/',[FrontendController::class,'viewSignIn'])->name('signin');
Route::post('/sign-in',[FrontendController::class,'postSignIn'])->name('signin');
//Sign Up
Route::get('/sign-up',[FrontendController::class,'viewSignUp'])->name('signup');
Route::post('/sign-up',[FrontendController::class,'postSignup']);

//Logout
Route::get('/logout',[FrontendController::class,'postLogout'])->name('logout');

//Login Facebook
Route::get('/social-login/redirect/{provider}', [LoginController::class,'redirectToProvider'])->name('social.login');
Route::get('/social-login/{provider}/callback', [LoginController::class,'handleProviderCallback'])->name('social.callback');