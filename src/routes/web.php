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

Route::get('/test', function (){
    return 'It works';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'], function (){
    Route::get('billing', 'BillingController@index')->name('billing');
    Route::get('checkout/{plan_id}', 'CheckoutController@checkout')->name('checkout');
    Route::post('checkout', 'CheckoutController@processCheckout')->name('checkout.process');
    Route::get('cancel', 'BillingController@cancel')->name('billing.cancel');
    Route::get('resume', 'BillingController@resume')->name('billing.resume');

    Route::get('payment-method/default/{methodId}', 'PaymentMethodController@markAsDefault')->name('payment-method.markAsDefault');
    Route::resource('payment-method', 'PaymentMethodController');
});
