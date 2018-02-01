<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});


Route::resource('empresas', 'EmpresaController');
Route::resource('home','HomeController');

	

Route::resource('provedores','ProvedorController');
Route::resource('productos','ProductosController');
Route::resource('clientes','ClienteController');	
Route::get('pdf', 'PdfController@invoice');
Route::get('descargar-provedores', 'ProvedorController@excel')->name('provedores.excel');

Route::get('descargar-clientes', 'ClienteController@excel')->name('clientes.excel');


Route::get('descargar-empresas', 'EmpresaController@excel')->name('empresas.excel');

