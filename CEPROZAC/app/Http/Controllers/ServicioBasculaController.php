<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\ServicioBascula;
use DB;
use Maatwebsite\ExceL\Facades\Excel;


class ServicioBasculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $servicioBascula= DB::table('servicio_basculas')
      ->join('transportes as v', 'servicio_basculas.idVehiculo', '=', 'v.id')
      ->join('empleados as e','servicio_basculas.idEmpleado','=','e.id')
      ->join('basculas as b','servicio_basculas.idBascula','=','b.id')
      ->join('precio_basculas as pb','servicio_basculas.idBascula','=','pb.id')
      ->select('servicio_basculas.*','v.nombre_Unidad', 'pb.tipoVehiculo','pb.precioBascula','e.nombre','e.apellidos','b.nombreBascula')
      ->where('servicio_basculas.estado','Activo')->get();
      return view('Bascula.servicioBascula.index', ['servicioBascula' => $servicioBascula]);
 
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
