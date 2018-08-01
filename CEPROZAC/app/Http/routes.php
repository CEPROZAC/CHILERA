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
Route::get('descargarPDF/{id}', 'ContratosController@pdf');



Route::get('descargar-provedores', 'ProvedorController@excel')->name('provedores.excel');
Route::get('descargar-contratos', 'ContratosController@excel')->name('contratos.excel');
Route::get('descargar-EmpresasCEPROZAC', 'EmpresasCeprozacController@excel')->name('empresasCEPROZAC.excel');
Route::get('ver-empresas/{id}', 'ProvedorController@verEmpresas')->name('provedores.verEmpresas');
Route::get('ver-transportes/{id}', 'TransporteController@verTransportes')->name('transportes.verTransportes');
Route::get('ver-cuentas/{id}', 'EmpresasCeprozacController@verCuentas')->name('empresasCEPROZAC.verCuentas');

Route::get('cuentasEmpresasCEPROZAC1/{id}','CuentasEmpresasCEPROZACController@create1')->name('empresasCEPROZAC1.create1');


Route::get('ver-InformacionEmpleado/{id}', 'EmpleadoController@verInformacion')->name('empleados.verInformacion');

Route::get('rolesEspecificos/{id}', 'ContratosController@rolesEspecificos');

Route::get('ultimo', 'ContratosController@ultimo');


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
Route::resource('detalle/materiales', 'AlmacenMaterialController@detalle');
Route::resource('almacenes/agroquimicos','AlmacenAgroquimicosController');	
Route::resource('almacenes/agroquimicos/stock', 'AlmacenAgroquimicosController@stock');
Route::resource('detalle/agroquimicos', 'AlmacenAgroquimicosController@detalle');
Route::resource('almacenes/limpieza','AlmacenLimpiezaController');	
Route::resource('almacenes/limpieza/stock', 'AlmacenLimpiezaController@stock');
Route::resource('detalle/limpieza', 'almacenlimpiezaController@detalle');
Route::resource('almacen/general','AlmacenGeneralController');
Route::get('veralmacen/{id}', array('as'=> '/veralmacen','uses'=>'AlmacenGeneralController@verInformacion'));
Route::resource('almacenes/empaque','almacenempaquecontroller');	
Route::resource('almacenes/empaque/stock', 'almacenempaquecontroller@stock');
Route::resource('detalle/empaque', 'almacenempaquecontroller@detalle');
Route::get('descargar-materiales', 'AlmacenMaterialController@excel')->name('almacen.materiales.excel');
Route::get('descargar-agroquímicos', 'AlmacenAgroquimicosController@excel')->name('almacen.agroquimicos.excel');
Route::get('descargar-empaquesalm', 'almacenempaquecontroller@excel')->name('almacen.empaque.excel');
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

Route::get('pdfmaterial/{id}', array('as'=> '/pdfmaterial','uses'=>'AlmacenMaterialController@invoice'));
Route::get('pdfagroquimicos/{id}', array('as'=> '/pdfagroquimicos','uses'=>'AlmacenAgroquimicosController@invoice'));
Route::get('pdflimpieza/{id}', array('as'=> '/pdflimpieza','uses'=>'AlmacenLimpiezaController@invoice'));
Route::get('pdfempaque/{id}', array('as'=> '/pdflimpieza','uses'=>'almacenempaquecontroller@invoice'));

Route::resource('almacen/salidas/agroquimicos','SalidasAgroquimicosController');	
Route::get('descargar-salidas-agro', 'SalidasAgroquimicosController@excel')->name('almacen.agroquimicos.salidas.excel');

Route::resource('almacen/entradas/agroquimicos','EntradasAgroquimicosController');	
Route::get('descargar-entradas-agro', 'EntradasAgroquimicosController@excel')->name('almacen.agroquimicos.entradas.excel');

Route::resource('almacen/salidas/limpieza','SalidasAlmacenLimpiezaController');	
Route::get('descargar-salidas-limpieza', 'SalidasAlmacenLimpiezaController@excel')->name('almacen.limpieza.salidas.excel');
Route::resource('almacen/entradas/limpieza','EntradasAlmacenLimpiezaController');	
Route::get('descargar-entradas-limpieza', 'EntradasAlmacenLimpiezaController@excel')->name('almacen.limpieza.entradas.excel');

Route::resource('almacen/salidas/empaque','salidasempaquescontroller');	

Route::get('descargar-salidas-empaque', 'salidasempaquescontroller@excel')->name('almacen.empaque.salidas.excel');
Route::resource('almacen/entradas/empaque','entradasempaquescontroller');	
Route::get('descargar-entradas-empaque', 'entradasempaquescontroller@excel')->name('almacen.empaque.entradas.excel');


