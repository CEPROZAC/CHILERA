<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;

use CEPROZAC\AlmacenAgroquimicos;
use CEPROZAC\Http\Requests\AlmacenAgroquimicosRequest;
use CEPROZAC\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;


class AlmacenAgroquimicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
              $material= DB::table('AlmacenAgroquimicos')->where('estado','Activo')->get();
      return view('almacen.agroquimicos.index', ['material' => $material]);

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('almacen.agroquimicos.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlmacenAgroquimicosRequest $formulario)
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
        $material= new AlmacenAgroquimicos;
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
       $material->estado='Activo';

       $material->save();
        $material= DB::table('AlmacenAgroquimicos')->orderby('created_at','DESC')->take(1)->get();
        return view('almacen.materiales.pdf', ['material' => $material]);

      }
  }        //
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
        return view("almacen.agroquimicos.edit",["material"=>AlmacenAgroquimicos::findOrFail($id)]);
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
         $material=AlmacenAgroquimicos::findOrFail($id);
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
      $material=AlmacenAgroquimicos::findOrFail($id);
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
        Excel::create('AlmacenAgroquimicos', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $material = AlmacenAgroquimicos::select('id','nombre','descripcion', 'cantidad', 'medida')
            ->where('estado', 'Activo')
            ->get();       
            $sheet->fromArray($material);
            $sheet->row(1,['ID','Nombre','Descripción' ,'Cantidad','Medida']);
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
      
       $material=AlmacenAgroquimicos::findOrFail($id);
       $agrega=$request->get('cantidades');
       $actual=$material->cantidad;
       $material->cantidad=$actual + $agrega;
       $material->update();
       return Redirect::to('almacenes/agroquimicos');
        //
   }
}
