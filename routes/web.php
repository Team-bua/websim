<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Artisan;
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
    //View user
    Route::get('/all-users',[AdminController::class,'getAllUsers'])->name('allusers');
    Route::get('/users/banned/{id}',[AdminController::class,'banned'])->name('users.banned');
    Route::get('/users/unbanned/{id}',[AdminController::class,'unbanned'])->name('users.unbanned');
    Route::post('/users/update/{id}',[AdminController::class,'updateMoney'])->name('users.update.money');

});

Route::group(['middleware' => 'login'], function () {
    Route::get('/profile/{id}',[UserController::class,'getProfile'])->name('profile');
    Route::post('/update-info/{id}',[UserController::class,'updateInfo'])->name('update.info');
    Route::post('/update-pass/{id}',[UserController::class,'changePass'])->name('update.pass');
});

//Login
Route::get('/',[FrontendController::class,'viewSignIn'])->name('signin');
Route::post('/sign-in',[FrontendController::class,'postSignIn'])->name('post.signin');
//Sign Up
Route::get('/sign-up',[FrontendController::class,'viewSignUp'])->name('signup');
Route::post('/sign-up',[FrontendController::class,'postSignup'])->name('post.signup');

//Logout
Route::get('/logout',[FrontendController::class,'postLogout'])->name('logout');

//Login Facebook
Route::get('/social-login/redirect/{provider}', [LoginController::class,'redirectToProvider'])->name('social.login');
Route::get('/social-login/{provider}/callback', [LoginController::class,'handleProviderCallback'])->name('social.callback');

Route::get('clear', function(){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return redirect()->back();
});