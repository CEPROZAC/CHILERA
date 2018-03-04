<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Empresa;
use CEPROZAC\Provedor;
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

      $empresas= DB::table('empresas')
      ->join('provedores as p', 'empresas.provedor_id', '=', 'p.id')
      ->join('bancos','empresas.id_Banco','=','bancos.id')
      ->select('empresas.*','bancos.nombre as nombreBanco','p.nombre as nombreProvedor')
      ->where('empresas.estado','Activo')->get();
      return view('Provedores.empresas.index', ['empresas' => $empresas]);

  }
  /*

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bancos=DB::table('bancos')->where('estado','=','Activo')->get();
        $provedores=DB::table('provedores')->where('estado','=','Activo')->get();
        return view("Provedores.empresas.create",["provedores"=>$provedores,"bancos"=>$bancos]);
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
        $empresa->rfc=$request->get('rfc');
        $empresa->regimenFiscal=$request->get('regimenFiscal');
        $empresa->telefono=$request->get('telefono');
        $empresa->direccion=$request->get('direccion');
        $empresa->email=$request->get('email');
        $empresa->id_Banco=$request->get('id_Banco');
        $empresa->cve_Interbancaria=$request->get('cve_Interbancaria');
        $empresa->nom_cuenta=$request->get('nom_cuenta');
        $empresa->estado='Activo';
        $empresa->provedor_id=$request->get('provedor_id');
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

    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresas=Empresa::findOrFail($id);
        $provedores=DB::table('provedores')->where('estado','=','Activo')->get();
        $bancos=DB::table('bancos')->where('estado','=','Activo')->get();
        return view("Provedores.empresas.edit",["provedores"=>$provedores,"empresas"=>$empresas,"bancos"=>$bancos]);
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
        $empresas=Empresa::findOrFail($id);
        $empresas->nombre=$request->get('nombre');
        $empresas->rfc=$request->get('rfc');
        $empresas->regimenFiscal=$request->get('regimenFiscal');
        $empresas->telefono=$request->get('telefono');
        $empresas->direccion=$request->get('direccion');
        $empresas->email=$request->get('email');
        $empresas->id_Banco=$request->get('id_Banco');
        $empresas->cve_Interbancaria=$request->get('cve_Interbancaria');
        $empresas->nom_cuenta=$request->get('nom_cuenta');
        $empresas->estado='Activo';
        $empresas->provedor_id=$request->get('provedor_id');

        $empresas->Update();
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


    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('provedores', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $provedor = Provedor::join('empresas', 'empresa.id', '=', 'provedores.empresa_id')
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

}
