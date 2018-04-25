<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\SalidasAgroquimicos;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenAgroquimicos;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;


class SalidasAgroquimicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salida= DB::table('salidasagroquimicos')
       ->join('almacenagroquimicos as s', 'salidasagroquimicos.id_material', '=', 's.id')
       ->select('salidasagroquimicos.*','s.nombre','salidasagroquimicos.*','s.medida')->get();
        // print_r($salida);
       return view('almacen.agroquimicos.salidas.index', ['salida' => $salida]);

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

        $material=DB::table('almacenagroquimicos')->where('estado','=' ,'Activo')->where('cantidad','>','0')->get();

        $cuenta = count($material);
        

        if (empty($material)){
          return view('almacen.materiales.create')->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo'); 
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {

      }else{
       return view("almacen.agroquimicos.salidas.create",["material"=>$material],["empleado"=>$empleado]);
   }
        //return view("almacen.materiales.salidas.create",["material"=>$material],["empleado"=>$empleado]); 
        //
}
        //

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
   //print_r($limite);

        while ($num <= $limite) {
            $material= new SalidasAgroquimicos;
            //print_r($num);
            $producto = $request->get('codigo2');
            $first = head($producto);
            $name = explode(",",$first);
            //$first = $name[0];
             //$first = $name[1];
            
            $material->id_material=$first = $name[$y];
            $y = $y + 2;
            $material->cantidad=$first = $name[$y];
            $y = $y + 1;
            // print_r($first = $name[$y]);
            $material->destino=$first = $name[$y];
            $y = $y + 1;
            // print_r($first = $name[$y]);
            $material->entrego=$first = $name[$y];
            $y = $y + 1;
             //print_r($first = $name[$y]);
            $material->recibio=$first = $name[$y];
            $y = $y + 1;
             //print_r($first = $name[$y]);
            $material->tipo_movimiento=$first = $name[$y];
            $y = $y + 1;
            // print_r($first = $name[$y]);
            $material->fecha=$first = $name[$y];
            $y = $y + 1;
            $material->save();
            $num = $num + 1;
            
        }
        return redirect('almacen/salidas/agroquimicos');
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

     public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('salidasagroquimicos', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $salidas = SalidasAgroquimicos::join('almacenagroquimicos','almacenagroquimicos.id', '=', 'salidasagroquimicos.id_material')
            ->select('salidasagroquimicos.id', 'almacenagroquimicos.nombre', 'salidasagroquimicos.cantidad', 'salidasagroquimicos.destino', 'salidasagroquimicos.entrego','salidasagroquimicos.recibio','salidasagroquimicos.tipo_movimiento','salidasagroquimicos.fecha')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Salida','Material','Cantidad' ,'Destino','Entrego','Recibio','Tipo de Movimiento','Fecha']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }
}
