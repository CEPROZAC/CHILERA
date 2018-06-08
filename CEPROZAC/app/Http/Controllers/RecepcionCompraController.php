<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Provedor;
use CEPROZAC\Producto;
use CEPROZAC\Transporte;
use CEPROZAC\ServicioBascula;
use CEPROZAC\RecepcionCompra;
use CEPROZAC\Empleado;
use CEPROZAC\Bascula;
use CEPROZAC\AlmacenGeneral;
use CEPROZAC\AlmacenAgroquimicos;

use DB;
use Maatwebsite\Excel\Facades\Excel;

class RecepcionCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

              $compra= DB::table('RecepcionCompra')
      ->join( 'provedores as prov', 'RecepcionCompra.id_provedor','=','prov.id')
      ->join('productos as prod' ,'RecepcionCompra.id_producto','=','prod.id')
      ->join('transportes as tran' ,'RecepcionCompra.id_transporte','=','tran.id')
      ->join('servicio_basculas as ser' ,'RecepcionCompra.id_ticket','=','ser.id')
      ->select('RecepcionCompra.id as idcompra' ,'RecepcionCompra.fecha','RecepcionCompra.kg_recibidos',
        'RecepcionCompra.kg_enviados','RecepcionCompra.diferencia','RecepcionCompra.precio','RecepcionCompra.observaciones','RecepcionCompra.recibio','prov.nombre as provedornombre','prod.nombre as productonombre','tran.nombre_Unidad as transporte_nombre','ser.numeroTicket as num_ticket')
      ->where('prov.estado','=','Activo')
      ->where('tran.estado','=','Activo')
      ->where('ser.estado','=','Activo')
      ->where('RecepcionCompra.estado','Activa')
      ->where('prod.estado','Activo')->get();


      return view('Compras.Recepcion.index', ['compra' => $compra]);

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
      $empresas=DB::table('empresas')->where('estado','=' ,'Activo')->get();
      $provedores=DB::table('provedores')->where('estado','=' ,'Activo')->get();
      $productos=DB::table('productos')->where('estado','=' ,'Activo')->get();
      $transportes=DB::table('transportes')->where('estado','=' ,'Activo')->get();
      $servicio=DB::table('basculas')->where('estado','=' ,'Activo')->get();
      $empaque=DB::table('forma_empaques')->where('estado','=' ,'Activo')->get();
      $calidad=DB::table('calidad')->where('estado','=' ,'Activo')->get();
      $almacengeneral=DB::table('almacengeneral')->where('estado','=' ,'Activo')->orwhere('total_libre','>','0')->get();
      $almacenagroquimicos=DB::table('almacenagroquimicos')->where('estado','=' ,'Activo')->orwhere('cantidad','>','0')->get();
      return view("compras.recepcion.create",["provedores"=>$provedores,"productos"=>$productos,"transportes"=>$transportes,"servicio"=>$servicio,"empleado"=>$empleado,"empaque"=>$empaque,"calidad"=>$calidad,"almacengeneral"=>$almacengeneral,"almacenagroquimicos"=>$almacenagroquimicos,"empresas"=>$empresas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

        public function verInformacion($id)
    {

      $compra = RecepcionCompra::findOrFail($id);
      $id_provedor= $compra->id_provedor;
      $id_productos=$compra->id_producto;
      $transportes=$compra->id_transporte;
      $ticket=$compra->id_ticket;

      $provedor=Provedor::findOrFail($id_provedor);
      $producto=Producto::findOrFail($id_productos);
       $transporte=Transporte::findOrFail($transportes);
       $tickets=ServicioBascula::findOrFail($ticket);

      return view("Compras.Recepcion.lista",["provedor"=>$provedor,"producto"=>$producto,"transporte"=>$transporte,"tickets"=>$tickets,"compra"=>$compra]);
    }
}
