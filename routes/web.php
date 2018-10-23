<?php

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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    
    Route::resource('qrcodes', 'QrcodeController');

    Route::resource('users', 'UserController');

    Route::resource('accountHistories', 'AccountHistoryController');
    
    Route::resource('transactions', 'TransactionController')->only(['index', 'show']);;
    // Only admin can view this
    Route::resource('accounts', 'AccountController')->middleware('checkadmin');
    
    Route::resource('roles', 'RoleController')->middleware('checkadmin');
    
});

