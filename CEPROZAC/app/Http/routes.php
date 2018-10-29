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
//PROVEEDOR DE MATERIALES
Route::resource('provedores','ProvedorController');
Route::resource('materiales/provedores','ProvedorMaterialesController');

Route::get('verTipoProvedor/{id}','ProvedorMaterialesController@listadoTipoProvedor');


/*
Provedor Materiales
*/
Route::resource('asignarTipoProvedor', 'ProvedorTipoProvedorController');


Route::get('eliminarTipoProvedor/{id}', 'ProvedorTipoProvedorController@destroy');

//////////////////








Route::post("materiales/provedores/validar", "ProvedorMaterialesController@validar");
/////////////////////
Route::resource('productos','ProductosController');
Route::resource('bancos','BancoController');
Route::resource('serviciosBascula','ServicioBasculaController');
Route::resource('empresasCEPROZAC','EmpresasCeprozacController');

Route::resource('calidad','CalidadController');
Route::resource('basculas','BasculaController');
Route::resource('rol','RolEmpleadoController');
Route::resource('clientes','ClienteController');
Route::resource('empaques','FormaEmpaqueController');
Route::post("clientes/validarmiformulario", "ClienteController@validarMiFormulario");

Route::resource('cuentasEmpresasCEPROZAC','CuentasEmpresasCEPROZACController');

Route::resource('contratos','ContratosController');

Route::get('descargarPDF/{id}', 'ContratosController@pdf');



Route::get('descargar-provedores', 'ProvedorController@excel')->name('provedores.excel');
Route::get('descargar-contratos', 'ContratosController@excel')->name('contratos.excel');
Route::get('descargar-EmpresasCEPROZAC', 'EmpresasCeprozacController@excel')->name('empresasCEPROZAC.excel');
Route::get('ver-empresas/{id}', 'ProvedorController@verEmpresas')->name('provedores.verEmpresas');

Route::get('ver-cuentas/{id}', 'EmpresasCeprozacController@verCuentas')->name('empresasCEPROZAC.verCuentas');

Route::get('cuentasEmpresasCEPROZAC1/{id}','CuentasEmpresasCEPROZACController@create1')->name('empresasCEPROZAC1.create1');


Route::get('ver-InformacionEmpleado/{id}', 'EmpleadoController@verInformacion')->name('empleados.verInformacion');

Route::get('rolesEspecificos/{id}', 'ContratosController@rolesEspecificos');





Route::get('ultimo', 'ContratosController@ultimo');
/*
Rutas de transportes
*/
Route::get('crearMantenimientoEspecifico/{id}', 'MantenimientoTransporteController@crearMantenimientoEspecifico');


Route::get('ver-transportes/{id}', 'TransporteController@verTransportes')->name('transportes.verTransportes');
Route::get('descargarMantenimientos/{id}/{nombre}', 'TransporteController@descargarMantenimientos')->name('transportes.descargarMantenimientos');
Route::get('ver-transportes/{id}', 'TransporteController@verTransportes')->name('transportes.verTransportes');
Route::resource('mantenimiento','MantenimientoTransporteController');

Route::resource('transportes','TransporteController');
Route::get('descargarTractores/{id}', 'TractorController@excel')->name('tractores.excel');

Route::get('descargar-mantenimiento', 'MantenimientoTransporteController@excel')->name('mantenimiento.excel');



/////////////Rutas de Tractores

Route::resource('tractores','TractorController');

Route::resource('mantenimientoTractores','MantenimientoTractoresController');
Route::get('ver-mantenimientosTractores/{id}', 'TractorController@verMantenimientos')->name('tractores.verMantenimientos');



Route::get('descargar-mantenimiento-tractor', 'MantenimientoTractoresController@excel')->name('mantenimiento.excel');

Route::get('descargarMantenimientosTractores/{id}/{nombre}', 'TractorController@descargarMantenimientos')->name('transportes.descargarMantenimientosTractores');





/*Terminan  Las rutas de transportes*/



Route::get('ver-InformacionContrato/{id}', 'ContratosController@verInformacion')->name('contratos.verInformacion');




Route::get('descargarCuentas/{id}/{nombre}', 'CuentasEmpresasCEPROZACController@descargarCuentas')->name('empresasCEPROZAC.descargarCuentas');

Route::get('descargarEmpresas/{id}/{nombre}', 'ProvedorController@descargarEmpresas')->name('empresas.descargarEmpresas');




Route::get('descargar-clientes', 'ClienteController@excel')->name('clientes.excel');
Route::get('descargar-productos', 'ProductosController@excel')->name('productos.excel');

Route::get('descargar-empresas', 'EmpresaController@excel')->name('empresas.excel');

Route::get('descargar-rol', 'RolEmpleadoController@excel')->name('rol.excel');
Route::get('descargar-empleados', 'EmpleadoController@excel')->name('empleados.excel');
Route::get('descargar-bancos', 'BancoController@excel')->name('bancos.excel');
Route::get('descargar-servicioBasculas', 'ServicioBasculaController@excel')->name('serviciosBascula.excel');

