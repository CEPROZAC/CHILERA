<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\empresa;
use CEPROZAC\Producto;
use CEPROZAC\Provedor;
use DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $productos=Producto::findOrFail($id);
        $proveedores=DB::table('provedores')->where('estado','=','Activo')->get();
        return view("productos.edit",["productos"=>$productos,"proveedores"=>$proveedores]);
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
    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('productos', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();

                $producto = Producto::join('provedores', 'provedores.id', '=', 'productos.proveedor')
                ->select('productos.nombre', 'productos.descripcion', 'productos.calidad', 'provedores.nombre AS nombreProveedor')
                ->where('productos.estado', 'Activo')
                ->get();       
                
   
                $sheet->fromArray($producto);
                $sheet->row(1,['Nombre Producto','Descripcion Producto','Calidad Producto','Proveedor']);

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
    public function destroy($id)
    {
        $productos=Producto::findOrFail($id);
        $productos->estado="Inactivo";
        $productos->update();
        return Redirect::to('productos');
    }
}
