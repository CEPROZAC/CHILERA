<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Provedor;
use CEPROZAC\Producto;
use CEPROZAC\calidad;
use CEPROZAC\Transporte;
use CEPROZAC\empresa;
use CEPROZAC\ServicioBascula;
use CEPROZAC\Empleado;
use CEPROZAC\bascula;
use CEPROZAC\AlmacenGeneral;
use CEPROZAC\AlmacenAgroquimicos;
use CEPROZAC\fumigaciones;
use CEPROZAC\salidasagroquimicos;
use CEPROZAC\recepcioncompra;
use CEPROZAC\formaempaque;


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

      $compra= DB::table('recepcioncompra')
      ->join( 'provedores as prov', 'recepcioncompra.id_provedor','=','prov.id')
      ->join( 'empresas as emp', 'recepcioncompra.recibe','=','emp.id')
      ->join( 'empleados as empleados', 'recepcioncompra.entregado','=','empleados.id')
      ->join('productos as prod' ,'recepcioncompra.id_producto','=','prod.id')
      ->join('calidad as cali' ,'recepcioncompra.id_calidad','=','cali.id')
      ->join('forma_empaques as forma' ,'recepcioncompra.id_empaque','=','forma.id')
      ->join('basculas as bas' ,'recepcioncompra.id_bascula','=','bas.id')
      ->join( 'empleados as emple', 'recepcioncompra.peso','=','emple.id')
      ->join( 'almacengeneral as alma', 'recepcioncompra.ubicacion_act','=','alma.id')
      ->join( 'fumigaciones as fum', 'recepcioncompra.id_fumigacion','=','fum.id')
      ->select('recepcioncompra.*','prov.nombre as nombreprov','emp.nombre as nomempresa','empleados.nombre as nomemple','prod.nombre as nomprod','cali.nombre as nomcali','forma.formaEmpaque as nomforma','bas.nombreBascula as nombas','emple.nombre as nomepleado','alma.nombre as nomalma','fum.id as idfumi')->get();


      return view('compras.recepcion.index', ['compra' => $compra]);

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
      $num = 1;
      $y = 0;
      $limite = $request->get('total');
      $agro = "";

      $fumigacion = new fumigaciones;
      $fumigacion->horai=$request->get('inicio');
      $fumigacion->fechai=$request->get('fechai');
      $fumigacion->fechaf=$request->get('fechaf');
      $fumigacion->horaf=$request->get('final');
      $fumigacion->destino=$request->get('codificacion');

      $fumigacion->id_fumigador=$request->get('fumigador');
      $fumigacion->cantidad_aplicada=$request->get('scantidad');
      $fumigacion->status=$request->get('status');
      $fumigacion->observaciones=$request->get('observacionesf');
      $fumigacion->estado="Activo";


      while ($num <= $limite) {
       $producto = $request->get('codigo2');;
       $first = head($producto);
       $name = explode(",",$first); 
       $salida = new salidasagroquimicos;
       $idagro = $first = $name[$y];
       $salida->id_material = $idagro;
       $y= $y+1;
       $agro = $agro." ".$first = $name[$y];
       $y= $y + 1;
       $descripcionagro= $name[$y];
       $y= $y + 1;
       $cantidadagro = $name[$y];
       $salida->cantidad = $cantidadagro;
        $salida->destino = "Materia Prima Embarque: ".$request->get('codificacion');
$salida->recibio = $request->get('nombre_fum');
$salida->entrego = $request->get('entrego_qui');
$salida->tipo_movimiento ="Fumigacion de Materia Prima";
$salida->fecha=$request->get('fechai');
$salida->save();
       $y= $y + 1;
       $num = $num + 1;
     }
     $fumigacion->agroquimicos=$agro;
     $fumigacion->save();

     $ultimo = fumigaciones::orderBy('id', 'desc')->first()->id;
     $material= new recepcioncompra;
     $material->nombre=$request->get('codificacion');
     $material->fecha_compra=$request->get('fecha');
     $material->id_provedor=$request->get('provedor');
     $arreglo = $request->get('transportes2');  
     $cadena_equipo = implode(",", $arreglo);
     $material->transporte=$cadena_equipo;
     $material->num_transportes=$request->get('transporte_num');
     $material->recibe=$request->get('empresa');
     $material->entregado=$request->get('recibe_em');
     $material->observacionesc=$request->get('observacionesc');
     $material->total_compra=$request->get('precio');
     $material->id_producto=$request->get('producto');
     $material->id_calidad=$request->get('calidad');          
     $material->id_empaque=$request->get('empaque');
     $material->humedad=$request->get('humedad');
     $material->pacas=$request->get('num_pacas');
     $material->pacas_rev=$request->get('pacas_rev');
     $material->observacionesm=$request->get('observacionesm');
     $material->id_bascula=$request->get('bascula');
     $material->ticket=$request->get('numeroticket');

     $material->peso=$request->get('pesaje');
     $material->kg_recibidos=$request->get('recibidos');
     $material->kg_enviados=$request->get('enviados');
     $material->diferencia=$request->get('diferencia');
     $material->observacionesb=$request->get('observacionesb');
     $almacenid = $request->get('almacen');
     $divide=explode("_", $almacenid);
     $material->ubicacion_act=$divide[0];                               
     $material->espacio_asignado=$request->get('asignado');
     $material->observacionesu=$request->get('observacionesu');
     $material->id_fumigacion=$ultimo;
     $material->save();






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
      $recibe= $compra->recibe;
       $entregado= $compra->entregado;
      $producto=$compra->id_producto;
      $calidad=$compra->id_calidad;
      $id_empaque=$compra->id_empaque;
      $id_bascula=$compra->id_bascula;
      $peso=$compra->peso;
      $ubicacion_act=$compra->ubicacion_act;
      $id_fumigacion=$compra->id_fumigacion;


      $provedor=Provedor::findOrFail($id_provedor);
      $emp_recibe=empresa::findOrFail($recibe);
      $entrega=empleado::findOrFail($entregado);
      $produ=producto::findOrFail($producto);
      $cali=calidad::findOrFail($calidad);
      $empaque=formaempaque::findOrFail($id_empaque);
      $bascula=bascula::findOrFail($id_bascula);
      $pesaje=empleado::findOrFail($peso);
      $ubicacion=almacengeneral::findOrFail($ubicacion_act);
      $fumigacion=fumigaciones::findOrFail($id_fumigacion);
      $id_fumigador=$fumigacion->id_fumigador;
      $fumigador=empleado::findOrFail($id_fumigador);

      return view("Compras.Recepcion.lista",["provedor"=>$provedor,"emp_recibe"=>$emp_recibe,"entrega"=>$entrega,"produ"=>$produ,"cali"=>$cali,"empaque"=>$empaque,"bascula"=>$bascula,"pesaje"=>$pesaje,"ubicacion"=>$ubicacion,"fumigacion"=>$fumigacion,"compra"=>$compra,"fumigador"=>$fumigador]);
    }
  }