Route::get('descargar-calidad', 'CalidadController@excel')->name('productos.calidad.excel');

Route::get('descargar-empaques', 'FormaEmpaqueController@excel')->name('empaques.excel');
Route::get('descargar-provedores-mat', 'ProvedorMaterialesController@excel')->name('provedores-mat.excel');

Route::get('descargar-PrecioBasculas', 'PrecioBasculaController@excel')->name('precioBasculas.excel');
Route::get('descargar-Basculas', 'BasculaController@excel')->name('basculas.excel');



Route::get('pruebas', 'ProductosController@pruebas')->name('productos.pruebas');	
Route::get('descargar-transportes', 'TransporteController@excel')->name('transportes.excel');

///ALMACENES


//ALMACEN GENERAL
Route::resource('almacen/general','AlmacenGeneralController');
Route::get('veralmacen/{id}', array('as'=> '/veralmacen','uses'=>'AlmacenGeneralController@verInformacion'));
Route::get('movimientos/{id}', array('as'=> '/movimientos','uses'=>'AlmacenGeneralController@movimientos'));
//entradas
Route::get('verentradas/{id}', array('as'=> '/verentradas','uses'=>'Entradas_AlmacenGeneralController@verEntradas'));
Route::resource('almacen/general/entradas','Entradas_AlmacenGeneralController');
//Route::resource('almacen/general/salidas','salidas_almacengeneral'); 
Route::get('descargar-almacen-general', 'AlmacenGeneralController@excel')->name('almacengeneral.excel');

////

///ALMACEN DE MATERIALES/REFACCIONES
Route::resource('almacen/materiales','AlmacenMaterialController');	
Route::resource('almacen/materiales/stock', 'AlmacenMaterialController@stock');
Route::resource('detalle/materiales', 'AlmacenMaterialController@detalle');
Route::resource('detalleEditar/materiales', 'AlmacenMaterialController@detalleEditar');
Route::resource('almacen/salidas/material','SalidaAlmacenMaterialController');	
Route::get('verDetallesArticuloAlmacenMaterial/{id}','AlmacenMaterialController@verDetallesArticuloMaterial');
Route::get('descargar-salidas', 'SalidaAlmacenMaterialController@excel')->name('almacen.materiales.salidas.excel');
Route::resource('almacen/entradas/materiales','EntradaAlmacenController');	
Route::get('descargar-entradas', 'EntradaAlmacenController@excel')->name('almacen.materiales.entradas.excel');
Route::get('pdfmaterial/{id}', array('as'=> '/pdfmaterial','uses'=>'AlmacenMaterialController@invoice'));
Route::get('descargar-materiales', 'AlmacenMaterialController@excel')->name('almacen.materiales.excel');
Route::resource('almacen/materiales/salidas','SalidaAlmacenMaterialController');


/////

/////ALMACEN DE AGROQUIMICOS
Route::resource('almacenes/agroquimicos','AlmacenAgroquimicosController');	
Route::resource('almacenes/agroquimicos/stock', 'AlmacenAgroquimicosController@stock');
Route::resource('detalle/agroquimicos', 'AlmacenAgroquimicosController@detalle');
Route::resource('detalleEditar/agroquimicos', 'AlmacenAgroquimicosController@detalleEditar');
Route::resource('almacen/salidas/agroquimicos','SalidasAgroquimicosController');	
Route::get('descargar-salidas-agro', 'SalidasAgroquimicosController@excel')->name('almacen.agroquimicos.salidas.excel');
Route::resource('almacen/entradas/agroquimicos','EntradasAgroquimicosController');	
Route::get('verEntradaAgroquimicos/{id}', array('as'=> '/verEntradaAgroquimicos','uses'=>'EntradasAgroquimicosController@verEntradaAgroquimicos'));
Route::get('descargar-entradas-agro', 'EntradasAgroquimicosController@excel')->name('almacen.agroquimicos.entradas.excel');
Route::get('pdfagroquimicos/{id}', array('as'=> '/pdfagroquimicos','uses'=>'AlmacenAgroquimicosController@invoice'));
Route::get('descargar-agroquímicos', 'AlmacenAgroquimicosController@excel')->name('almacen.agroquimicos.excel');
Route::get('verproducto/{id}', array('as'=> '/verproducto','uses'=>'AlmacenAgroquimicosController@verInformacion'));
Route::get('pdfentradaAgroquimicos/{id}', array('as'=> '/pdfentradaAgroquimicos','uses'=>'EntradasAgroquimicosController@pdfentradaAgroquimicos'));
Route::get('propiedadesUnidadMedidaJson/{id}', 'AlmacenAgroquimicosController@propiedadesUnidadMedidaJson');
Route::get('validarNumeroFactura/{numeroFactura}', 'EntradasAgroquimicosController@validarNumeroFactura');

