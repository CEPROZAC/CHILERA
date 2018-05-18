<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Provedor;
use CEPROZAC\Producto;
use CEPROZAC\Transporte;
use CEPROZAC\ServicioBascula;
use CEPROZAC\RecepcionCompra;
use CEPROZAC\Empleado;
use CEPROZAC\Bascula;
use CEPROZAC\fumigaciones;
use CEPROZAC\AlmacenGeneral;

use DB;
use Maatwebsite\Excel\Facades\Excel;

class fumigacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
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
