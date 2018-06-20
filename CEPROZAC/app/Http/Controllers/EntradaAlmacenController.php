<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\EntradasMaterialesRequest;
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
      ->join('almacenmateriales as a', 'entradaalmacenmateriales.id_material', '=', 'a.id')
      ->select('entradaalmacenmateriales.*','a.nombre as nombremat')->get();
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
      $empresas=DB::table('empresas')->where('estado','=' ,'Activo')->get();
      $material=DB::table('almacenmateriales')->where('estado','=' ,'Activo')->where('cantidad','>=','0')->get();

      $cuenta = count($material);
      

      if (empty($material)){
              $entrada= DB::table('entradaalmacenmateriales')
      ->join('almacenmateriales as a', 'EntradaAlmacenMateriales.id_material', '=', 'a.id')
      ->select('EntradaAlmacenMateriales.*','a.nombre as nombremat')->get();
        // print_r($salida);
      return view('almacen.materiales.entradas.index', ['entrada' => $entrada]);
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {
                $entrada= DB::table('entradaalmacenmateriales')
      ->join('almacenmateriales as a', 'EntradaAlmacenMateriales.id_material', '=', 'a.id')
      ->select('EntradaAlmacenMateriales.*','a.nombre as nombremat')->get();
      return view('almacen.materiales.entradas.index', ['entrada' => $entrada]); 

      }else if (empty($provedor)){
              $entrada= DB::table('entradaalmacenmateriales')
      ->join('almacenmateriales as a', 'EntradaAlmacenMateriales.id_material', '=', 'a.id')
      ->select('EntradaAlmacenMateriales.*','a.nombre as nombremat')->get();
        // print_r($salida);
      return view('almacen.materiales.entradas.index', ['entrada' => $entrada]);

      }
      else{
       return view("almacen.materiales.entradas.create",["material"=>$material,"provedor"=>$provedor],["empleado"=>$empleado,"empresas"=>$empresas]);
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

    
    public function store(EntradasMaterialesRequest $formulario)
    {
        $cantidad = $formulario->get('cantidad2');

        if ($cantidad > 0){
          $validator = Validator::make(
            $formulario->all(), 
            $formulario->rules(),
            $formulario->messages());
          if ($validator->valid()){

            if ($formulario->ajax()){
                return response()->json(["valid" => true], 200);
            }
            else{
              $material= new AlmacenMaterial;

              $material->nombre=$formulario->get('nombre2');
              $material->provedor=$formulario->get('provedor_id2');
              

        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenmaterial',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
        }
        $material->descripcion=$formulario->get('descripcion2');
        $material->cantidad="0";
        $material->codigo=$formulario->get('codigo');
        $material->estado='Activo';
        $material->save();
    }
}

$ultimo = AlmacenMaterial::orderBy('id', 'desc')->first()->id;
$ex = $formulario->get('provedor_id2');
$materiales = DB::table('provedor_materiales')
->select('provedor_materiales.nombre')
->where('provedor_materiales.id',$ex)->get();

$provedornombre = $materiales[0]->nombre;
$material2= new EntradaAlmacen;
$material2->id_material=$ultimo;
$material2->cantidad=$formulario->get('cantidad2');
$material2->provedor=$provedornombre;
$material2->comprador=$formulario->get('recibio2');
                $material2->entregado=$formulario->get('entregado_a');
        $material2->recibe_alm=$formulario->get('recibe_alm');
         $material2->observacionesc=$formulario->get('observaciones');

$material2->nota_venta=$formulario->get('nota2');
$material2->fecha=$formulario->get('fecha2');
$material2->p_unitario=$formulario->get('preciou2');
$material2->total= $material2->p_unitario *  $material2->cantidad;
$material2->importe= $material2->p_unitario *  $material2->cantidad;
$material2->save();
return Redirect::to('almacen/entradas/materiales');


           // print_r($cantidad);
}else{
    $num = 1;
    $y = 0;
    $limite = $formulario->get('total');
   //print_r($limite);

    while ($num <= $limite) {
        $material= new EntradaAlmacen;
            //print_r($num);
        $producto = $formulario->get('codigo2');
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
        $material->entregado=$formulario->get('entregado_a');
        $material->recibe_alm=$formulario->get('recibe_alm');
        $material->observacionesc=$formulario->get('observaciones');
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
       $material=entradaalmacen::findOrFail($id);
       $material->delete();
       return Redirect::to('/almacen/entradas/materiales');
        //
    }

    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('EntradaAlmacenMaterial', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $salidas = EntradaAlmacen::join('almacenmateriales','almacenmateriales.id', '=', 'EntradaAlmacenMateriales.id_material')
            ->select('EntradaAlmacenMateriales.id', 'almacenmateriales.nombre', 'EntradaAlmacenMateriales.cantidad', 'EntradaAlmacenMateriales.provedor', 'EntradaAlmacenMateriales.nota_venta','EntradaAlmacenMateriales.p_unitario','EntradaAlmacenMateriales.total','EntradaAlmacenMateriales.comprador','EntradaAlmacenMateriales.fecha')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Entrada','Material','Cantidad' ,'Proveedor','Nota de Venta','Precio Unitario','Subtotal','Comprador','Fecha de Compra']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }
}
