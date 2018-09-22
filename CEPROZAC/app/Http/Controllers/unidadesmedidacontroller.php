<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use CEPROZAC\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use CEPROZAC\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use CEPROZAC\unidadesmedida;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator; 

class unidadesmedidacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                      $unidades= DB::table('unidadesmedida')->where('estado','Activo')->get();

      return view('unidades_medida.index', ['unidades' => $unidades]);
        //
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view('unidades_medida.create');
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
                $unidad = new unidadesmedida;
        $unidad->nombre=$request->get('nombre');
        $unidad->cantidad=$request->get('cantidad');
        $unidad->unidad_medida=$request->get('medida');
        $unidad->estado="Activo";
        $unidad->save();
         return Redirect::to('unidades_medida');
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
                $unidades = unidadesmedida::findOrFail($id);
        return view('unidades_medida.edit', ['unidades' => $unidades]);
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

            public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('invernaderos', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
            $invernadero = invernaderos::select('nombre','ubicacion','num_modulos')
            ->where('estado', 'Activo')
            ->get();       
            $sheet->fromArray($invernadero);
            $sheet->row(1,['Nombre del Invernadero','Ubicación','Número de Módulos']);
            $sheet->setOrientation('landscape');
          });
        })->export('xls');
      }
}
