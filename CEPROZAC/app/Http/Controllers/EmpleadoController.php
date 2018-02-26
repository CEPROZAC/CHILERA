<?php

namespace CEPROZAC\Http\Controllers;
use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Empleado;
use CEPROZAC\RolEmpleado;
use DB;
use Maatwebsite\Excel\Facades\Excel;


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados= DB::table('empleados')
        ->join( 'rol_empleados as r', 'empleados.rol','=','r.id')
        ->select('empleados.*','r.rol_Empleado')
        ->where('empleados.estado','Activo')->get();
        return view('empleados.index', ['empleados' => $empleados]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response

     */
    public function create()
    {
        $roles=DB::table('rol_empleados')->where('estado','=' ,'Activo')->get();
        return view("empleados.create",["roles"=>$roles]);


    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        return Redirect::to('empleados');





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
        $empleado=Empleado::findOrFail($id);
        $roles=DB::table('rol_empleados')->where('estado',"=","Activo")->get();
        return view("empleados.edit",["empleado"=>$empleado,"roles"=>$roles]);


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
        $empleado=Empleado::findOrFail($id);
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
        $empleado->estado='Activo';
        $empleado->update();
        return Redirect::to('empleados');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado=Empleado::findOrFail($id);
        $empleado->estado="Inactivo";
        $empleado->update();
        return Redirect::to('empleados');
    }


    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('Lista empleados', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $empleado = Empleado::join('rol_empleados', 'rol_empleados.id', '=', 'empleados.rol')
                ->select('empleados.nombre', 'empleados.apellidos', 'empleados.fecha_Ingreso', 'empleados.fecha_Alta_Seguro','empleados.numero_Seguro_Social','empleados.fecha_Nacimiento','empleados.curp','empleados.email','empleados.telefono','empleados.sexo','empleados.sueldo_Fijo','rol_empleados.rol_Empleado')
                ->where('empleados.estado', 'Activo')
                ->get();       
                $sheet->fromArray($empleado);
                $sheet->row(1,['Nombre ','Apellido','Fecha Ingreso','Fecha Alta Seguro','Numero seguro Social','Fecha Nacimiento','CURP','Correo','Telefono','Sexo','Sueldo','Rol']);

                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }

}
