<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\entradasalmacenlimpiezaRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\entradasalmacenlimpieza;
use CEPROZAC\Empleado;
use CEPROZAC\almacenlimpieza;
use CEPROZAC\ProvedorMateriales;
use CEPROZAC\empresas_ceprozac;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;
class entradasalmacenlimpiezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $entrada= DB::table('entradasalmacenlimpieza')
     ->join('almacenlimpieza as a', 'entradasalmacenlimpieza.id_material', '=', 'a.id')
     ->select('entradasalmacenlimpieza.*','a.nombre as nombremat','entradasalmacenlimpieza.*','a.medida')->get();
     return view('almacen.limpieza.entradas.index', ['entrada' => $entrada]);

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
         $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();
        $material=DB::table('almacenlimpieza')->where('estado','=' ,'Activo')->where('cantidad','>=','0')->get();

        $cuenta = count($material);
        

        if (empty($material)){
               $entrada= DB::table('entradasalmacenlimpieza')
     ->join('almacenlimpieza as a', 'entradasalmacenlimpieza.id_material', '=', 'a.id')
     ->select('entradasalmacenlimpieza.*','a.nombre as nombremat','entradasalmacenlimpieza.*','a.medida')->get();
     return view('almacen.limpieza.entradas.index', ['entrada' => $entrada]); 
         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {
              $entrada= DB::table('entradasalmacenlimpieza')
     ->join('almacenlimpieza as a', 'entradasalmacenlimpieza.id_material', '=', 'a.id')
     ->select('entradasalmacenlimpieza.*','a.nombre as nombremat','entradasalmacenlimpieza.*','a.medida')->get();
     return view('almacen.limpieza.entradas.index', ['entrada' => $entrada]);

      }else if (empty($provedor)){
              $entrada= DB::table('entradasalmacenlimpieza')
     ->join('almacenlimpieza as a', 'entradasalmacenlimpieza.id_material', '=', 'a.id')
     ->select('entradasalmacenlimpieza.*','a.nombre as nombremat','entradasalmacenlimpieza.*','a.medida')->get();
     return view('almacen.limpieza.entradas.index', ['entrada' => $entrada]);

      }
      else{
         return view("almacen.limpieza.entradas.create",["material"=>$material,"provedor"=>$provedor],["empleado"=>$empleado,"empresas"=>$empresas]);
     }
        //
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(entradasalmacenlimpiezaRequest $formulario)
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
              $material= new almacenlimpieza;

              $material->nombre=$formulario->get('nombre2');
              $material->provedor=$formulario->get('provedor_id2');
              

        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenlimpieza',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
        }
        $material->descripcion=$formulario->get('descripcion2');
        $material->cantidad="0";
        $material->medida=$formulario->get('medida');
        $material->codigo=$formulario->get('codigo');
        $material->estado='Activo';
        $material->save();
        
    }
}

$ultimo = almacenlimpieza::orderBy('id', 'desc')->first()->id;
$ex = $formulario->get('provedor_id2');
$materiales = DB::table('provedor_materiales')
->select('provedor_materiales.nombre')
->where('provedor_materiales.id',$ex)->get();

$provedornombre = $materiales[0]->nombre;
$material2= new entradasalmacenlimpieza;
$material2->id_material=$ultimo;
$material2->cantidad=$formulario->get('cantidad2');
$material2->provedor=$provedornombre;
$material2->comprador=$formulario->get('recibio2');
                $material2->entregado=$formulario->get('entregado_a');
        $material2->recibe_alm=$formulario->get('recibe_alm');
         $material2->observacionesc=$formulario->get('observacionesl');
$material2->factura=$formulario->get('factura2');
$material2->fecha=$formulario->get('fecha2');
$material2->p_unitario=$formulario->get('preciou2');
$material2->total= $material2->p_unitario *  $material2->cantidad;
$material2->importe= $material2->p_unitario *  $material2->cantidad;
$material2->save();

$material= DB::table('almacenlimpieza')->orderby('created_at','DESC')->take(1)->get();
$date = date('Y-m-d');
$invoice = "2222";
$view =  \View::make('almacen.limpieza.invoice', compact('date', 'invoice','material'))->render();
$pdf = \App::make('dompdf.wrapper');
$pdf->loadHTML($view);
return $pdf->stream('invoice');
           //return Redirect::to('almacen/entradas/agroquimicos');


           // print_r($cantidad);
}else{
    $num = 1;
    $y = 0;
    $limite = $formulario->get('total');
   //print_r($limite);

    while ($num <= $limite) {
        $material= new entradasalmacenlimpieza;
            //print_r($num);
        $producto = $formulario->get('codigo2');
        $first = head($producto);
        $name = explode(",",$first);
            print_r($producto);
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
         $material->iva=$first = $name[$y];
        $y = $y + 1;
        $material->total=$first = $name[$y];
        $material->importe=$first = $name[$y];
        $y = $y + 1;
        $material->moneda=$first = $name[$y];
        $y = $y + 1;
                $material->entregado=$formulario->get('entregado_a');
        $material->recibe_alm=$formulario->get('recibe_alm');
         $material->observacionesc=$formulario->get('observacionesl');
        $material->save();
        $num = $num + 1;
        //
    }
    return redirect('/almacen/entradas/limpieza');
}
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
       $material=entradasalmacenlimpieza::findOrFail($id);
       $material->delete();
       return Redirect::to('/almacen/entradas/limpieza');   
        //
   }

   public function excel()
   {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('entradasalmacenlimpieza', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $salidas = entradasalmacenlimpieza::join('almacenlimpieza','almacenlimpieza.id', '=', 'entradasalmacenlimpieza.id_material')->join('empleados','empleados.id', '=', 'entradasalmacenlimpieza.entregado')->join('empleados as emp_rec','empleados.id', '=', 'entradasalmacenlimpieza.recibe_alm')
            ->select('entradasalmacenlimpieza.id', 'almacenlimpieza.nombre', 'entradasalmacenlimpieza.cantidad', 'entradasalmacenlimpieza.provedor', 'entradasalmacenlimpieza.factura','entradasalmacenlimpieza.p_unitario','entradasalmacenlimpieza.iva','entradasalmacenlimpieza.total','entradasalmacenlimpieza.comprador','entradasalmacenlimpieza.fecha','empleados.nombre as empnom','emp_rec.nombre as rec_alma','entradasalmacenlimpieza.observacionesc')
            ->get();       
            $sheet->fromArray($salidas);
            $sheet->row(1,['N° de Entrada','Material','Cantidad' ,'Proveedor','Numero de Factura ó Nota','Precio Unitario','IVA','Subtotal','Comprador','Fecha de Compra',"Entregado a","Recibe en Almacén CEPROZAC",'Observaciónes de la Compra']);
            $sheet->setOrientation('landscape');
        });
      })->export('xls');
    }
}