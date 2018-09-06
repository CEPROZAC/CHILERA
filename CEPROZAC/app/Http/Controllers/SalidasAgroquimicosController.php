<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\salidasagroquimicos;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenAgroquimicos;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;


class salidasagroquimicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salida= DB::table('salidasagroquimicos')->where('salidasagroquimicos.estado','=','Activo')
        ->join('almacenagroquimicos as s', 'salidasagroquimicos.id_material', '=', 's.id')
        ->join('empleados as e', 'salidasagroquimicos.entrego', '=', 'e.id')
        ->join('empleados as emp', 'salidasagroquimicos.recibio', '=', 'emp.id')
        ->select('salidasagroquimicos.*','s.nombre','s.medida','e.nombre as emp1','e.apellidos as ap1','emp.nombre as emp2','emp.apellidos as ap2')->get();
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
           $salida= DB::table('salidasagroquimicos')
           ->join('almacenagroquimicos as s', 'salidasagroquimicos.id_material', '=', 's.id')
           ->select('salidasagroquimicos.*','s.nombre','salidasagroquimicos.*','s.medida')->get();
        // print_r($salida);
           return view('almacen.agroquimicos.salidas.index', ['salida' => $salida]); 
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
       }else if (empty($empleado)) {
         $salida= DB::table('salidasagroquimicos')
         ->join('almacenagroquimicos as s', 'salidasagroquimicos.id_material', '=', 's.id')
         ->select('salidasagroquimicos.*','s.nombre','salidasagroquimicos.*','s.medida')->get();
        // print_r($salida);
         return view('almacen.agroquimicos.salidas.index', ['salida' => $salida]);

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
        while ($num <= $limite) {
            $material= new salidasagroquimicos;
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
            $material->entrego=$request->get('entrego');
            $material->recibio=$request->get('recibio');
            $material->tipo_movimiento=$first = $name[$y];
            $y = $y + 1;
            // print_r($first = $name[$y]);
            $material->fecha=$first = $name[$y];
            $material->estado="Activo";
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
        $salida = salidasagroquimicos::findOrFail($id);
        $material = almacenagroquimicos::findOrFail($salida->id_material);
        $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
        $materiales=DB::table('almacenagroquimicos')->where('estado','=' ,'Activo')->where('cantidad','>','0')->get();
        return view("almacen.agroquimicos.salidas.edit",["salida"=>$salida,"empleado"=>$empleado,"material"=>$material,'materiales'=>$materiales]);

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

      $salida = salidasagroquimicos::findOrFail($id);
      $mat = almacenagroquimicos::findOrFail($salida->id_material);
      $mat->cantidad= $mat->cantidad + $salida->cantidad;
      $mat->update();

      $limite = $request->get('total');
      $num = 1;
      $y = 0;

      if ($limite == 1){
         $mat = almacenagroquimicos::findOrFail($salida->id_material);
       $producto = $request->get('codigo2');
       $first = head($producto);
       $name = explode(",",$first);
            //$first = $name[0];
             //$first = $name[1];

       $salida->id_material=$first = $name[$y];
       $y = $y + 2;
       $salida->cantidad=$first = $name[$y];
        $mat->cantidad= $mat->cantidad - $first = $name[$y];
       $y = $y + 1;
            // print_r($first = $name[$y]);
       $salida->destino=$first = $name[$y];
       $y = $y + 1;
            // print_r($first = $name[$y]);
       $salida->entrego=$request->get('entrego');
       $salida->recibio=$request->get('recibio');
       $salida->tipo_movimiento=$first = $name[$y];
       $y = $y + 1;
            // print_r($first = $name[$y]);
       $salida->fecha=$first = $name[$y];
       $salida->estado="Activo";
       $y = $y + 1;
    
       $mat->update();
       $salida->update();
       $num = 1;
       $y = 0;

   }

return redirect('almacen/salidas/agroquimicos');
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
       $material=salidasagroquimicos::findOrFail($id);
       $material->estado="Inactivo";
       $material->update();
       return Redirect::to('/almacen/salidas/agroquimicos');   

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
            $salidas = salidasagroquimicos::join('almacenagroquimicos','almacenagroquimicos.id', '=', 'salidasagroquimicos.id_material')
            ->join('empleados as e', 'salidasagroquimicos.entrego', '=', 'e.id')
            ->join('empleados as emp', 'salidasagroquimicos.recibio', '=', 'emp.id')
            ->select('salidasagroquimicos.id', 'almacenagroquimicos.nombre', 'salidasagroquimicos.cantidad','almacenagroquimicos.medida', 'salidasagroquimicos.destino', 'e.nombre as empnom','e.apellidos as ape1','emp.nombre as empmom2','emp.apellidos as ape2','salidasagroquimicos.tipo_movimiento','salidasagroquimicos.fecha')
            ->where('salidasagroquimicos.estado', 'Activo')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Salida','Material','Cantidad','Medida','Destino','Entrego','Apellidos','Recibio','Apellidos','Tipo de Movimiento','Fecha']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }
}
