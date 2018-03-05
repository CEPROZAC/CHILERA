<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\Cliente;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use CEPROZAC\Http\Requests\ClienteFormRequest;



/**
use Illuminate\Support\MessageBag;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
*/


class ClienteController extends Controller
{
 
    /**
    use DispatchesJobs, ValidatesRequests;
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cliente= DB::table('cliente')->where('estado','Activo')->get();
      return view('clientes.index', ['cliente' => $cliente]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
             return view('clientes.create');   //
           }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(ClienteFormRequest $formulario)
    {

/**
                   $cliente= new Cliente;
             $cliente->nombre=$request->get('nombre');
    $cliente->rfc=$request->get('rfc');
    $cliente->fiscal=$request->get('fiscal');
    $cliente->telefono=$request->get('telefono');
    $cliente->email=$request->get('email');
    $cliente->direccion_fact=$request->get('direccion_fact');
    $cliente->direccion_entr=$request->get('direccion_entr');
    $cliente->cantidad_venta=$request->get('cantidad_venta');
    $cliente->volumen_venta=$request->get('volumen_venta');
    $cliente->saldocliente=$request-

     */

$cliente= new Cliente;
      $validator = Validator::make(
                $formulario->all(), 
                $formulario->rules(),
                $formulario->messages()
                );
        if ($validator->valid()){
            
            if ($formulario->ajax()){
                return response()->json(["valid" => true], 200);
            }
            else{
            }
        }


             $cliente->nombre=$request->get('nombre');
    $cliente->rfc="hbydtf7tfs7t";
    $cliente->fiscal="fiscal";
    $cliente->telefono="343445445";
    $cliente->email=$request->get('email');
    $cliente->direccion_fact="ppe";
    $cliente->direccion_entr="zacatecas";
    $cliente->cantidad_venta="44";
    $cliente->volumen_venta="kilos";
    $cliente->saldocliente="565";
    $cliente->estado='Activo';

    $cliente->save();
    return Redirect::to('clientesd')->with('message', 'Enhorabuena formulario enviado correctamente');


   


        //
  }

        public function validarMiFormulario(ClienteFormRequest $formulario ){
        $validator = Validator::make(
                $formulario->all(), 
                $formulario->rules(),
                $formulario->messages(),[ 'nombre' => 'required|unique:posts|max:255']
                );
        if ($validator->valid()){
            
            if ($formulario->ajax()){
                return response()->json(["valid" => true], 200);
            }
            else{
              $cliente= new Cliente;
                $cliente->nombre=$formulario->get('nombre');
    $cliente->rfc="hbydtfs7tf";
    $cliente->fiscal="fiscal";
    $cliente->telefono="343445445";
    $cliente->email=$formulario->get('email');
    $cliente->direccion_fact="ppe";
    $cliente->direccion_entr="zacatecas";
    $cliente->cantidad_venta="44";
    $cliente->volumen_venta="kilos";
    $cliente->saldocliente="565";
    $cliente->estado='Activo';

    $cliente->save();
            return redirect('clientes/index')
                    ->with('message', 'Enhorabuena formulario enviado correctamente');
            }
        }
    }

    /**
    protected function formatValidationErrors(Validator $validator)
    {


        return $validator->errors()->all();

    }

     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     return view("clientes.show",["clientes"=>Cliente::findOrFail($id)]);
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
      return view("clientes.edit",["clientes"=>Cliente::findOrFail($id)]);
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
      $cliente=Cliente::findOrFail($id);

      $cliente->nombre=$request->get('nombre');
      $cliente->rfc=$request->get('rfc');
      $cliente->fiscal=$request->get('fiscal');
      $cliente->telefono=$request->get('telefono');
      $cliente->email=$request->get('email');
      $cliente->direccion_fact=$request->get('direccion_fact');
      $cliente->direccion_entr=$request->get('direccion_entr');
      $cliente->cantidad_venta=$request->get('cantidad_venta');
      $cliente->volumen_venta=$request->get('volumen_venta');
      $cliente->saldocliente=$request->get('saldocliente');
      $cliente->estado='Activo';
      $cliente->save();
      return Redirect::to('clientes');
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
      $cliente=Cliente::findOrFail($id);
      $cliente->estado='Inactivo';
      $cliente->save();
      return Redirect::to('clientes');
        //
    }

    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('clientes', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $clientes = Cliente::select('nombre','rfc','fiscal', 'telefono', 'email', 'direccion_fact', 'direccion_entr', 'cantidad_venta','volumen_venta', 'email', 'saldocliente')
            ->where('estado', 'Activo')
            ->get();       
            $sheet->fromArray($clientes);
            $sheet->row(1,['Nombre','RFC','Regimen Fiscal' ,'Teléfono','Email','Dirección de Facturación','Dirección de Entrega de Embarque','Asignación de Cantidad de Venta por Año',' Asignación de Volumen de Venta por Año','Saldo Cliente $',]);
            $sheet->setOrientation('landscape');
            
            /*    
            $objDrawing = new PHPExcel_Worksheet_Drawing;
            $objDrawing->setPath(public_path('images\logoCeprozac.jpg')); //your image path
            $objDrawing->setCoordinates('E20');
            $objDrawing->setWorksheet($sheet);
            $objDrawing->setResizeProportional(true);
            $objDrawing->setWidthAndHeight(260,220);
            $objDrawing->setOffsetX(200);
*/
          });
        })->export('xls');
      }



    }