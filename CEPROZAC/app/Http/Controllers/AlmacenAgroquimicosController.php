<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;

use CEPROZAC\almacenagroquimicos;
use CEPROZAC\Http\Requests\almacenagroquimicosRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradasAgroquimicos;
use CEPROZAC\ProvedorMateriales;
use CEPROZAC\empresas_ceprozac;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;


class almacenagroquimicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $material = DB::table('almacenagroquimicos')
     ->join('provedor_materiales as p', 'almacenagroquimicos.provedor', '=', 'p.id')
     ->select('almacenagroquimicos.*','p.nombre as provedor')
     ->where('almacenagroquimicos.estado','Activo')->get();
     $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
     $empleado = DB::table('empleados')->where('estado','Activo')->get();
     $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();
     return view('almacen.agroquimicos.index', ['material' => $material,'provedor' => $provedor, 'empleado' => $empleado,"empresas"=>$empresas]);

 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
        return view('almacen.agroquimicos.create',['provedor' => $provedor]);

        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(almacenagroquimicosRequest $formulario)
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
            $material= new almacenagroquimicos;
            $material->nombre=$formulario->get('nombre');
            
        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenagroquimicos',$file->getClientOriginalName());//lo movemos a esta ruta                        
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
        $material= DB::table('almacenagroquimicos')->orderby('created_at','DESC')->take(1)->get();

         return Redirect::to('detalle/agroquimicos');

         /**
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('almacen.agroquimicos.invoice', compact('date', 'invoice','material'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');

        $material->estado='Activo';
        */

    }
  }        //
        //
}

public function invoice($id){ 
    $material= DB::table('almacenagroquimicos')->where('id',$id)->get();
         //$material   = AlmacenMaterial:: findOrFail($id);
    $date = date('Y-m-d');
    $invoice = "2222";
       // print_r($materiales);    
    $view =  \View::make('almacen.agroquimicos.invoice', compact('date', 'invoice','material'))->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
}

public function detalle(){ 
$material= DB::table('almacenagroquimicos')->orderby('created_at','DESC')->take(1)->get();
$provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();

return view('almacen.agroquimicos.detalle',["material"=>$material,"provedor"=>$provedor]);

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
       return view("almacen.agroquimicos.edit",["material"=>almacenagroquimicos::findOrFail($id)],['provedor' => $provedor]);
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
     $material=almacenagroquimicos::findOrFail($id);
     $material->nombre=$request->get('nombre');
     
       if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenagroquimicos',$file->getClientOriginalName());//lo movemos a esta ruta
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
        return Redirect::to('almacenes/agroquimicos');
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
      $material=almacenagroquimicos::findOrFail($id);
      $material->estado='Inactivo';
      $material->save();
      return Redirect::to('almacenes/agroquimicos');
        //
  }

  public function excel()
  {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('almacenagroquimicos', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $material = almacenagroquimicos::join('provedor_materiales','provedor_materiales.id', '=', 'almacenagroquimicos.provedor')
            ->select('almacenagroquimicos.id','almacenagroquimicos.nombre','provedor_materiales.nombre as nom','almacenagroquimicos.descripcion','almacenagroquimicos.cantidad','almacenagroquimicos.medida')
            ->where('almacenagroquimicos.estado', 'Activo')
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

    public function stock(Request $request, $id)
    {
        $material=almacenagroquimicos::findOrFail($id);
        $prov=$material->provedor;
        $prove=provedormateriales::findOrFail($prov);
        $nom_provedor=$prove->nombre;
      
      $material2= new entradasagroquimicos;
      $material2->id_material=$id;
      $material2->cantidad=$request->get('cantidades');
      $material2->provedor=$nom_provedor;
                      $material2->entregado=$request->get('entregado_a');
        $material2->recibe_alm=$request->get('recibe_alm');
         $material2->observacionesc=$request->get('observaciones');

      $material2->comprador=$request->get('recibio');
      $material2->factura=$request->get('factura');
      $material2->fecha=$request->get('fecha2');
      $material2->p_unitario=$request->get('preciou');
      $material2->total= $material2->p_unitario *  $material2->cantidad;
      $material2->importe= $material2->p_unitario *  $material2->cantidad;
      $material2->save();


      return Redirect::to('almacenes/agroquimicos');
  }
        //
}

