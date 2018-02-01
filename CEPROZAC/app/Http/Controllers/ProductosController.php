<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\empresa;
use CEPROZAC\Producto;
use DB;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       // $producto= DB::table('productos')->where('estado','Activo')->get();
        
        //return view('productos.index', ['producto' => $producto]); 
        $producto= DB::table('productos')
        ->join('provedores as P', 'productos.proveedor', '=', 'P.id')
        ->select('productos.*','P.nombre as nombreProveedor')
        ->where('productos.estado','Activo')->get();
        return view('productos.index', ['producto' => $producto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedor=DB::table('provedores')->where('estado','=','Activo')->get();
        return view("productos.create",["proveedor"=>$proveedor]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto= new Producto;
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        $producto->calidad=$request->get('calidad');
        $producto->proveedor=$request->get('proveedor');
        $producto->estado='Activo';
        $producto->save();
        return Redirect::to('productos');
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
        return view("productos.edit",["productos"=>producto::findOrFail($id)]);
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
        $producto=producto::findOrFail($id);
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        $producto->calidad=$request->get('calidad');
        $producto->proveedor=$request->get('proveedor');
        $producto->estado='Activo';
        $producto->update();
        return Redirect::to('productos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productos=Producto::findOrFail($id);
        $productos->estado="Inactivo";
        $productos->update();
        return Redirect::to('productos');
    }
}
