<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\EntradasAgroquimicosRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\entradasempaques;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenAgroquimicos;
use CEPROZAC\ProvedorMateriales;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;
class entradasempaquescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
             $entrada= DB::table('entradasempaques')
     ->join('almacenempaque as a', 'entradasempaques.id_material', '=', 'a.id')
     ->select('entradasempaques.*','a.nombre as nombremat','entradasempaques.*','a.medida')->get();
        // print_r($salida);
     return view('almacen.empaque.entradas.index', ['entrada' => $entrada]);

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
       $empresas=DB::table('empresas')->where('estado','=' ,'Activo')->get();
      $material=DB::table('almacenempaque')->where('estado','=' ,'Activo')->where('cantidad','>=','0')->get();

      $cuenta = count($material);
      

      if (empty($material)){
             $entrada= DB::table('entradasempaques')
     ->join('almacenempaque as a', 'entradasempaques.id_material', '=', 'a.id')
     ->select('entradasempaques.*','a.nombre as nombremat','entradasempaques.*','a.medida')->get();
        // print_r($salida);
     return view('almacen.empaque.entradas.index', ['entrada' => $entrada]);

         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {
             $entrada= DB::table('entradasempaques')
     ->join('almacenempaque as a', 'entradasempaques.id_material', '=', 'a.id')
     ->select('entradasempaques.*','a.nombre as nombremat','entradasempaques.*','a.medida')->get();
      return view('almacen.empaque.entradas.index', ['entrada' => $entrada]);
 

      }else if (empty($provedor)){
             $entrada= DB::table('entradasempaques')
     ->join('almacenempaque as a', 'entradasempaques.id_material', '=', 'a.id')
     ->select('entradasempaques.*','a.nombre as nombremat','entradasempaques.*','a.medida')->get();
 return view('almacen.empaque.entradas.index', ['entrada' => $entrada]);

      }
      else{
return view("almacen.empaque.entradas.create",["material"=>$material,"provedor"=>$provedor],["empleado"=>$empleado,"empresas"=>$empresas]);

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
        $material= new entradasempaques;
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
            // print_r($first = $name[$y]);
        $material->provedor=$first = $name[$y];
        $y = $y + 1;
            // print_r($first = $name[$y]);
        $material->comprador=$first = $name[$y];
        $y = $y + 1;
             //print_r($first = $name[$y]);
        $material->factura=$first = $name[$y];
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
                $material->entregado=$request->get('entregado_a');
        $material->recibe_alm=$request->get('recibe_alm');
         $material->observacionesc=$request->get('observaciones');
        $material->save();
        $num = $num + 1;
        //
    }
    return redirect('/almacen/entradas/empaque');
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
               $material=entradasempaques::findOrFail($id);
       $material->delete();
       return Redirect::to('/almacen/entradas/empaque');   
        //
    }

       public function excel()
   {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('entradasempaques', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $salidas = entradasempaques::join('almacenempaque','almacenempaque.id', '=', 'entradasempaques.id_material')
            ->select('entradasempaques.id', 'almacenempaque.nombre', 'entradasempaques.cantidad', 'entradasempaques.provedor', 'entradasempaques.factura','entradasempaques.p_unitario','entradasempaques.total','entradasempaques.comprador','entradasempaques.fecha')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Entrada','Material','Cantidad' ,'Proveedor','Numero de Factura','Precio Unitario','Subtotal','Comprador','Fecha de Compra']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $material=entradasempaques::findOrFail($id);
       $material->delete();
       return Redirect::to('/almacen/entradas/empaque');   
        //
    }
}
