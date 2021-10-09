<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\ServicesController;
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
    Route::post('/admin',[AdminController::class,'viewindex'])->name('admin.search');
    //Bank
    Route::get('/bank-info',[AdminController::class,'getBankInfo'])->name('bankinfo');
    Route::post('/update-bank-info/{id}',[AdminController::class,'updateBankInfo'])->name('update.bankinfo');
    //View user
    Route::get('/all-users',[AdminController::class,'getAllUsers'])->name('allusers');
    Route::get('/users/banned/{id}',[AdminController::class,'banned'])->name('users.banned');
    Route::get('/users/unbanned/{id}',[AdminController::class,'unbanned'])->name('users.unbanned');
    Route::post('/users/update/{id}',[AdminController::class,'updateMoney'])->name('users.update.money');
    //order
    Route::get('/list-service',[ServicesController::class,'index'])->name('service');
    Route::get('/list-service/edit',[ServicesController::class,'edit'])->name('service.edit');
    Route::post('/list-service',[ServicesController::class,'store'])->name('service.store');
    Route::post('/list-service/update',[ServicesController::class,'update'])->name('service.update');
    Route::get('/list-service/destroy',[ServicesController::class,'destroy'])->name('service.list.destroy');
    //recharge bill
    Route::get('/recharge-bills',[BillController::class,'rechargeBill'])->name('rechargebill');
    Route::get('/recharge-bill-delete',[BillController::class,'deleteRechargeBill'])->name('rechargebill.destroy');
    //service bill
    Route::get('/service-bills',[BillController::class,'serviceBill'])->name('servicebill');
    Route::get('/service-bill-delete',[BillController::class,'deleteServiceBill'])->name('service.destroy');

});

Route::group(['middleware' => 'login'], function () {
    Route::get('/profile/{id}',[UserController::class,'getProfile'])->name('profile');
    Route::post('/update-info/{id}',[UserController::class,'updateInfo'])->name('update.info');
    Route::post('/update-pass/{id}',[UserController::class,'changePass'])->name('update.pass');
    //Service history
    Route::get('/services-history',[UserController::class,'getServiceHistory'])->name('servicehistory');
    //recharge
    Route::get('/recharge',[UserController::class,'recharge'])->name('recharge');
    Route::get('/recharge-history',[UserController::class,'getRechargeHistory'])->name('rechargehistory');
    //Document
    Route::get('/document',[AdminController::class,'documentAPI'])->name('document');
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

//Transaction
Route::post('handler-bank-transfer',[FrontendController::class,'transtionInfo'])->name('transtion.info');

Route::get('clear', function(){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return redirect()->back();
});
