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

        $producto= DB::table('productos')
        ->join('calidad as c', 'productos.calidad', '=', 'c.id')
        ->select('productos.*','c.nombre as nomCalidad')
        ->where('productos.estado','Activo')->get();
        return view('Productos.productos.index', ['producto' => $producto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $calidades=DB::table('calidad')->where('estado','=','Activo')->get();
        $proveedor=DB::table('provedores')->where('estado','=','Activo')->get();
        return view("Productos.productos.create",["proveedor"=>$proveedor,"calidades"=>$calidades]);
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
     
        $producto->calidad=$request->get('calidad');
        $producto->unidad_de_Medida=$request->get('unidad_de_Medida');
        $producto->formato_de_Empaque=$request->get('formato_de_Empaque');
        $producto->porcentaje_Humedad=$request->get('porcentaje_Humedad');
        
        if(Input::hasFile('imagen'))
        {
            $file=$request->file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/productos',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $producto->imagen=$file->getClientOriginalName();
        } 
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
        $calidades=DB::table('calidad')->where('estado','=','Activo')->get();
        return view("Productos.productos.edit",["productos"=>$productos,"calidades"=>$calidades]);
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
        $producto->calidad=$request->get('calidad');
        $producto->unidad_de_Medida=$request->get('unidad_de_Medida');
        $producto->formato_de_Empaque=$request->get('formato_de_Empaque');
        $producto->porcentaje_Humedad=$request->get('porcentaje_Humedad');
    

        if(Input::hasFile('imagen'))
        {
            $file=$request->file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/productos',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $producto->imagen=$file->getClientOriginalName();
        } else {
            $producto->imagen=$request->get('nombreimagen');
        }

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

                $producto = Producto::join('calidad', 'productos.calidad', '=', 'calidad.id')
                ->select('productos.nombre', 'calidad.nombre AS nombreCalidad','unidad_de_Medida','formato_de_Empaque','porcentaje_Humedad')
                ->where('productos.estado', 'Activo')
                ->get();       
                

                $sheet->fromArray($producto);
                $sheet->row(1,['Nombre Producto','Calidad','Unidad de Medida','Formato de Empaque','Porcentaje de Humedad']);

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

    public function pruebas()
    {
        return view("Productos.productos.prueba");
    }
}
