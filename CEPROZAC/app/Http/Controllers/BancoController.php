<?php

namespace CEPROZAC\Http\Controllers;


use Illuminate\Http\Request;

use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Banco;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bancos= DB::table('bancos')->where('estado','Activo')->get();
        return view('Provedores.bancos.index',['bancos' => $bancos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('Provedores.bancos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bancos = new Banco;
        $bancos->nombre=$request->get('nombre');
        $bancos->telefono=$request->get('telefono');
        $bancos->estado='Activo';
        $bancos->save();
        return Redirect::to('bancos');
        
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
    $bancos=Banco::findOrFail($id);
    return view("Provedores.bancos.edit",["bancos"=>$bancos]);

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
        $bancos=Banco::findOrFail($id);
        $bancos->nombre=$request->get('nombre');
        $bancos->telefono=$request->get('telefono');
        $bancos->update();
        return Redirect::to('bancos');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $bancos=Banco::findOrFail($id);
      $bancos->estado="Inactivo";
      $bancos->update();
      return Redirect::to('bancos');
  }


  public function excel()
  {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('Rol Empleados', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $bancos = RolEmpleado::select('nombre', 'telefono')
                ->where('estado', 'Activo')
                ->get();       
                
                
                $sheet->fromArray($roles);
                $sheet->row(1,['Rol Empleado','telefono']);

                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }
}
