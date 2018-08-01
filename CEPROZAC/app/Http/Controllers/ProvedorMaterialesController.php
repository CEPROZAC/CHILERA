<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\ProvedorMateriales;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator; 
use CEPROZAC\Http\Requests\ProvedorMaterialesRequest;



class ProvedorMaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $provedores= DB::table('provedor_materiales')->where('estado','Activo')->get();

      return view('Provedores.materiales.index', ['provedores' => $provedores]);

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('Provedores.materiales.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function validar(ProvedorMaterialesRequest $formulario ){
      $validator = Validator::make(
        $formulario->all(), 
        $formulario->rules(),
        $formulario->messages());
      if ($validator->valid()){

        if ($formulario->ajax()){
          return response()->json(["valid" => true], 200);
        }
        else{
          $provedor= new ProvedorMateriales;
          $provedor->nombre=$formulario->get('nombre');
          $provedor->rfc=$formulario->get('rfc');
          $provedor->direccion=$formulario->get('direccion');
          $provedor->telefono=$formulario->get('telefono');
          $provedor->email=$formulario->get('email');

          $provedor->estado='Activo';
          $provedor->save();
          return Redirect::to('materiales/provedores')
          ->with('message', 'Proveedor Registrado Correctamente');
        }
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
     return view("Provedores.materiales.show",["provedores"=>ProvedorMateriales::findOrFail($id)]);
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
     return view("Provedores.materiales.edit",["provedores"=>ProvedorMateriales::findOrFail($id)]);
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
        //$categoria=Categoria::findOrFail($id);
      $provedor=ProvedorMateriales::findOrFail($id);
      $provedor->nombre=$request->get('nombre');
      $provedor->rfc=$request->get('rfc');
        //echo $request->get('nombre');

      $provedor->direccion=$request->get('direccion');
      $provedor->telefono=$request->get('telefono');
      $provedor->email=$request->get('email');

      $provedor->estado='Activo';
      $provedor->update();
      return Redirect::to('materiales/provedores');
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
      $provedores=ProvedorMateriales::findOrFail($id);
      $provedores->estado="Inactivo";
      $provedores->update();
      return Redirect::to('materiales/provedores');
        //
    }

    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('Provedor_Materiales', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {


            $empresa = ProvedorMateriales::select('nombre','rfc','direccion','telefono','email')
            ->where('estado', 'Activo')
            ->get();       
            $sheet->fromArray($empresa);
            $sheet->row(1,['Nombre Proveedor ','RFC','Direccion',
              'Telefono','Email']);
            $sheet->setOrientation('landscape');
          });
        })->export('xls');
      }



      public function descargarProvedores($id,$nombre)
      {
        $nombreExcel ='Lista Mantenimiento de Vehiculo'.' '.$nombre;
        Excel::create($nombreExcel,function($excel) use ($id) {

          $excel->sheet('Excel sheet', function($sheet) use($id) {

            $mantenimiento = MantenimientoTransporte::join('transportes as t', 'mantenimiento_transportes.idTransporte', '=', 't.id')
            ->select('mantenimiento_transportes.concepto','mantenimiento_transportes.descripcion','mantenimiento_transportes.fecha')
            ->where('mantenimiento_transportes.estado','Activo')
            ->where('t.id','=',$id)
            ->get(); 

            $sheet->fromArray($mantenimiento);
            $sheet->row(1,['Concepto','Desripcion','Fecha' ]);
            $sheet->setOrientation('landscape');
          });
        })->export('xls');

      }

      public function validarRFC($rfc)
{

    $provedor= ProvedorMateriales::
    select('id','rfc','nombre', 'estado')
    ->where('rfc','=',$rfc)
    ->get();

    return response()->json(
      $provedor->toArray());

}



public function activar(Request $request)
{ 
    $id =  $request->get('idProvedor');
    $provedor=ProvedorMateriales::findOrFail($id);
    $provedor->estado="Activo";
    $provedor->update();
    return Redirect::to('materiales/provedores');
}

    }