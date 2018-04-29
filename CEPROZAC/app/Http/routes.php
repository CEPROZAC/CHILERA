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
Route::resource('empleadoRoles', 'EmpleadoRolesController');
Route::resource('precioBasculas', 'PrecioBasculaController');
Route::resource('home','HomeController');
Route::resource('provedores','ProvedorController');
Route::resource('materiales/provedores','ProvedorMaterialesController');
Route::post("materiales/provedores/validar", "ProvedorMaterialesController@validar");
Route::resource('productos','ProductosController');
Route::resource('bancos','BancoController');
Route::resource('serviciosBascula','ServicioBasculaController');
Route::resource('empresasCEPROZAC','EmpresasCeprozacController');

Route::resource('calidad','CalidadController');
Route::resource('basculas','BasculaController');
Route::resource('rol','RolEmpleadoController');
Route::resource('clientes','ClienteController');
Route::resource('mantenimiento','MantenimientoTransporteController');
Route::resource('empaques','FormaEmpaqueController');
Route::post("clientes/validarmiformulario", "ClienteController@validarMiFormulario");

Route::resource('transportes','TransporteController');
Route::resource('cuentasEmpresasCEPROZAC','CuentasEmpresasCEPROZACController');

Route::resource('contratos','ContratosController');
Route::get('pdf', 'PdfController@invoice');
Route::get('descargarPDF', 'BasculaController@pdf');
Route::get('descargar-provedores', 'ProvedorController@excel')->name('provedores.excel');
Route::get('descargar-contratos', 'ContratosController@excel')->name('contratos.excel');
Route::get('descargar-EmpresasCEPROZAC', 'EmpresasCeprozacController@excel')->name('empresasCEPROZAC.excel');
Route::get('ver-empresas/{id}', 'ProvedorController@verEmpresas')->name('provedores.verEmpresas');
Route::get('ver-transportes/{id}', 'TransporteController@verTransportes')->name('transportes.verTransportes');
Route::get('ver-cuentas/{id}', 'EmpresasCeprozacController@verCuentas')->name('empresasCEPROZAC.verCuentas');

Route::get('cuentasEmpresasCEPROZAC1/{id}','CuentasEmpresasCEPROZACController@create1')->name('empresasCEPROZAC1.create1');


Route::get('ver-InformacionEmpleado/{id}', 'EmpleadoController@verInformacion')->name('empleados.verInformacion');

Route::get('ver-InformacionContrato/{id}', 'ContratosController@verInformacion')->name('contratos.verInformacion');

Route::get('descargarMantenimientos/{id}/{nombre}', 'TransporteController@descargarMantenimientos')->name('transportes.descargarMantenimientos');


Route::get('descargarCuentas/{id}/{nombre}', 'CuentasEmpresasCEPROZACController@descargarCuentas')->name('empresasCEPROZAC.descargarCuentas');

Route::get('descargarEmpresas/{id}/{nombre}', 'ProvedorController@descargarEmpresas')->name('empresas.descargarEmpresas');



Route::get('descargar-clientes', 'ClienteController@excel')->name('clientes.excel');
Route::get('descargar-productos', 'ProductosController@excel')->name('productos.excel');

Route::get('descargar-empresas', 'EmpresaController@excel')->name('empresas.excel');

Route::get('descargar-rol', 'RolEmpleadoController@excel')->name('rol.excel');
Route::get('descargar-empleados', 'EmpleadoController@excel')->name('empleados.excel');
Route::get('descargar-bancos', 'BancoController@excel')->name('bancos.excel');
Route::get('descargar-servicioBasculas', 'ServicioBasculaController@excel')->name('serviciosBascula.excel');
Route::resource('almacen/materiales','AlmacenMaterialController');	
Route::resource('almacen/materiales/stock', 'AlmacenMaterialController@stock');
Route::resource('almacenes/agroquimicos','AlmacenAgroquimicosController');	
Route::resource('almacenes/agroquimicos/stock', 'AlmacenAgroquimicosController@stock');
Route::resource('almacenes/limpieza','AlmacenLimpiezaController');	
Route::resource('almacenes/limpieza/stock', 'AlmacenLimpiezaController@stock');
Route::get('descargar-materiales', 'AlmacenMaterialController@excel')->name('almacen.materiales.excel');
Route::get('descargar-agroquímicos', 'AlmacenAgroquimicosController@excel')->name('almacen.agroquimicos.excel');
Route::get('descargar-limpieza', 'AlmacenLimpiezaController@excel')->name('almacen.limpieza.excel');
Route::get('descargar-calidad', 'CalidadController@excel')->name('productos.calidad.excel');
Route::get('descargar-mantenimiento', 'MantenimientoTransporteController@excel')->name('mantenimiento.excel');
Route::get('descargar-empaques', 'FormaEmpaqueController@excel')->name('empaques.excel');
Route::get('descargar-provedores-mat', 'ProvedorMaterialesController@excel')->name('provedores-mat.excel');

Route::get('descargar-PrecioBasculas', 'PrecioBasculaController@excel')->name('precioBasculas.excel');
Route::get('descargar-Basculas', 'BasculaController@excel')->name('basculas.excel');

Route::resource('almacen/materiales/salidas','SalidaAlmacenMaterialController');


Route::get('pruebas', 'ProductosController@pruebas')->name('productos.pruebas');	

Route::resource('almacen/salidas/material','SalidaAlmacenMaterialController');	
Route::get('descargar-salidas', 'SalidaAlmacenMaterialController@excel')->name('almacen.materiales.salidas.excel');

Route::get('descargar-transportes', 'TransporteController@excel')->name('transportes.excel');

Route::resource('almacen/entradas/materiales','EntradaAlmacenController');	
Route::get('descargar-entradas', 'EntradaAlmacenController@excel')->name('almacen.materiales.entradas.excel');

//Route::get('pdfmaterial', 'AlmacenMaterialController@invoice')->name('almacen.materiales.salidas.invoice');
//Route::get('pdfmaterial/{$id}/invoice','AlmacenMaterialController@invoice');
Route::get('pdfmaterial/{id}', array('as'=> '/pdfmaterial','uses'=>'AlmacenMaterialController@invoice'));
Route::get('pdfagroquimicos/{id}', array('as'=> '/pdfagroquimicos','uses'=>'AlmacenAgroquimicosController@invoice'));
Route::get('pdflimpieza/{id}', array('as'=> '/pdflimpieza','uses'=>'AlmacenLimpiezaController@invoice'));

Route::resource('almacen/salidas/agroquimicos','SalidasAgroquimicosController');	
Route::get('descargar-salidas-agro', 'SalidasAgroquimicosController@excel')->name('almacen.agroquimicos.salidas.excel');

Route::resource('almacen/entradas/agroquimicos','EntradasAgroquimicosController');	
Route::get('descargar-entradas-agro', 'EntradasAgroquimicosController@excel')->name('almacen.agroquimicos.entradas.excel');

Route::resource('almacen/salidas/limpieza','SalidasAlmacenLimpiezaController');	
Route::get('descargar-salidas-limpieza', 'SalidasAlmacenLimpiezaController@excel')->name('almacen.limpieza.salidas.excel');

Route::resource('almacen/entradas/limpieza','EntradasAlmacenLimpiezaController');	
Route::get('descargar-entradas-limpieza', 'EntradasAlmacenLimpiezaController@excel')->name('almacen.limpieza.entradas.excel');



