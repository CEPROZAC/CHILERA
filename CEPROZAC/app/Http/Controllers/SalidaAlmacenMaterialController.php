<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\SalidaAlmacenMaterial;
use CEPROZAC\Empleado;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;

/**
use CEPROZAC\AlmacenMaterial;

*/

class SalidaAlmacenMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    //    $material= DB::table('almacenmateriales')->get();
         $salida= DB::table('salidasalmacenmaterial')->get();
        return view('almacen.materiales.salidas.index', ['salida' => $salida]);


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
        $material=DB::table('almacenmateriales')->where('estado','=' ,'Activo')->get();
        return view("almacen.materiales.salidas.create",["material"=>$material],["empleado"=>$empleado]); 
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
        $u= "VALOR:";
           //$producto = $request->get('codigo');
         // $first = head($producto);
          //print_r($first);
           
$num = 1;
$n = 28;
$x = 1;
$y = 0;
          while ($num < $n) {
            $producto = $request->get('codigo');
          $first = head($producto);
             print_r($num);
            $name = explode(",",$first);
            //$first = $name[0];
             //$first = $name[1];
            $first = $name[$y];
            print_r($u);
            print_r($first);
            if (empty($first)){
                 $num = 28;
                 print_r($num);
                
           
            }else {
                 $producto = $request->get('codigo');
          $first = head($producto);
             //print_r($num);
            $name = explode(",",$first);

                print_r($first = $name[$y]);
             $y = $y + 1;
             print_r($first = $name[$y]);
             $y = $y + 1;
             print_r($first = $name[$y]);
             $y = $y + 1;
             print_r($first = $name[$y]);
             $y = $y + 1;
             print_r($first = $name[$y]);
             $y = $y + 1;
             print_r($first = $name[$y]);
             $y = $y + 1;
             $num = $num + 1;
             
             
                            
            }
             

          // code
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
