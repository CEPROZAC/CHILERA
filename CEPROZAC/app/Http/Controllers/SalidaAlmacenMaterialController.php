<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\SalidasAlmacenMaterial;
use CEPROZAC\Empleado;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

/**
use CEPROZAC\AlmacenMaterial;

*/

class SalidaAlmacenMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $material= DB::table('almacenmateriales')->get();
         $salida= DB::table('SalidasAlmacenMaterial')->get();
        return view('almacen.materiales.salidas.index', ['salida' => $salida]);


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
        $material=DB::table('almacenmateriales')->where('estado','=' ,'Activo')->get();
        return view("almacen.materiales.salidas.create",["material"=>$material],["empleado"=>$empleado]); 
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
         $material= new SalidaAlmacenMaterial;
        $material->id_material=$request->get('id_material');
        $material->id_material=$request->get('cantidad');
        $material->destino=$request->get('destino');
        $material->entrego=$request->get('entrego');
        $material->recibio=$request->get('recibio');
        $material->tipo_movimiento=$request->get('tipo_movimiento');

        return view('almacen.materiales.salidas');

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

        //
    }
}
