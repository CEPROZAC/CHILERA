<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Empleado;
use CEPROZAC\Contratos;
use DB;
use Maatwebsite\Excel\Facades\Excel;



class ContratosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratos= DB::table('contratos')
        ->join( 'empleados as e', 'contratos.idEmpleado','=','e.id')
        ->select('contratos.*','e.*')
        ->where('contratos.estado','Activo')
        ->where('e.estado','Activo')->get();
        return view('Recursos_Humanos.contratos.index', ['contratos' => $contratos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles=DB::table('rol_empleados')->where('estado','=' ,'Activo')->get();
      return view("Recursos_Humanos.contratos.create",["roles"=>$roles]);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      DB::beginTransaction();
      $empleado= new Empleado;
      $empleado->nombre=$request->get('nombre');
      $empleado->apellidos=$request->get('apellidos');
      $empleado->fecha_Ingreso=$request->get('fecha_Ingreso');
      $empleado->fecha_Alta_Seguro=$request->get('fecha_Alta_Seguro');
      $empleado->numero_Seguro_Social=$request->get('numero_Seguro_Social');
      $empleado->fecha_Nacimiento=$request->get('fecha_Nacimiento');
      $empleado->curp=$request->get('curp');
      $empleado->email=$request->get('email');
      $empleado->telefono=$request->get('telefono');
      $empleado->sueldo_Fijo=$request->get('sueldo_Fijo');
      $empleado->rol=$request->get('rol');
      $empleado->estado='Activo';
      substr($_REQUEST['curp'], 10,1) == "H"?$empleado->sexo="Hombre":$empleado->sexo="Mujer";
      $empleado->save();
      $idEmpleado=$empleado->id;
      $contratos= new Contratos;
      $contratos->idEmpleado=$idEmpleado;
      $contratos->fechaInicio=$request->get('fechaInicio');
      $contratos->fechaFin=$request->get('fechaFin');
      $contratos->duracionContrato=$request->get('duracionContrato');
      $contratos->estado='Activo';
      $contratos->save();
      DB::commit();
      return Redirect::to('contratos');
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
        $contrato=Contratos::findOrFail($id);
        $empleado=Empleado::findOrFail($contrato->idEmpleado);
        $roles=DB::table('rol_empleados')->where('estado','=','Activo')->get();
        return view("Recursos_Humanos.contratos.edit",["empleado"=>$empleado,"contrato"=>$contrato,"roles"=>$roles]);
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
     DB::beginTransaction();
    
     $contratos= Contratos::findOrFail($id);
     $contratos->fechaInicio=$request->get('fechaInicio');
     $contratos->fechaFin=$request->get('fechaFin');
     $contratos->duracionContrato=$request->get('duracionContrato');
     $contratos->estado='Activo';
     $contratos->update();

     $idEmpleado=$contratos->idEmpleado;

     $empleado= Empleado::findOrFail($idEmpleado);
     $empleado->nombre=$request->get('nombre');
     $empleado->apellidos=$request->get('apellidos');
     $empleado->fecha_Ingreso=$request->get('fecha_Ingreso');
     $empleado->fecha_Alta_Seguro=$request->get('fecha_Alta_Seguro');
     $empleado->numero_Seguro_Social=$request->get('numero_Seguro_Social');
     $empleado->fecha_Nacimiento=$request->get('fecha_Nacimiento');
     $empleado->curp=$request->get('curp');
     $empleado->email=$request->get('email');
     $empleado->telefono=$request->get('telefono');
     $empleado->sueldo_Fijo=$request->get('sueldo_Fijo');
     $empleado->rol=$request->get('rol');
     $empleado->estado='Activo';
     substr($_REQUEST['curp'], 10,1) == "H"?$empleado->sexo="Hombre":$empleado->sexo="Mujer";
     $empleado->update();
     DB::commit();
     return Redirect::to('contratos');
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contratos=Empleado::findOrFail($id);
        $contratos->estado="Inactivo";
        $contratos->update();
        return Redirect::to('contratos');
    }

    public function excel()
    {

    }
}
