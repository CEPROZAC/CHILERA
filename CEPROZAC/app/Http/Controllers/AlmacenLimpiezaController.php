<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;

use CEPROZAC\AlmacenLimpieza;
use CEPROZAC\Http\Requests\AlmacenLimpiezaRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradasAlmacenLimpieza;
use CEPROZAC\ProvedorMateriales;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class AlmacenLimpiezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $material = DB::table('AlmacenLimpieza')
      ->join('provedor_materiales as p', 'AlmacenLimpieza.provedor', '=', 'p.id')
      ->select('AlmacenLimpieza.*','p.nombre as provedor')
      ->where('AlmacenLimpieza.estado','Activo')->get();
      $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
      $empleado = DB::table('empleados')->where('estado','Activo')->get();
      $empresas=DB::table('empresas')->where('estado','=' ,'Activo')->get();
      return view('almacen.limpieza.index', ['material' => $material,'provedor' => $provedor, 'empleado' => $empleado,'empresas'=> $empresas]);

      
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
      return view('almacen.limpieza.create',['provedor' => $provedor]);
        //
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlmacenLimpiezaRequest $formulario)
    {
        $validator = Validator::make(
            $formulario->all(), 
            $formulario->rules(),
            $formulario->messages());
        if ($validator->valid()){

            if ($formulario->ajax()){
                return response()->json(["valid" => true], 200);
            }
            else{
                $material= new AlmacenLimpieza;
                $material->nombre=$formulario->get('nombre');
                
        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/AlmacenLimpieza',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
        }
        $material->descripcion=$formulario->get('descripcion');
        $material->cantidad=$formulario->get('cantidad');
        $material->medida=$formulario->get('medida');
        $material->codigo=$formulario->get('codigo');
        $material->provedor=$formulario->get('provedor_name');
          $material->stock_minimo=$formulario->get('stock_min');
        $material->estado='Activo';


        $material->save();
        $material= DB::table('AlmacenLimpieza')->orderby('created_at','DESC')->take(1)->get();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('almacen.limpieza.invoice', compact('date', 'invoice','material'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');

        $material->estado='Activo';

    }
  }        //
}

public function invoice($id){ 
    $material= DB::table('AlmacenLimpieza')->where('id',$id)->get();
         //$material   = AlmacenMaterial:: findOrFail($id);
    $date = date('Y-m-d');
    $invoice = "2222";
       // print_r($materiales);    
    $view =  \View::make('almacen.limpieza.invoice', compact('date', 'invoice','material'))->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
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
       $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
       return view("almacen.limpieza.edit",["material"=>AlmacenLimpieza::findOrFail($id)],['provedor' => $provedor]);
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
     $material=AlmacenLimpieza::findOrFail($id);
     $material->nombre=$request->get('nombre');
     
       if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/AlmacenLimpieza',$file->getClientOriginalName());//lo movemos a esta ruta
            $material->imagen=$file->getClientOriginalName();           
        }   
        $material->descripcion=$request->get('descripcion');
        $material->cantidad=$request->get('cantidad');
        $material->medida=$request->get('medida');
        $material->codigo=$request->get('codigo');
        $material->provedor=$request->get('provedor_name');
          $material->stock_minimo=$request->get('stock_min');
        $material->estado='Activo';
        $material->update();
        return Redirect::to('almacenes/limpieza');
        //
    }


    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('AlmacenLimpieza', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $material = AlmacenLimpieza::join('provedor_materiales','provedor_materiales.id', '=', 'AlmacenLimpieza.provedor')
            ->select('AlmacenLimpieza.id','AlmacenLimpieza.nombre','provedor_materiales.nombre as nom','AlmacenLimpieza.descripcion','AlmacenLimpieza.cantidad','AlmacenLimpieza.medida')
            ->where('AlmacenLimpieza.estado', 'Activo')
            ->get();          
            $sheet->fromArray($material);
            $sheet->row(1,['ID','Nombre','Proveedor','Descripción' ,'Cantidad','Medida']);
            $sheet->setOrientation('landscape');
            
            /*    
            $objDrawing = new PHPExcel_Worksheet_Drawing;
            $objDrawing->setPath(public_path('images\logoCeprozac.jpg')); //your image path
            $objDrawing->setCoordinates('E20');
            $objDrawing->setWorksheet($sheet);
            $objDrawing->setResizeProportional(true);
            $objDrawing->setWidthAndHeight(260,220);
            $objDrawing->setOffsetX(200);
*/
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
      $material=AlmacenLimpieza::findOrFail($id);
      $material->estado='Inactivo';
      $material->save();
      return Redirect::to('almacenes/limpieza');
        //
  }

  public function stock(Request $request, $id)
  {
    
      $ex = $request->get('provedor_id2');
      $materiales = DB::table('provedor_materiales')
      ->select('provedor_materiales.nombre')
      ->where('provedor_materiales.id',$ex)->get();
      $provedornombre = $materiales[0]->nombre;
      
      $material2= new EntradasAlmacenLimpieza;
      $material2->id_material=$id;
      $material2->cantidad=$request->get('cantidades');
      $material2->provedor=$provedornombre;
                            $material2->entregado=$formulario->get('entregado_a');
        $material2->recibe_alm=$formulario->get('recibe_alm');
         $material2->observacionesc=$formulario->get('observaciones');
      $material2->comprador=$request->get('recibio');
      $material2->factura=$request->get('factura');
      $material2->fecha=$request->get('fecha2');
      $material2->p_unitario=$request->get('preciou');
      $material2->total= $material2->p_unitario *  $material2->cantidad;
      $material2->importe= $material2->p_unitario *  $material2->cantidad;
      $material2->save();
      return Redirect::to('almacenes/limpieza');
      
      

  }
}
