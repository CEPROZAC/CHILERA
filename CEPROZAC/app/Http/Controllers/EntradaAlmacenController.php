<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradaAlmacen;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenMaterial;
use CEPROZAC\ProvedorMateriales;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;

class EntradaAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $entrada= DB::table('entradaalmacenmateriales')
       ->join('almacenmateriales as a', 'EntradaAlmacenMateriales.id_material', '=', 'a.id')
       ->select('EntradaAlmacenMateriales.*','a.nombre as nombremat')->get();
        // print_r($salida);
       return view('almacen.materiales.entradas.index', ['entrada' => $entrada]);

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
         $provedor=DB::table('provedor_materiales')->where('estado','=' ,'Activo')->get();
        $material=DB::table('almacenmateriales')->where('estado','=' ,'Activo')->where('cantidad','>','0')->get();

        $cuenta = count($material);
        

        if (empty($material)){
          return view('almacen.materiales.create')->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo'); 
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {
                  return view('Recursos_Humanos.empleados.create')->with('message', 'No Hay Empleados Registrados, Favor de Dar de Alta Empleados Para Poder Acceder a Este Modulo'); 

      }else if (empty($provedor)){
                  return view('Provedores.materiales.create')->with('message', 'No Hay Proveedores de Materiales Registrados, Favor de Dar de Alta Algun Provedor Para Poder Acceder a Este Modulo'); 

      }
      else{
       return view("almacen.materiales.entradas.create",["material"=>$material,"provedor"=>$provedor],["empleado"=>$empleado]);
   }
        //return view("almacen.materiales.salidas.create",["material"=>$material],["empleado"=>$empleado]); 
        //
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
        $cantidad = $request->get('cantidad');
        if ($cantidad > 0){
            print_r($cantidad);
        }else{
        $num = 1;
        $y = 0;
        $limite = $request->get('total');
   //print_r($limite);

        while ($num <= $limite) {
            $material= new EntradaAlmacen;
            //print_r($num);
            $producto = $request->get('codigo2');
            $first = head($producto);
            $name = explode(",",$first);
            //print_r($producto);
            //$first = $name[0];
             //$first = $name[1];
            
            $material->id_material=$first = $name[$y];
            $y = $y + 2;
            $material->cantidad=$first = $name[$y];
            $y = $y + 1;
             print_r($first = $name[$y]);
            $material->provedor=$first = $name[$y];
            $y = $y + 1;
             print_r($first = $name[$y]);
            $material->comprador=$first = $name[$y];
            $y = $y + 1;
             print_r($first = $name[$y]);
            $material->nota_venta=$first = $name[$y];
            $y = $y + 1;
             //print_r($first = $name[$y]);
            $material->fecha=$first = $name[$y];
            $y = $y + 1;
            // print_r($first = $name[$y]);
            $material->p_unitario=$first = $name[$y];
            $y = $y + 1;
            $material->total=$first = $name[$y];
            $material->importe=$first = $name[$y];
            $y = $y + 1;
            $material->save();
            $num = $num + 1;

    }
    return redirect('/almacen/entradas/materiales');

         
        
     
        //
        }
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
}
