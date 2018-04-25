<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EmpresasCeprozac;
use CEPROZAC\Banco;
use CEPROZAC\Provedor;
use DB;
use Maatwebsite\Excel\Facades\Excel;


class EmpresasCeprozacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $empresas= DB::table('empresas_ceprozac')
        ->select('empresas_ceprozac.*')
        ->where('empresas_ceprozac.estado','Activo')->get();
        return view('EmpresasCeprozac.empresas.index', ['empresas' => $empresas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $bancos=DB::table('bancos')->where('estado','=','Activo')->get();
      return view('EmpresasCeprozac.empresas.create',['bancos'=>$bancos]);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresaCeprozac= new EmpresasCeprozac;
        $empresaCeprozac->nombre=$request->get('nombre');
        $empresaCeprozac->representanteLegal=$request->get('representanteLegal');
        $empresaCeprozac->telefono=$request->get('telefono');
        $empresaCeprozac->direcionFisica=$request->get('direcionFisica');
        $empresaCeprozac->direcionFacturacion=$request->get('direcionFacturacion');
        $empresaCeprozac->rfc=$request->get('rfc');
        $empresaCeprozac->regimenFiscal=$request->get('regimenFiscal');
        $empresaCeprozac->telefono=$request->get('telefono');
        $empresaCeprozac->email=$request->get('email');   
        $empresaCeprozac->estado='Activo';
        $empresaCeprozac->save();
        return Redirect::to('empresasCEPROZAC');
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

        $empresasCEPROZAC=EmpresasCeprozac::findOrFail($id);
        $bancos=DB::table('bancos')->where('estado','=','Activo')->get();
        return view("EmpresasCeprozac.empresas.edit",["empresasCEPROZAC"=>$empresasCEPROZAC,"bancos"=>$bancos]);
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
        $empresaCeprozac=EmpresasCeprozac::findOrFail($id);
        $empresaCeprozac->nombre=$request->get('nombre');
        $empresaCeprozac->representanteLegal=$request->get('representanteLegal');
        $empresaCeprozac->telefono=$request->get('telefono');
        $empresaCeprozac->direcionFisica=$request->get('direcionFisica');
        $empresaCeprozac->direcionFacturacion=$request->get('direcionFacturacion');
        $empresaCeprozac->rfc=$request->get('rfc');
        $empresaCeprozac->regimenFiscal=$request->get('regimenFiscal');
        $empresaCeprozac->telefono=$request->get('telefono');
        $empresaCeprozac->email=$request->get('email');
        $empresaCeprozac->estado='Activo';
        $empresaCeprozac->Update();

        return Redirect::to('empresasCEPROZAC');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresas=EmpresasCeprozac::findOrFail($id);
        $empresas->estado="Inactivo";
        $empresas->update();
        return Redirect::to('empresasCEPROZAC');
    }


    public function excel()
    {        
        Excel::create('Lista  de empresas CEPROZAC', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $empresas = EmpresasCeprozac::join('bancos','empresas_ceprozac.id_Banco','=','bancos.id')
                ->select('empresas_ceprozac.nombre as nomEmpresa','empresas_ceprozac.representanteLegal','empresas_ceprozac.rfc','empresas_ceprozac.regimenFiscal','empresas_ceprozac.telefono as telEmpresa','empresas_ceprozac.direcionFisica','empresas_ceprozac.direcionFacturacion','empresas_ceprozac.email','bancos.nombre as nombreBanco','cve_Interbancaria','nom_cuenta')
                ->where('empresas_ceprozac.estado','Activo')->get();     
                

                $sheet->fromArray($empresas);
                $sheet->row(1,['Nombre Empresa','Representante Legal','RFC','Regimen Fiscal','Telefono','Direccion Fisica','Direccion de Facturacion','Correo','Banco','Clabe Interbancaria','Numero de cuenta', ]);

                $sheet->setOrientation('landscape');
            });
        })->export('xls');

    }

    public  function verCuentas($id)
    {
      $empresas=EmpresasCeprozac::findOrFail($id);
      $cuentas= DB::table('cuentas_empresas_ceprozac')
      ->join('bancos','bancos.id','=','cuentas_empresas_ceprozac.idBanco')
      ->select('cuentas_empresas_ceprozac.*','bancos.nombre as nomBanco')
      ->where('idEmpresa','=',$id)
      ->where('cuentas_empresas_ceprozac.estado','Activo')
      ->get();
      return view('EmpresasCeprozac.empresas.listaCuentas',['empresas'=>$empresas,'cuentas'=>$cuentas]);
  }


  public function descargarCuentas($id,$nombre)
  {
    $nombreExcel ='Lista de cuentas de '.' '.$nombre;
    Excel::create($nombreExcel,function($excel) use ($id) {

        $excel->sheet('Excel sheet', function($sheet) use($id) {

           $cuentas= DB::table('cuentas_empresas_ceprozac')
           ->join('bancos','bancos.id','=','cuentas_empresas_ceprozac.idBanco')
           ->select('cuentas_empresas_ceprozac.*','bancos.nombre as nomBanco')
           ->where('idEmpresa','=',$id)
           ->where('cuentas_empresas_ceprozac.estado','Activo')
           ->get();
           $sheet->fromArray($cuentas);
           $sheet->row(1,['Banco','Clave Interbancaria','Numero de cuenta','Saldo' ]);
           $sheet->setOrientation('landscape');
       });
    })->export('xls');

}
}
