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
    
    Route::resource('qrcodes', 'QrcodeController')->except('show');

    Route::resource('users', 'UserController');
    Route::resource('accounts', 'AccountController');

    Route::resource('accountHistories', 'AccountHistoryController');
    
    Route::resource('transactions', 'TransactionController')->only(['index', 'show']);;
    // Only admin can view this
    Route::resource('roles', 'RoleController')->middleware('checkadmin');

    Route::post('accounts/apply_for_payout', 'AccountController@apply_for_payout')
        ->name('accounts.apply_for_payout')
        ->middleware('checkmoderator');
    Route::post('accounts/mark_as_paid', 'AccountController@mark_as_paid')
        ->name('accounts.mark_as_paid')
        ->middleware('checkmoderator');
    
});

Route::get('/qrcodes/{id}', 'QrcodeController@show')->name('qrcodes.show');

Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 

Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');