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
          $unidad = unidadesmedida::findOrFail($id);
        $unidad->nombre=$request->get('nombre');
        $unidad->cantidad=$request->get('cantidad');
        $unidad->unidad_medida=$request->get('medida');
        $unidad->estado="Activo";
        $unidad->update();
         return Redirect::to('unidades_medida');
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
         $unidad = unidadesmedida::findOrFail($id);
                 $unidad->estado="Inactivo";
        $unidad->update();
         return Redirect::to('unidades_medida');
        //
    }

            public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('unidadesmedida', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
            $unidadesmedida = unidadesmedida::select('nombre','cantidad','unidad_medida')
            ->where('estado', 'Activo')
            ->get();       
            $sheet->fromArray($unidadesmedida);
            $sheet->row(1,['Nombre','Cantidad Equivalente','Unidad de Medida']);
            $sheet->setOrientation('landscape');
          });
        })->export('xls');
      }
}
