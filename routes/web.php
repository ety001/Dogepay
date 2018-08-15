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

Route::get('/', 'DappController@index')->name('dapp_index');
Route::get('/dapp/create', 'DappController@create')->name('dapp_create');
Route::post('/dapp/store', 'DappController@store')->name('dapp_store');
Route::get('/dapp/destroy/{dapp}', 'DappController@destroy')->name('dapp_destroy');
Route::get('/dapp/edit/{dapp}', 'DappController@edit')->name('dapp_edit');
Route::post('/dapp/update/{dapp}', 'DappController@update')->name('dapp_update');

Route::get('/payment/{dapp}', 'GatewayController@index')->name('gateway');
Route::get('/payment/{order}/{tx}/{test?}', 'GatewayController@checktx')->name('checktx');
