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
Route::resource('precioBasculas', 'PrecioBasculaController');
Route::resource('home','HomeController');
Route::resource('provedores','ProvedorController');
Route::resource('productos','ProductosController');
Route::resource('bancos','BancoController');
Route::resource('serviciosBascula','ServicioBasculaController');

Route::resource('calidad','CalidadController');
Route::resource('basculas','BasculaController');
Route::resource('rol','RolEmpleadoController');
Route::resource('clientes','ClienteController');
Route::resource('mantenimiento','MantenimientoTransporteController');
Route::post("clientes/validarmiformulario", "ClienteController@validarMiFormulario");

Route::resource('transportes','TransporteController');
Route::get('pdf', 'PdfController@invoice');
Route::get('descargar-provedores', 'ProvedorController@excel')->name('provedores.excel');
Route::get('ver-empresas/{id}', 'ProvedorController@verEmpresas')->name('provedores.verEmpresas');
Route::get('ver-transportes/{id}', 'TransporteController@verTransportes')->name('transportes.verTransportes');

Route::get('descargarMantenimientos/{id}/{nombre}', 'TransporteController@descargarMantenimientos')->name('transportes.descargarMantenimientos');


Route::get('descargar-clientes', 'ClienteController@excel')->name('clientes.excel');
Route::get('descargar-productos', 'ProductosController@excel')->name('productos.excel');

Route::get('descargar-empresas', 'EmpresaController@excel')->name('empresas.excel');

Route::get('descargar-rol', 'RolEmpleadoController@excel')->name('rol.excel');
Route::get('descargar-empleados', 'EmpleadoController@excel')->name('empleados.excel');

Route::resource('almacen/materiales','AlmacenMaterialController');	
Route::get('descargar-materiales', 'AlmacenMaterialController@excel')->name('almacen.materiales.excel');
Route::get('descargar-calidad', 'CalidadController@excel')->name('productos.calidad.excel');
Route::get('descargar-mantenimiento', 'MantenimientoTransporteController@excel')->name('mantenimiento.excel');

Route::resource('almacen/materiales/salidas','SalidaAlmacenMaterialController');


Route::get('pruebas', 'ProductosController@pruebas')->name('productos.pruebas');	

Route::resource('almacen/salidas/material','SalidaAlmacenMaterialController');	
Route::get('descargar-salidas', 'SalidaAlmacenMaterial@excel')->name('almacen.materiales.salidas.excel');

Route::get('descargar-transportes', 'TransporteController@excel')->name('transportes.excel');
