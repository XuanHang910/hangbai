<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DashboradController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Backend\UserGroupMemberController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\AuthenticationMiddleware; 
use App\Http\Middleware\LoginMiddleware;


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
// BACKEND ROUTES
Route::get('dashboard/index', [DashboradController::class, 'index'])->name('dashboard.index')
->middleware('admin');

/*user*/
Route::group(['prefix'=>'user'],function(){
    Route::get('index', [UserController::class, 'index'])->name('user.index')
    ->middleware('admin');
    Route::get('create', [UserController::class, 'create'])->name('user.create')
    ->middleware('admin');
    Route::post('store', [UserController::class, 'store'])->name('user.store')
    ->middleware('admin');
    Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id'=>'[0-9]+'])->name('user.edit')
    ->middleware('admin');
    Route::post('{id}/update', [UserController::class, 'update'])->where(['id'=>'[0-9]+'])->name('user.update')
    ->middleware('admin');
    Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id'=>'[0-9]+'])->name('user.delete')
    ->middleware('admin');
    Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id'=>'[0-9]+'])->name('user.destroy')
    ->middleware('admin');
 
});

Route::group(['prefix'=>'user/groupmembers'],function(){
    Route::get('index', [UserGroupMemberController::class, 'index'])->name('user.groupmembers.index')
    ->middleware('admin');
    Route::get('create', [UserGroupMemberController::class, 'create'])->name('user.groupmembers.create')
    ->middleware('admin');
    Route::post('store', [UserGroupMemberController::class, 'store'])->name('user.groupmembers.store')
    ->middleware('admin');
    Route::get('{id}/edit', [UserGroupMemberController::class, 'edit'])->where(['id'=>'[0-9]+'])->name('user.groupmembers.edit')
    ->middleware('admin');
    Route::post('{id}/update', [UserGroupMemberController::class, 'update'])->where(['id'=>'[0-9]+'])->name('user.groupmembers.update')
    ->middleware('admin');
    Route::get('{id}/delete', [UserGroupMemberController::class, 'delete'])->where(['id'=>'[0-9]+'])->name('user.groupmembers.delete')
    ->middleware('admin');
    Route::delete('{id}/destroy', [UserGroupMemberController::class, 'destroy'])->where(['id'=>'[0-9]+'])->name('user.groupmembers.destroy')
    ->middleware('admin');
 
});

 

//Ajax
Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])
    ->name('ajax.location.index')->middleware('admin');
    Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])
    ->name('ajax.dashboard.changeStatus')
    ->middleware('admin');

Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
