<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\salidasempaques;
use CEPROZAC\Empleado;
use CEPROZAC\almacenempaque;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;


class salidasempaquescontroller extends Controller
{
    /**

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                $salida= DB::table('salidasempaques')
        ->join('almacenempaque as s', 'salidasempaques.id_material', '=', 's.id')
        ->select('salidasempaques.*','s.nombre','salidasempaques.*','s.medida')
        ->where('salidasempaques.estado','=','Activo')->get();
        // print_r($salida);
        return view('almacen.empaque.salidas.index', ['salida' => $salida]);
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

        $material=DB::table('almacenempaque')->where('estado','=' ,'Activo')->where('cantidad','>','0')->get();

        $cuenta = count($material);
        

        if (empty($material)){
           $salida= DB::table('salidasempaques')
        ->join('almacenempaque as s', 'salidasempaques.id_material', '=', 's.id')
        ->select('salidasempaques.*','s.nombre','salidasempaques.*','s.medida')->get();
        // print_r($salida);
        return view('almacen.empaque.salidas.index', ['salida' => $salida]); 
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {
         $salida= DB::table('salidasempaques')
        ->join('almacenempaque as s', 'salidasempaques.id_material', '=', 's.id')
        ->select('salidasempaques.*','s.nombre','salidasempaques.*','s.medida')->get();
        // print_r($salida);
        return view('almacen.empaque.salidas.index', ['salida' => $salida]);

      }else{
         return view("almacen.empaque.salidas.create",["material"=>$material],["empleado"=>$empleado]);
     }
        //return view("almacen.materiales.salidas.create",["material"=>$material],["empleado"=>$empleado]); 
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
            $material= new salidasempaques;
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
            $material->estado="Activo";
            $y = $y + 1;
            $material->save();
            $num = $num + 1;
            
        }
        return redirect('almacen/salidas/empaque');
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
               $material=salidasempaques::findOrFail($id);
       $material->estado="Inactivo";
       return Redirect::to('/almacen/salidas/empaque');   

        //
    }

        public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('salidasempaques', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $salidas = salidasempaques::join('almacenempaque','almacenempaque.id', '=', 'salidasempaques.id_material')
            ->select('salidasempaques.id', 'almacenempaque.nombre', 'salidasempaques.cantidad', 'salidasempaques.destino', 'salidasempaques.entrego','salidasempaques.recibio','salidasempaques.tipo_movimiento','salidasempaques.fecha')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Salida','Material de Empaque','Cantidad' ,'Destino','Entrego','Recibio','Tipo de Movimiento','Fecha']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }
}
