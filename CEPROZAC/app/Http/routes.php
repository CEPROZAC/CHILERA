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
Route::resource('empleados', 'EmpleadoController');
Route::resource('home','HomeController');
Route::resource('provedores','ProvedorController');
Route::resource('productos','ProductosController');
Route::resource('rol','RolEmpleadoController');
Route::resource('clientes','ClienteController@create');
Route::post("clientes/validarmiformulario", "ClienteController@validarMiFormulario");

Route::resource('transportes','TransporteController');
Route::get('pdf', 'PdfController@invoice');
Route::get('descargar-provedores', 'ProvedorController@excel')->name('provedores.excel');

Route::get('descargar-clientes', 'ClienteController@excel')->name('clientes.excel');
Route::get('descargar-productos', 'ProductosController@excel')->name('productos.excel');

Route::get('descargar-empresas', 'EmpresaController@excel')->name('empresas.excel');

Route::get('descargar-rol', 'RolEmpleadoController@excel')->name('rol.excel');
Route::get('descargar-empleados', 'EmpleadoController@excel')->name('empleados.excel');

Route::resource('almacen/materiales','AlmacenMaterialController');	
Route::get('descargar-materiales', 'AlmacenMaterialController@excel')->name('almacen.materiales.excel');

Route::resource('almacen/salidas/material','SalidaAlmacenMaterialController');	
Route::get('descargar-salidas', 'SalidaAlmacenMaterial@excel')->name('almacen.materiales.salidas.excel');