<?php

namespace CEPROZAC\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\AlmacenMaterialRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\AlmacenMaterial;
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
        $material= DB::table('AlmacenMateriales')->where('estado','Activo')->get();
        return view('almacen.materiales.index', ['material' => $material]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('almacen.materiales.create'); 
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlmacenMaterialRequest $request)
    {

       $material= new AlmacenMaterial;
        $material->nombre=$request->get('nombre');
       
        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenmaterial',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
        }
       $material->descripcion=$request->get('descripcion');
       $material->cantidad=$request->get('cantidad');
        $material->codigo=$request->get('codigo');
       $material->estado='Activo';

       $material->save();



        $material= DB::table('AlmacenMateriales')->orderby('created_at','DESC')->take(1)->get();
        return view('almacen.materiales.pdf', ['material' => $material]);


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
         return view("almacen.materiales.edit",["material"=>AlmacenMaterial::findOrFail($id)]);
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
                $material = AlmacenMaterial::select('id','nombre', 'imagen', 'descripcion', 'cantidad', 'estado')
                ->where('estado', 'Activo')
                ->get();       
                $sheet->fromArray($material);
                $sheet->row(1,['ID','Nombre','Imagen','Descripción','Cantidad','Estado']);
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



}