Route::resource('compras/recepcion','RecepcionCompraController');
Route::get('vercompra/{id}', array('as'=> '/vercompra','uses'=>'RecepcionCompraController@verInformacion'));
Route::get('pdfrecepcion/{id}', array('as'=> '/pdfrecepcion','uses'=>'RecepcionCompraController@invoice'));
Route::get('descargar-compras', 'RecepcionCompraController@excel')->name('compras.recepcion.excel');


Route::get('descargarLiquidacion/{id}', 'ContratosController@liquidacion');



Route::get('eliminarRolEmpleado/{id}', 'EmpleadoRolesController@destroy');


Route::get('listaCuentasProvedores/{id}','EmpresaController@verCuentas');

Route::get('cuentas_Banco_Provedores/{id}','Cuentas_Banco_ProvedoresController@create1')->name('cuentas_Provedores.create1');



Route::resource('cuentasBancoProvedores','Cuentas_Banco_ProvedoresController');


Route::get('descargarCuentasProvedores/{id}/{nombre}', 'Cuentas_Banco_ProvedoresController@descargarCuentas')->name('provedoresCuentas.descargarCuentas');



Route::get('renovarContrato', 'ContratosController@renovarContrato');



Route::get('historialContratos/{id}', 'ContratosController@historial');


Route::post("renovarContrato", "ContratosController@renovarContrato");


Route::resource('almacenes','AlmacenController');



//VALIDACIONES DE DATOS UNICOS   CON AJAX 
//Validar Vehiculo numero de placa
Route::get('validarPlacas/{placas}', 'TransporteController@validarPlacas');
Route::post("activarVehiculo", "TransporteController@activar");
/////////////
//Validar numero de serie
Route::get('validarPlacas/{placas}', 'TransporteController@validarPlacas');






//Validacion de Provedores

Route::get('validarProvedor/{nombre}', 'ProvedorController@validarNombre');

Route::post("activarProvedor", "ProvedorController@activar");

///////////////////
//Validacion de empresas de proveedores
Route::get('validarEmpresa/{rfc}', 'EmpresaController@validarRFC');
Route::post("activarEmpresa", "EmpresaController@activar");
////////////////
//Validaccion de bancos
Route::get('validarBanco/{nombre}', 'BancoController@validarnombre');
Route::post("activarBanco", "BancoController@activar");
//////////////////////////
///Validar Empresa CEPROZAC
//
Route::get('validarEmpresasCEPROZAC/{rfc}', 'EmpresasCeprozacController@validarRFC');
Route::post("activarEmpresaCEPROZAC", "EmpresasCeprozacController@activar");
//////////////Termina validacion de Empresas CEPROZAC

/////////////////
//Comienza  validacion de cuentas bancarias de Empresas de Provedores
Route::get('validarNumCuenta_Cve_Interbancaria/{numCuenta_or_cveInterbancaria}', 'Cuentas_Banco_ProvedoresController@validarNumCuenta_Cve_Interbancaria');
Route::post("activarCuentaBancoProvedores", "Cuentas_Banco_ProvedoresController@activar");


//////////////////////////////
//Comienza validacion de cuentas bancarias de Empresas de CEPROZAC

Route::get('validarNumCuenta_Cve_InterbancariaCEPROZAC/{numCuenta_or_cveInterbancaria}', 'CuentasEmpresasCEPROZACController@validarNumCuenta_Cve_Interbancaria');
Route::post("activarCuentaBancoCEPROZAC", "CuentasEmpresasCEPROZACController@activar");




//////////////////////////
//Validacion curp Empleado
//////////////////////////////

Route::get('validarCURP/{curp}', 'EmpleadoController@validarCURP');
Route::post('activarEmpleado', 'EmpleadoController@activar');


///Validacion Clientes//
Route::get('validarcliente/{rfc}', 'ClienteController@validarRFC');
Route::post('activarcliente', 'ClienteController@activar');
////////////
//validacion provedor de materiales

Route::get('validarprovedormat/{rfc}', 'ProvedorMaterialesController@validarRFC');
Route::post('activarprovedormat', 'ProvedorMaterialesController@activar');
///////////

//validacion agroquimicos

Route::get('validaragroquimicos/{codigo}', 'AlmacenAgroquimicosController@validarcodigo');
Route::post('activaragroquimicos', 'AlmacenAgroquimicosController@activar');
///////////
//validacion materiales/refacciones

Route::get('validarmateriales/{codigo}', 'AlmacenMaterialController@validarcodigo');
Route::post('activarmateriales', 'AlmacenMaterialController@activar');
///////////
//validacion agroquimicos

Route::get('validarlimpieza/{codigo}', 'AlmacenLimpiezaController@validarcodigo');
Route::post('activarlimpieza', 'AlmacenLimpiezaController@activar');
///////////
//validacion agroquimicos

Route::get('validarempaque/{codigo}', 'almacenempaquecontroller@validarcodigo');
Route::post('activarempaque', 'almacenempaquecontroller@activar');
///////////
//AQUI TERMINA VALIDACIONES



