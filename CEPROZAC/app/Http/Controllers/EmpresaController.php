<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Empresa;
use DB;
use Maatwebsite\Excel\Facades\Excel;
class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa= DB::table('empresa')->where('estado','Activo')->get();
        
        return view('empresas.index', ['empresa' => $empresa]);
        
    }



    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('empresas', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
               

                $empresa = Empresa::select('nombre','rfc','direccion','telefono','email','regimenFiscal')
                ->where('estado', 'Activo')
                ->get();       
                $sheet->fromArray($empresa);

                $sheet->row(1,['Nombre Empresa','RFC','Direccion',
                    'Telefono','Email','Regimen Fiscal']);
                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa= new Empresa;
        $empresa->nombre=$request->get('nombre');
        //echo $request->get('nombre');
        $empresa->rfc=$request->get('rfc');
        $empresa->direccion=$request->get('direccion');
        $empresa->telefono=$request->get('telefono');
        $empresa->email=$request->get('email');
        $empresa->regimenFiscal=$request->get('regimenFiscal');
        $empresa->estado='Activo';
        $empresa->save();
        return Redirect::to('empresas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("empresas.show",["empresas"=>Empresa::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

       return view("empresas.edit",["empresas"=>Empresa::findOrFail($id)]);
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
        $empresa=Empresa::findOrFail($id);
        $empresa->nombre=$request->get('nombre');
        //echo $request->get('nombre');
        $empresa->rfc=$request->get('rfc');
        $empresa->direccion=$request->get('direccion');
        $empresa->telefono=$request->get('telefono');
        $empresa->email=$request->get('email');
        $empresa->regimenFiscal=$request->get('regimenFiscal');
        $empresa->estado='Activo';
        $empresa->update();
        return Redirect::to('empresas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresas=Empresa::findOrFail($id);
        $empresas->estado="Inactivo";
        $empresas->update();
        return Redirect::to('empresas');
    }
}