Route::get('obtenerStockAgroquimicos/{id}', 'AlmacenAgroquimicosController@obtenerStock');
Route::get('obtenerPropiedadesAgroquimicos/{id}', 'AlmacenAgroquimicosController@obtenerPropiedadesProducto');

Route::get('propiedadesUnidadMedidaCantidadJson/{id}', 'AlmacenAgroquimicosController@propiedadesUnidadMedidaCantidadJson');





/////////ALMACEN DE LIMPIEZA
Route::resource('almacenes/limpieza','AlmacenLimpiezaController');	
Route::resource('almacenes/limpieza/stock', 'AlmacenLimpiezaController@stock');
Route::resource('detalle/limpieza', 'AlmacenLimpiezaController@detalle');
Route::resource('detalleEditar/limpieza', 'AlmacenLimpiezaController@detalleEditar');
Route::resource('almacen/salidas/limpieza','SalidasAlmacenLimpiezaController');	
Route::get('descargar-salidas-limpieza', 'SalidasAlmacenLimpiezaController@excel')->name('almacen.limpieza.salidas.excel');
Route::resource('almacen/entradas/limpieza','EntradasAlmacenLimpiezaController');	
Route::get('descargar-entradas-limpieza', 'EntradasAlmacenLimpiezaController@excel')->name('almacen.limpieza.entradas.excel');
Route::get('pdflimpieza/{id}', array('as'=> '/pdflimpieza','uses'=>'AlmacenLimpiezaController@invoice'));
Route::get('descargar-limpieza', 'AlmacenLimpiezaController@excel')->name('almacen.limpieza.excel');

////ALMACEN DE EMPAQUES
Route::resource('almacenes/empaque','AlmacenEmpaqueController');	
Route::resource('almacenes/empaque/stock', 'AlmacenEmpaqueController@stock');
Route::resource('detalle/empaque', 'AlmacenEmpaqueController@detalle');
Route::resource('detalleEditar/empaques', 'AlmacenEmpaqueController@detalleEditar');
Route::resource('almacen/salidas/empaque','SalidasEmpaquesController');	
Route::get('descargar-salidas-empaque', 'SalidasEmpaquesController@excel')->name('almacen.empaque.salidas.excel');
Route::resource('almacen/entradas/empaque','EntradasEmpaquesController');	
Route::get('descargar-entradas-empaque', 'EntradasEmpaquesController@excel')->name('almacen.empaque.entradas.excel');
Route::get('pdfempaque/{id}', array('as'=> '/pdflimpieza','uses'=>'AlmacenEmpaqueController@invoice'));
Route::get('descargar-empaquesalm', 'AlmacenEmpaqueController@excel')->name('almacen.empaque.excel');

/////////

///RECEPCION DE COMPRAS


Route::resource('compras/recepcion','RecepcionCompraController');
Route::get('vercompra/{id}', array('as'=> '/vercompra','uses'=>'RecepcionCompraController@verInformacion'));
Route::get('pdfrecepcion/{id}', array('as'=> '/pdfrecepcion','uses'=>'RecepcionCompraController@invoice'));
Route::get('descargar-compras', 'RecepcionCompraController@excel')->name('compras.recepcion.excel');
//////////////////////////////////

//////INVERNADEROS////
Route::resource('invernaderos','InvernaderosController');
Route::get('descargar-invernaderos', 'InvernaderosController@excel')->name('invernaderos.excel');



//////////

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

Route::get('validarProvedor/{nombre}/{apellidos}', 'ProvedorController@validarNombre');

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

Route::get('validarempaque/{codigo}', 'AlmacenEmpaqueController@validarcodigo');
Route::post('activarempaque', 'AlmacenEmpaqueController@activar');
///////////
//AQUI TERMINA VALIDACIONES


///FUMIGACIONES

Route::resource('fumigaciones','FumigacionesController');
Route::get('verfumigacion/{id}', array('as'=> '/verfumigacion','uses'=>'FumigacionesController@verInformacion'));
Route::get('pdffumigacion/{id}', array('as'=> '/pdffumigacion','uses'=>'FumigacionesController@invoice'));
Route::get('registrarfumigacion/{id}', array('as'=> '/registrarfumigacion','uses'=>'FumigacionesController@registrar'));
Route::get('descargar-compras', 'RecepcionCompraController@excel')->name('compras.recepcion.excel');



/////////////


/*
Tipo Proveedores
*/
//////////////////u

Route::resource('tipoProvedores', 'TipoProvedoresController');

Route::get('descargar_Tipo_Provedores', 'TipoProvedoresController@excel')->name('tipoProvedor.excel');

//UNIDADES DE MEDIDA

Route::get('listarUnidadesMedidaJson', 'UnidadesMedidaController@listarUnidadesMedida');
Route::resource('unidades_medida','UnidadesMedidaController');
Route::get('descargar-unidades', 'UnidadesMedidaController@excel')->name('unidades_medida.excel');
