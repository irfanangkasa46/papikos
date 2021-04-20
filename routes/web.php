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


Auth::routes();

///// FRONTEND \\\\\
// Homepage
Route::get('/','Frontend\FrontendsController@homepage');

Route::get('/room/{slug}','Frontend\FrontendsController@showkamar'); //Show Kamar

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index');

  ////// PEMILIK \\\\\\
  Route::prefix('/pemilik')->middleware('role:Pemilik')->group(function () {
    Route::resource('kamar','Owner\KamarController'); //Data Kamar
    Route::get('profile','Owner\ProfileController@profile'); // Profile
    Route::put('payment-profile/{user_id}','Owner\ProfileController@payment_profile'); // Save Data Payment
    Route::post('testimoni','Owner\ProfileController@testimoni');

    Route::get('booking-list','Owner\BookListController@index')->name('booking-list'); // Booking List
    Route::get('room/{key}','Owner\BookListController@confirm_payment'); // Confirm payment from user
    Route::put('payment-confirm/{id}','Owner\BookListController@proses_confirm_payment'); // Proses Confirm Payment
    Route::get('reject-payment','Owner\BookListController@reject_confirm_payment'); // Reject Payment
    Route::get('penghuni','Owner\PenghuniController@penghuni'); // Penghuni
  });


  ///// USER \\\\\
  Route::prefix('/user')->middleware('role:Pencari')->group(function () {
    Route::post('/transaction-room/{id}','User\TransactionController@store')->name('sewa.store'); // Proses save Room
    Route::get('room/{key}','User\TransactionController@detail_payment'); // Detail payment
    Route::put('konfirmasi-payment/{id}','User\TransactionController@update'); // Konfirmasi Payment
    Route::get('tagihan','User\TransactionController@tagihan'); // Ambil data tagihan
    Route::get('myroom','User\MyRoomsController@myroom'); // Kamar aktif
  });

});

