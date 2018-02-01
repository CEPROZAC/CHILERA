<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Provedor;
use CEPROZAC\Empresa;
use DB;
use Maatwebsite\Excel\Facades\Excel;
class ProvedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $provedor= DB::table('provedores')
        ->join('empresa as e', 'provedores.empresa_id', '=', 'e.id')
        ->select('provedores.*','e.nombre as nombreEmpresa')
        ->where('provedores.estado','Activo')->get();
        return view('provedores.index', ['provedor' => $provedor]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $empresas=DB::table('empresa')->where('estado','=','Activo')->get();
        return view("provedores.create",["empresas"=>$empresas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provedor= new Provedor;
        $provedor->nombre=$request->get('nombre');
        $provedor->telefono=$request->get('telefono');
        $provedor->direccion=$request->get('direccion');
        $provedor->email=$request->get('email');
        $provedor->estado='Activo';
        $provedor->empresa_id=$request->get('empresa_id');
        $provedor->save();
        return Redirect::to('provedores');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('provedores', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $provedor = Provedor::join('empresa', 'empresa.id', '=', 'provedores.empresa_id')
                ->select('provedores.nombre', 'provedores.telefono', 'provedores.direccion', 'provedores.email','empresa.nombre AS nom_empresa')
                ->where('provedores.estado', 'Activo')
                ->get();       
                
   
                $sheet->fromArray($provedor);
                $sheet->row(1,['Nombre Proveedor','Telefono Proveedor','Direccion Proveedor',
                    'Email Proveedor','Empresa Factura']);

                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provedor=Provedor::findOrFail($id);
        $empresas=DB::table('empresa')->where('estado','=','Activo')->get();
        return view("provedores.edit",["provedores"=>$provedor,"empresas"=>$empresas]);
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
        $provedor=Provedor::findOrFail($id);
        $provedor->nombre=$request->get('nombre');
        $provedor->telefono=$request->get('telefono');
        $provedor->direccion=$request->get('direccion');
        $provedor->email=$request->get('email');
        $provedor->empresa_id=$request->get('empresa_id');

        $provedor->Update();
        return Redirect::to('provedores');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provedores=Provedor::findOrFail($id);
        $provedores->estado="Inactivo";
        $provedores->update();
        return Redirect::to('provedores');
    }
}
