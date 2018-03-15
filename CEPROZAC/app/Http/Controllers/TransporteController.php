<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Empleado;
use CEPROZAC\Transporte;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class TransporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos= DB::table('transportes')
        ->join( 'empleados as e', 'transportes.chofer_id','=','e.id')
        ->select('transportes.*','e.nombre','e.apellidos')
        ->where('transportes.estado','Activo')->get();
        return view('Transportes.transportes.index',['vehiculos'=>$vehiculos]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

     $empleados=DB::table('empleados')->where('estado','=','Activo')->get();
     return view('Transportes.transportes.create',['empleados'=>$empleados]);
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $transporte = new Transporte;
        $transporte->nombre_Unidad=$request->get('nombre_Unidad');
        $transporte->no_Serie=$request->get('no_Serie');
        $transporte->placas=$request->get('placas');
        $transporte->poliza_Seguro=$request->get('poliza_Seguro');
        $transporte->vigencia_Seguro=$request->get('vigencia_Seguro');
        $transporte->aseguradora=$request->get('aseguradora');
        $transporte->m3_Unidad=$request->get('m3_Unidad');
        $transporte->capacidad=$request->get('capacidad');
        $transporte->chofer_id=$request->get('chofer_id');
        $transporte->estado='Activo';
        $transporte->save();
        return Redirect::to('transportes');

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
        $vehiculo=Transporte::findOrFail($id);
        $empleados=DB::table('empleados')->where('estado','=','Activo')->get();
        return view('Transportes.transportes.edit',['vehiculo'=>$vehiculo,"empleados"=>$empleados]);

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
        $transporte=Transporte::findOrFail($id);
        $transporte->nombre_Unidad=$request->get('nombre_Unidad');
        $transporte->no_Serie=$request->get('no_Serie');
        $transporte->placas=$request->get('placas');
        $transporte->poliza_Seguro=$request->get('poliza_Seguro');
        $transporte->vigencia_Seguro=$request->get('vigencia_Seguro');
        $transporte->aseguradora=$request->get('aseguradora');
        $transporte->m3_Unidad=$request->get('m3_Unidad');
        $transporte->capacidad=$request->get('capacidad');
        $transporte->chofer_id=$request->get('chofer_id');
        $transporte->update();
        return Redirect::to('transportes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transporte=Transporte::findOrFail($id);
        $transporte->estado="Inactivo";
        $transporte->update();
        return Redirect::to('transportes');
    }



    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('Lista de vehiculos', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $vehiculo = Transporte::join('empleados', 'empleados.id', '=', 'transportes.chofer_id')
                ->select('transportes.nombre_Unidad','transportes.no_Serie','transportes.placas','transportes.poliza_Seguro','transportes.vigencia_Seguro','transportes.aseguradora','transportes.m3_Unidad','transportes.capacidad', \DB::raw("concat(empleados.nombre,' ',empleados.apellidos) as 'name'"))
                ->where('empleados.estado', 'Activo')
                ->get();       
                $sheet->fromArray($vehiculo);
                $sheet->row(1,['Nombre Vehiculo','Numero Serie','Placas','Poliza Seguro','Vigencia Seguro','Aseguradora','Capacidad Ubica','Capacidad','Nombre Chofer']);

                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }
}
