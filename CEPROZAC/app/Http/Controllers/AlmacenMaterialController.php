<?php
namespace CEPROZAC\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\AlmacenMaterialRequest;
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

class AlmacenMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $material = DB::table('almacenmateriales')
        ->join('provedor_materiales as p', 'almacenmateriales.provedor', '=', 'p.id')
        ->select('almacenmateriales.*','p.nombre as nombre2')
        ->where('almacenmateriales.estado','Activo')->get();
        $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
        $empleado = DB::table('empleados')->where('estado','Activo')->get();
        return view('almacen.materiales.index', ['material' => $material,'provedor' => $provedor, 'empleado' => $empleado]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
       $empleado = DB::table('empleados')->where('estado','Activo')->get();
       return view('almacen.materiales.create', ['provedor' => $provedor, 'empleado' => $empleado]); 
        //
   }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlmacenMaterialRequest $formulario)
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
            $material= new AlmacenMaterial;
            $material->nombre=$formulario->get('nombre');
            $material->provedor=$formulario->get('provedor_id');
            
        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenmaterial',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
        }
        $material->descripcion=$formulario->get('descripcion');
        $material->cantidad=$formulario->get('cantidad');
        $material->codigo=$formulario->get('codigo');
        $material->estado='Activo';

        $material->save();
        $material= DB::table('AlmacenMateriales')->orderby('created_at','DESC')->take(1)->get();
        $datas= DB::table('cliente')->where('estado','Activo')->get();
        $date = date('Y-m-d');
        $x = "HOLA" ;
        $invoice = "2222";
        $view =  \View::make('almacen.materiales.invoice', compact('date', 'invoice','x','material'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');

       // return view('almacen.materiales.pdf', ['material' => $material]);

    }
  }        //
}

public function invoice($id){ 
    $material= DB::table('almacenmateriales')->where('id',$id)->get();
         //$material   = AlmacenMaterial:: findOrFail($id);
    $date = date('Y-m-d');
    $x = "HOLA" ;
    $invoice = "2222";
       // print_r($materiales);    
    $view =  \View::make('almacen.materiales.invoice', compact('date', 'invoice','x','material'))->render();
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
       return view("almacen.materiales.show",["material"=>AlmacenMaterial::findOrFail($id)]);
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
      return view("almacen.materiales.edit",["material"=>AlmacenMaterial::findOrFail($id)],["provedor"=> $provedor]);
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
      
     $material=AlmacenMaterial::findOrFail($id);
     $material->nombre=$request->get('nombre');
     
       if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenmateriales',$file->getClientOriginalName());//lo movemos a esta ruta
            $material->imagen=$file->getClientOriginalName();           
        }   
        $material->descripcion=$request->get('descripcion');
        $material->cantidad=$request->get('cantidad');
        $material->codigo=$request->get('codigo');
        $material->estado='Activo';
        $material->update();
        return Redirect::to('almacen/materiales');
        //
    }
        //
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $material=AlmacenMaterial::findOrFail($id);
       $material->estado='Inactivo';
       $material->save();
       return Redirect::to('almacen/materiales');
        //
   }
   public function excel()
   {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('almacenmateriales', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
               $material = AlmacenMaterial::join('provedor_materiales','provedor_materiales.id', '=', 'almacenmateriales.provedor')
               ->select('almacenmateriales.id','almacenmateriales.nombre','provedor_materiales.nombre as nom','almacenmateriales.descripcion','almacenmateriales.cantidad')
               ->where('almacenmateriales.estado', 'Activo')
               ->get();       
               $sheet->fromArray($material);
               $sheet->row(1,['ID','Material','Proveedor','Descripción','Stock En Almacén']);
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
      
       //$material->update();
       //return Redirect::to('almacen/materiales');
     $ex = $request->get('provedor_id2');
     $materiales = DB::table('provedor_materiales')
     ->select('provedor_materiales.nombre')
     ->where('provedor_materiales.id',$ex)->get();
     $provedornombre = $materiales[0]->nombre;
     
     $material2= new EntradaAlmacen;
     $material2->id_material=$id;
     $material2->cantidad=$request->get('cantidades');
     $material2->provedor=$provedornombre;
     $material2->comprador=$request->get('recibio');
     $material2->nota_venta=$request->get('nota');
     $material2->fecha=$request->get('fecha2');
     $material2->p_unitario=$request->get('preciou');
     $material2->total= $material2->p_unitario *  $material2->cantidad;
     $material2->importe= $material2->p_unitario *  $material2->cantidad;
     $material2->save();
     return Redirect::to('almacen/entradas/materiales');
        //
 }
}

