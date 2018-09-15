<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\salidasalmacenlimpieza;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenAgroquimicos;
use CEPROZAC\almacenlimpieza;
use CEPROZAC\ubicaciones_limpieza;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;
class salidasalmacenlimpiezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                $salida= DB::table('salidasalmacenlimpieza')->where('salidasalmacenlimpieza.estado','=','Activo')
        ->join('almacenlimpieza as s', 'salidasalmacenlimpieza.id_material', '=', 's.id')
        ->join('empleados as e', 'salidasalmacenlimpieza.entrego', '=', 'e.id')
        ->join('empleados as emp', 'salidasalmacenlimpieza.recibio', '=', 'emp.id')
        ->select('salidasalmacenlimpieza.*','s.nombre','salidasalmacenlimpieza.*','s.medida','e.nombre as emp1','e.apellidos as ap1','emp.nombre as emp2','emp.apellidos as ap2')->get();
        // print_r($salida);
        return view('almacen.limpieza.salidas.index', ['salida' => $salida]);
        // 

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

        $material=DB::table('almacenlimpieza')->where('estado','=' ,'Activo')->where('cantidad','>','0')->get();
         $limpieza=DB::table('ubicaciones_limpieza')->where('estado','=' ,'Activo')->get();

        $cuenta = count($material);
        

        if (empty($material)){
            $salida= DB::table('salidasalmacenlimpieza')
            ->join('almacenlimpieza as s', 'salidasalmacenlimpieza.id_material', '=', 's.id')
            ->select('salidasalmacenlimpieza.*','s.nombre','salidasalmacenlimpieza.*','s.medida')->get();
            return view('almacen.limpieza.salidas.index', ['salida' => $salida])->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo'); 
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
        }else if (empty($empleado)) {
            $salida= DB::table('salidasalmacenlimpieza')
            ->join('almacenlimpieza as s', 'salidasalmacenlimpieza.id_material', '=', 's.id')
            ->select('salidasalmacenlimpieza.*','s.nombre','salidasalmacenlimpieza.*','s.medida')->get();
            return view('almacen.limpieza.salidas.index', ['salida' => $salida])->with('message', 'No Hay Empleados Registrados, Favor de Dar de Alta Empleados Para Poder Acceder a Este Modulo'); 

        }else{
           return view("almacen.limpieza.salidas.create",["material"=>$material],["empleado"=>$empleado,"limpieza"=>$limpieza]);
       }

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
       $num = 1;
       $y = 0;
       $limite = $request->get('total');
   //print_r($limite);

       while ($num <= $limite) {
        $material= new salidasalmacenlimpieza;
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
             //print_r($first = $name[$y]);
        $material->tipo_movimiento=$first = $name[$y];
        $y = $y + 1;
            // print_r($first = $name[$y]);
        $material->fecha=$first = $name[$y];
        $y = $y + 1;
        $material->entrego=$request->get('entrego');
        $material->recibio=$request->get('recibio');
        $material->estado="Activo";
        $material->save();
        $num = $num + 1;
        
    }
    return redirect('almacen/salidas/limpieza');
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
                        $salida = salidasalmacenlimpieza::findOrFail($id);
        $material = almacenlimpieza::findOrFail($salida->id_material);
        $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
             $limpieza=DB::table('ubicaciones_limpieza')->where('estado','=' ,'Activo')->get();
        $materiales=DB::table('almacenlimpieza')->where('estado','=' ,'Activo')->where('cantidad','>','0')->get();
        return view("almacen.limpieza.salidas.edit",["salida"=>$salida,"empleado"=>$empleado,"material"=>$material,'materiales'=>$materiales,'limpieza'=>$limpieza]);
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

      $salida = salidasalmacenlimpieza::findOrFail($id);
      $mat = almacenlimpieza::findOrFail($salida->id_material);
      $mat->cantidad= $mat->cantidad + $salida->cantidad;
      $mat->update();

      $limite = $request->get('total');
      $num = 1;
      $y = 0;

      if ($limite == 1){
         $mat = almacenlimpieza::findOrFail($salida->id_material);
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
           return redirect('almacen/salidas/limpieza');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $material=salidasalmacenlimpieza::findOrFail($id);
     $material->estado="Inactivo";
      $mat = almacenlimpieza::findOrFail($material->id_material);
      $mat->cantidad= $mat->cantidad + $material->cantidad;
      $mat->update();
     $material->update();
     return Redirect::to('/almacen/salidas/limpieza');
        //
 }


   public function excel()
   {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('salidasalmacenlimpieza', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $salidas = salidasalmacenlimpieza::where('salidasalmacenlimpieza.estado','=','Activo')->join('almacenlimpieza','almacenlimpieza.id', '=', 'salidasalmacenlimpieza.id_material')
            ->join('empleados as e', 'salidasalmacenlimpieza.entrego', '=', 'e.id')
            ->join('empleados as emp', 'salidasalmacenlimpieza.recibio', '=', 'emp.id')
            ->select('salidasalmacenlimpieza.id', 'almacenlimpieza.nombre', 'salidasalmacenlimpieza.cantidad','almacenlimpieza.medida', 'salidasalmacenlimpieza.destino', 'e.nombre as empnom','e.apellidos as ape1','emp.nombre as empmom2','emp.apellidos as ape2','salidasalmacenlimpieza.tipo_movimiento','salidasalmacenlimpieza.fecha')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Salida','Material','Cantidad','Medida','Destino','Entrego','Apellidos','Recibio','Apellidos','Tipo de Movimiento','Fecha']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }
}

