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
    return redirect('login');
});

Route::get('/accesinterdit',function(){
  return view('accesinterdit');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('users/block/{id}', 'UserController@block')->name('users.block');
Route::get('users/block/{id}', 'UserController@block')->name('users.block');
Route::post('alertes/consulte/{id}', 'AlerteController@consulte')->name('alertes.consulte');
Route::get('alertes/consulte/{id}', 'AlerteController@consulte')->name('alertes.consulte');


Route::resource('users', 'UserController');
Route::resource('capteurs', 'CapteurController');
Route::resource('type_intervs', 'TypeIntervController');
Route::resource('interventions', 'InterventionController');
Route::resource('historiques', 'HistoriqueController');
Route::resource('factures', 'FactureController');
Route::resource('etablissements', 'EtablissementController');
Route::resource('alertes', 'AlerteController');
