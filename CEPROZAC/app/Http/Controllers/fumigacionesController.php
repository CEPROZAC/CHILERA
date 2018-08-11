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
use CEPROZAC\fumigaciones;
use CEPROZAC\AlmacenGeneral;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use Carbon\Carbon;

use DB;
use Validator; 
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection as Collection;



class fumigacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
             $fumigaciones= DB::table('fumigaciones')
     ->join('empleados as a', 'fumigaciones.id_fumigador', '=', 'a.id')
        ->join('productos as p', 'fumigaciones.id_producto', '=', 'p.id')
         ->join('almacengeneral as alm', 'fumigaciones.id_almacen', '=', 'alm.id')
     ->select('fumigaciones.*','a.nombre as nomfum', 'a.apellidos as apellidos', 'p.nombre as produnom','alm.nombre as almnom')->get();
     return view('fumigaciones.index', ['fumigaciones' => $fumigaciones]);


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
      $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();
      $provedores=DB::table('provedores')->where('estado','=' ,'Activo')->get();
      $productos=DB::table('productos')->where('estado','=' ,'Activo')->get();
      $transportes=DB::table('transportes')->where('estado','=' ,'Activo')->get();
      $servicio=DB::table('basculas')->where('estado','=' ,'Activo')->get();
      $empaque=DB::table('forma_empaques')->where('estado','=' ,'Activo')->get();
      $calidad=DB::table('calidad')->where('estado','=' ,'Activo')->get();
      $almacengeneral=DB::table('almacengeneral')->where('estado','=' ,'Activo')->orwhere('total_libre','>','0')->get();
      $almacenagroquimicos=DB::table('almacenagroquimicos')->where('estado','=' ,'Activo')->orwhere('cantidad','>','0')->get();
      $espacio=DB::table('espacios_almacen')->where('nombre_lote','<>','')->join('almacengeneral as alm', 'espacios_almacen.id_almacen', '=', 'alm.id') ->select('espacios_almacen.*','alm.nombre as almnom')->get();

      if (empty($almacenagroquimicos) or empty($empleado) or empty($empresas) or empty($provedores) or empty($productos)  or empty($servicio)  or empty($empaque) ){
       return Redirect::to('fumigaciones');


     }

     return view("fumigaciones.create",["provedores"=>$provedores,"productos"=>$productos,"transportes"=>$transportes,"servicio"=>$servicio,"empleado"=>$empleado,"empaque"=>$empaque,"calidad"=>$calidad,"almacengeneral"=>$almacengeneral,"almacenagroquimicos"=>$almacenagroquimicos,"empresas"=>$empresas,'espacio'=>$espacio]);

        //
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



                   $fumigaciones = fumigaciones::findOrFail($id);
                   $idempleado= $fumigaciones->id_fumigador;
                   $idalm= $fumigaciones->id_almacen;
                   $idpro= $fumigaciones->id_producto;
                     $empleado=empleado::findOrFail($idempleado);
      $produ=producto::findOrFail($idpro);
       $ubicacion=almacengeneral::findOrFail($idalm);

     return view('fumigaciones.lista', ['fumigaciones' => $fumigaciones,'empleado' => $empleado,'produ'=> $produ,'ubicacion'=>$ubicacion]);
    }

       public function invoice($id){ 
    $material= DB::table('fumigaciones')->where('id',$id)->get();
     $fumigaciones = fumigaciones::findOrFail($id);
    $idemp=$fumigaciones->id_fumigador;
      $empleado= DB::table('empleados')->where('id',$idemp)->get();

    $date = date('Y-m-d');
    $invoice = "2222";   
    $view =  \View::make('Fumigaciones.invoice', compact('date', 'invoice','fumigaciones','empleado'))->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
  }




}
