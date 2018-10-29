<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;

use CEPROZAC\AlmacenEmpaque;
use CEPROZAC\FormaeEmpaque;
use CEPROZAC\Http\Requests\AlmacenEmpaqueRequest;
use CEPROZAC\Http\Requests\modalentradaemp;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradasEmpaques;
use CEPROZAC\ProvedorMateriales;
use CEPROZAC\EmpresasCeprozac;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use CEPROZAC\DetalleEntradasEmpaques;

class AlmacenEmpaqueController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $material = DB::table('almacenempaque')
      ->join('forma_empaques', 'almacenempaque.idFormaEmpaque','=' ,'forma_empaques.id')
      ->select('almacenempaque.*', 'forma_empaques.*')
      ->join('unidades_medidas', 'almacenempaque.idUnidadMedida', '=','unidades_medidas.id')
      ->select('unidades_medidas.id')
      ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
      ->select('almacenempaque.id as idEmpaque',
        'almacenempaque.codigo','almacenempaque.imagen','almacenempaque.descripcion', 
        'almacenempaque.cantidad', 'almacenempaque.stock_minimo','almacenempaque.idUnidadMedida', 
        'unidades_medidas.nombre as nombreUnidadMedida','forma_empaques.formaEmpaque',
        'unidades_medidas.cantidad as cantidadUnidadMedida', 'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida')
      ->where('almacenempaque.estado','=','Activo')
      ->get();


      $provedores= DB::table('provedores_tipo_provedor')
      ->join('provedor_materiales', 'provedores_tipo_provedor.idProvedorMaterial','=','provedor_materiales.id')

      ->join('tipo_provedor','provedores_tipo_provedor.idTipoProvedor','=' ,'tipo_provedor.id')
      ->select('provedor_materiales.*', 'tipo_provedor.nombre as tipo')
      ->where('provedores_tipo_provedor.idTipoProvedor','=','2')
      ->where('provedor_materiales.estado','=','Activo')
      ->get();

      $empleado = DB::table('empleados')->where('estado','Activo')->get();
      $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();

      $unidades  = DB::table('unidades_medidas')
      ->join('nombre_unidades_medidas', 'unidades_medidas.idUnidadMedida', '=', 'nombre_unidades_medidas.id')
      ->select('unidades_medidas.*', 'nombre_unidades_medidas.*')
      ->where('estado', '=', 'Activo')
      ->get();

      return view('almacen.empaque.index', ['material' => $material,'provedores' => $provedores, 'empleado' => $empleado,"empresas"=>$empresas,'unidades'=>$unidades]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $provedor = DB::table('provedores_tipo_provedor')
     ->join('provedor_materiales as p', 'provedores_tipo_provedor.idProvedorMaterial', '=', 'p.id')
     ->select('provedores_tipo_provedor.*','p.nombre as nombre')
     ->where('provedores_tipo_provedor.idTipoProvedor','2')->get();

     $unidades  = DB::table('unidades_medidas')
     ->join('nombre_unidades_medidas', 'unidades_medidas.idUnidadMedida', '=', 'nombre_unidades_medidas.id')
     ->select('unidades_medidas.id as idContenedorUnidadMedida','unidades_medidas.nombre','unidades_medidas.cantidad', 'unidades_medidas.idUnidadMedida', 'nombre_unidades_medidas.*')
     ->where('estado', '=', 'Activo')
     ->get();
     $empaque= DB::table('forma_empaques')->where('estado','Activo')->get();


        //$provedor= DB::table('provedor_materiales')->where('estado','Activo')->where('tipo','like','%Agroquimicos%')->get(); 
     return view('almacen.empaque.create',['provedor' => $provedor,'unidades'=>$unidades, 'empaque' =>$empaque]);

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
      $unidades=$this->propiedadesUnidadMedida($request->get("idUnidadMedida"));
      $unidadDeMedida=$unidades->nombreUnidadMedida;
      $capacidadUnidadMedida= $unidades->cantidad;
      $totalUnidadesCompletas= $capacidadUnidadMedida* $unidadesCompletas = $request->get('unidadesCompletas');
      $unidadCentral = $request->get('unidadCentral');
      $unidadesMedida =$request->get('unidadDeMedida');
      $stockReal = $request->get('stock_min');
      $stockMinimo = $cantidadAlmacen= $this->calcularStockMinimoReal($unidadDeMedida,$stockReal,$capacidadUnidadMedida);
      $cantidadAlmacen= $this->calcularEquivalencia($unidadDeMedida,$totalUnidadesCompletas, $unidadCentral,$unidadesMedida);
      $material= new AlmacenEmpaque;
      $material->idFormaEmpaque=$request->get('idEmpaque');

        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenempaque',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
          }
          $material->descripcion=$request->get('descripcion');
          $material->cantidad=$cantidadAlmacen;
          $material->idUnidadMedida=$request->get('idUnidadMedida');
          $material->codigo=$request->get('codigo');
          $material->stock_minimo=$stockMinimo;
          $material->estado='Activo';
          $material->save();
          return Redirect::to('detalle/empaque');
        }

        public function detalle(){ 

          $material = DB::table('almacenempaque')
          ->join('forma_empaques', 'almacenempaque.idFormaEmpaque','=' ,'forma_empaques.id')
          ->select('almacenempaque.*', 'forma_empaques.*')
          ->join('unidades_medidas', 'almacenempaque.idUnidadMedida', '=','unidades_medidas.id')
          ->select('unidades_medidas.id')
          ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
          ->select('almacenempaque.id as idEmpaque',
            'almacenempaque.codigo','almacenempaque.imagen','almacenempaque.descripcion', 
            'almacenempaque.cantidad', 'almacenempaque.stock_minimo','almacenempaque.idUnidadMedida', 
            'unidades_medidas.nombre as nombreUnidadMedida','forma_empaques.formaEmpaque',
            'unidades_medidas.cantidad as cantidadUnidadMedida', 'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida'
            ,'almacenempaque.created_at')
          ->where('almacenempaque.estado','=','Activo')
          ->orderby('almacenempaque.created_at','DESC')
          ->take(1)->get();

          $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
          return view('almacen.empaque.detalle',["material"=>$material,"provedor"=>$provedor]);
        }

        public function detalleEditar(){ 

          $material = DB::table('almacenempaque')
          ->join('forma_empaques', 'almacenempaque.idFormaEmpaque','=' ,'forma_empaques.id')
          ->select('almacenempaque.*', 'forma_empaques.*')
          ->join('unidades_medidas', 'almacenempaque.idUnidadMedida', '=','unidades_medidas.id')
          ->select('unidades_medidas.id')
          ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
          ->select('almacenempaque.id as idEmpaque',
            'almacenempaque.codigo','almacenempaque.imagen','almacenempaque.descripcion', 
            'almacenempaque.cantidad', 'almacenempaque.stock_minimo','almacenempaque.idUnidadMedida', 
            'unidades_medidas.nombre as nombreUnidadMedida','forma_empaques.formaEmpaque',
            'unidades_medidas.cantidad as cantidadUnidadMedida', 'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida'
            ,'almacenempaque.created_at')
          ->where('almacenempaque.estado','=','Activo')
          ->orderby('almacenempaque.updated_at','DESC')
          ->take(1)->get();

          $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
          return view('almacen.empaque.detalle',["material"=>$material,"provedor"=>$provedor]);
        }



        public function invoice($id){ 
          $material = DB::table('almacenempaque')
          ->join('forma_empaques', 'almacenempaque.idFormaEmpaque','=' ,'forma_empaques.id')
          ->select('almacenempaque.*', 'forma_empaques.*')
          ->join('unidades_medidas', 'almacenempaque.idUnidadMedida', '=','unidades_medidas.id')
          ->select('unidades_medidas.id')
          ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
          ->select('almacenempaque.id as idEmpaque',
            'almacenempaque.codigo','almacenempaque.imagen','almacenempaque.descripcion', 
            'almacenempaque.cantidad', 'almacenempaque.stock_minimo','almacenempaque.idUnidadMedida', 
            'unidades_medidas.nombre as nombreUnidadMedida','forma_empaques.formaEmpaque',
            'unidades_medidas.cantidad as cantidadUnidadMedida', 'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida'
            ,'almacenempaque.created_at')
          ->where('almacenempaque.estado','=','Activo')
          ->where('almacenempaque.id', '=', $id)
          ->get();



         //$material   = AlmacenMaterial:: findOrFail($id);
          $date = date('Y-m-d');
          $invoice = "2222";
       // print_r($materiales);    
          $view =  \View::make('almacen.empaque.invoice', compact('date', 'invoice','material'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view);
          return $pdf->stream('invoice');
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

      $unidadesMedidas  = DB::table('unidades_medidas')
      ->join('nombre_unidades_medidas', 'unidades_medidas.idUnidadMedida', '=', 'nombre_unidades_medidas.id')
      ->select('unidades_medidas.id as idContenedorUnidadMedida','unidades_medidas.nombre','unidades_medidas.cantidad', 'unidades_medidas.idUnidadMedida', 'nombre_unidades_medidas.*')
      ->where('estado', '=', 'Activo')
      ->get();

      $material = AlmacenEmpaque::findOrFail($id);
      $cantidad = $material->cantidad;
      $idUnidadMedida = $material->idUnidadMedida;
      $idAgroquimico = $material->id;

      $unidades=$this->propiedadesUnidadMedida($idUnidadMedida);
      $unidadDeMedida=$unidades->nombreUnidadMedida;
      $capacidadUnidadMedida= $unidades->cantidad;
      $unidad_medida = $unidades->nombreUnidadMedida;
      if($unidad_medida == "KILOGRAMOS"  || $unidad_medida == "LITROS"  ||  $unidad_medida == "METROS"){
        $unidadesCompletas= $this->calcularCantidadAlmacen($idAgroquimico);
        $unidadCentral= $this->calcularCantidadUnidadCentral($idAgroquimico);
        $unidadInferior=$this->calcularCantidadUnidadInferior($idAgroquimico);
      }
      else {

        $unidadesCompletas= $this->calcularCantidadAlmacen($idAgroquimico);
        $unidadCentral= $this->calcularCantidadUnidadCentral($idAgroquimico);
        $unidadInferior=$this->calcularCantidadUnidadInferior($idAgroquimico);
      }
      $empaque= DB::table('forma_empaques')->where('estado','Activo')->get();

      return view("almacen.empaque.edit",["material"=>$material,"unidadesMedidas" => $unidadesMedidas, 
        "unidadesCompletas"=>$unidadesCompletas, "unidadCentral" =>$unidadCentral, 
        "unidadInferior" =>$unidadInferior,"unidad_medida"=>$unidad_medida,'empaque'=>$empaque]);
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

      $material=AlmacenEmpaque::findOrFail($id);
      $unidades=$this->propiedadesUnidadMedida($request->get("idUnidadMedida"));
      $unidadDeMedida=$unidades->nombreUnidadMedida;
      $capacidadUnidadMedida= $unidades->cantidad;
      $totalUnidadesCompletas= $capacidadUnidadMedida* $unidadesCompletas = $request->get('unidadesCompletas');
      $unidadCentral = $request->get('unidadCentral');
      $unidadesMedida =$request->get('unidadDeMedida');
      $stockReal = $request->get('stock_min');
      $stockMinimo = $cantidadAlmacen= $this->calcularStockMinimoReal($unidadDeMedida,$stockReal);
      $cantidadAlmacen= $this->calcularEquivalencia($unidadDeMedida,$totalUnidadesCompletas, $unidadCentral,$unidadesMedida);

      $material->idFormaEmpaque=$request->get('idEmpaque');

        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenempaque',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
          }
          $material->descripcion=$request->get('descripcion');
          $material->cantidad=$cantidadAlmacen;
          $material->idUnidadMedida=$request->get('idUnidadMedida');
          $material->codigo=$request->get('codigo');
          $material->stock_minimo=$stockMinimo;
          $material->estado='Activo';
          $material->update();
          return Redirect::to('detalleEditar/empaques');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $material=AlmacenEmpaque::findOrFail($id);
      $material->estado='Inactivo';
      $material->save();
      return Redirect::to('almacenes/empaque');
        //
    }

    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('almacenempaque', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
            $material = almacenempaque::join('provedor_materiales','provedor_materiales.id', '=', 'almacenempaque.provedor')
            ->select('almacenempaque.*')
            ->where('almacenempaque.estado', 'Activo')
            ->get();       
            $array = array("foo", "bar", "hello", "world");   
            $sheet->fromArray($array);
            $sheet->row(1,['D']);
            $sheet->setOrientation('landscape');


          });
        })->export('xls');
      }

      public function stock(modalentradaemp $formulario, $id)
      {
        $validator = Validator::make(
          $formulario->all(), 
          $formulario->rules(),
          $formulario->messages());
        if ($validator->valid()){

          if ($formulario->ajax()){
            return response()->json(["valid" => true], 200);
          }
          else{
            $material=AlmacenEmpaque::findOrFail($id);
            $idUnidadMedida =$material->idUnidadMedida;
            $unidades=$this->propiedadesUnidadMedida($idUnidadMedida);
            $unidadDeMedida=$unidades->nombreUnidadMedida;
            $capacidadUnidadMedida= $unidades->cantidad;
            $totalUnidadesCompletas= $capacidadUnidadMedida* $unidadesCompletas = $formulario->get('cantidad');
            $cantidadAlmacen= $this->calcularEquivalencia($unidadDeMedida,$totalUnidadesCompletas, 0,0);

            DB::beginTransaction();
            $material2= new EntradasEmpaques;
            $material2->provedor=$formulario->get('provedor');
            $material2->fecha=$formulario->get('fecha2'.$id);
            $material2->factura=$formulario->get('factura'.$id);
            $material2->comprador=$formulario->get('recibio'.$id);
            $material2->moneda=$formulario->get('moneda'.$id);
            $material2->entregado=$formulario->get('entregado_a'.$id);
            $material2->recibe_alm=$formulario->get('recibe_alm'.$id);
            $material2->observacionesc=$formulario->get('observaciones'.$id); 
            $material2->estado="Activo";
            $material2->save();
            $idEntradaEmpaque=$material2->id;
            $detalleMaterial= new DetalleEntradasEmpaques;
            $detalleMaterial->idEntradaMaterial =$idEntradaEmpaque;
            $detalleMaterial->id_material = $id;
            $detalleMaterial->cantidad= $cantidadAlmacen;
            $detalleMaterial->p_unitario=$formulario->precioUnitario;
            $detalleMaterial->iva=$formulario->iva;
            $detalleMaterial->ieps=$formulario->ieps;
            $detalleMaterial->save();
            $this->actualizarStock($id, $cantidadAlmacen);
            DB::commit();
            return Redirect::to('almacenes/empaque');
          }
        }

      }

      public function validarcodigo($codigo)
      {

        $quimico= almacenempaque::
        select('id','codigo','nombre', 'estado')
        ->where('codigo','=',$codigo)
        ->get();

        return response()->json(
          $quimico->toArray());

      }



      public function activar(Request $request)
      { 
        $id =  $request->get('idEmp');
        $quimico=almacenempaque::findOrFail($id);
        $quimico->estado="Activo";
        $quimico->update();
        return Redirect::to('almacenes/empaque');
      }


      public function calcularCantidadAlmacen($id){

       $material=AlmacenEmpaque::findOrFail($id);
       $idUnidadMedida = $material->idUnidadMedida;
       $unidad_medida  = $this->propiedadesUnidadMedida($idUnidadMedida);
       $cantidadAlmacen=$material->cantidad;
       $diferenciadorUnidadMedida= $unidad_medida->nombreUnidadMedida;
       $capacidadUnidadMedida= $unidad_medida->cantidad;

       if($diferenciadorUnidadMedida == "KILOGRAMOS")
       {
        $cantidadUnidadesCompletas= floor($cantidadAlmacen /1000 / $capacidadUnidadMedida);

        return $cantidadUnidadesCompletas;
      }
      elseif($diferenciadorUnidadMedida == "LITROS")  
      {
        $cantidadUnidadesCompletas= floor($cantidadAlmacen /1000 / $capacidadUnidadMedida);
        return $cantidadUnidadesCompletas;

      } 
      elseif($diferenciadorUnidadMedida =="UNIDADES")
      {
       return $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
     }

     elseif($diferenciadorUnidadMedida =="METROS") {
      return  $cantidadUnidadesCompletas=floor($cantidadAlmacen /100/$capacidadUnidadMedida); 
    }

    elseif($diferenciadorUnidadMedida =="GRAMOS") {
      return  $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
    }

    elseif($diferenciadorUnidadMedida =="CENTIMETROS") {
      return  $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
    }

    elseif($diferenciadorUnidadMedida =="MILILITROS") {
      return  $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
    }
  }





  public function calcularCantidadUnidadCentral($id){

   $material=AlmacenEmpaque::findOrFail($id);
   $idUnidadMedida = $material->idUnidadMedida;
   $unidad_medida  =  $this->propiedadesUnidadMedida($idUnidadMedida);
   $cantidadAlmacen=$material->cantidad;
   $diferenciadorUnidadMedida= $unidad_medida->nombreUnidadMedida;
   $capacidadUnidadMedida= $unidad_medida->cantidad;

   if($diferenciadorUnidadMedida == "KILOGRAMOS")
   {


    $cantidadUnidadesCompletas= ((floor($cantidadAlmacen /1000 / $capacidadUnidadMedida))*$capacidadUnidadMedida)*1000;

    $cantidadUnidadCentral =floor( ($cantidadAlmacen - $cantidadUnidadesCompletas)/1000);

    return $cantidadUnidadCentral;
  }
  elseif($diferenciadorUnidadMedida =="LITROS")  
  {

    $cantidadUnidadesCompletas= ((floor($cantidadAlmacen /1000 / $capacidadUnidadMedida))*$capacidadUnidadMedida)*1000;
    $cantidadUnidadCentral =floor( ($cantidadAlmacen - $cantidadUnidadesCompletas)/1000);

    return $cantidadUnidadCentral;
  } 
  elseif($diferenciadorUnidadMedida =="UNIDADES")
  {
   return $cantidadUnidadesCompletas=0; 
 }

 elseif($diferenciadorUnidadMedida =="METROS") {

  $cantidadUnidadesCompletas= ((floor($cantidadAlmacen /100 / $capacidadUnidadMedida))*$capacidadUnidadMedida)*100;
  $cantidadUnidadCentral =floor( ($cantidadAlmacen - $cantidadUnidadesCompletas)/100);
  return  $cantidadUnidadCentral;
}


}
public function calcularCantidadUnidadInferior($id){


 $material=AlmacenEmpaque::findOrFail($id);
 $idUnidadMedida = $material->idUnidadMedida;
 $unidad_medida  = $this->propiedadesUnidadMedida($idUnidadMedida);
 $cantidadAlmacen=$material->cantidad;
 $diferenciadorUnidadMedida= $unidad_medida->nombreUnidadMedida;
 $capacidadUnidadMedida= $unidad_medida->cantidad;

 if($diferenciadorUnidadMedida == "KILOGRAMOS")
 {

   $cantidadUnidadesCompletas= ((floor($cantidadAlmacen /1000 / $capacidadUnidadMedida))*$capacidadUnidadMedida)*1000;
   $cantidadUnidadCentral =floor( ($cantidadAlmacen - $cantidadUnidadesCompletas)/1000) *1000;
   $cantidadUnidadInferior =$cantidadAlmacen -($cantidadUnidadesCompletas+$cantidadUnidadCentral);

   return $cantidadUnidadInferior;
 }
 elseif($diferenciadorUnidadMedida =="LITROS")  
 {

   $cantidadUnidadesCompletas= ((floor($cantidadAlmacen /1000 / $capacidadUnidadMedida))*$capacidadUnidadMedida)*1000;
   $cantidadUnidadCentral =floor( ($cantidadAlmacen - $cantidadUnidadesCompletas)/1000) *1000;
   $cantidadUnidadInferior =$cantidadAlmacen -($cantidadUnidadesCompletas+$cantidadUnidadCentral);
   return $cantidadUnidadInferior;
 } 
 elseif($diferenciadorUnidadMedida =="UNIDADES")
 {
  $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
  return $cantidadUnidadesCompletas=$cantidadAlmacen -($cantidadUnidadesCompletas*$capacidadUnidadMedida); 
} elseif($diferenciadorUnidadMedida =="METROS") {

  $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
  return $cantidadUnidadesCompletas=$cantidadAlmacen -($cantidadUnidadesCompletas*$capacidadUnidadMedida); 

} elseif($diferenciadorUnidadMedida =="GRAMOS") {

 $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
 return $cantidadUnidadesCompletas=$cantidadAlmacen -($cantidadUnidadesCompletas*$capacidadUnidadMedida); 

} elseif($diferenciadorUnidadMedida =="MILILITROS") {


  $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
  return $cantidadUnidadesCompletas=$cantidadAlmacen -($cantidadUnidadesCompletas*$capacidadUnidadMedida); 

} elseif($diferenciadorUnidadMedida =="CENTIMETROS") {

 $cantidadUnidadesCompletas=floor($cantidadAlmacen /$capacidadUnidadMedida); 
 return $cantidadUnidadesCompletas=$cantidadAlmacen -($cantidadUnidadesCompletas*$capacidadUnidadMedida); 
}



}




public function labelUnidadMedidaMinima($id){

  $material=AlmacenEmpaque::findOrFail($id);
  $idUnidadMedida = $material->idUnidadMedida;
  $unidad_medida  = $this->propiedadesUnidadMedida($idUnidadMedida);
  $cantidadAlmacen=$material->cantidad;
  $diferenciadorUnidadMedida= $unidad_medida->nombreUnidadMedida;
  $capacidadUnidadMedida= $unidad_medida->cantidad;

  if($diferenciadorUnidadMedida == "KILOGRAMOS")
  {

   return "GRAMOS";
 }
 elseif($diferenciadorUnidadMedida =="LITROS")  
 {

   return "MILILITROS";
 } 
 elseif($diferenciadorUnidadMedida =="UNIDADES")
 {
   return "UNIDADES"; 
 }

 elseif($diferenciadorUnidadMedida =="METROS") {
  return  "CENTIMETROS"; 

}  elseif($diferenciadorUnidadMedida =="CENTIMETROS") {
  return  "CENTIMETROS";

} elseif($diferenciadorUnidadMedida =="GRAMOS") {
  return  "GRAMOS";
}
elseif($diferenciadorUnidadMedida =="MILILITROS") {
  return  "MILILITROS";
}

}
public function calcularEquivalencia($unidadDeMedida,$unidadesCompletas,$unidadCentral,$unidadesMedida){

  if($unidadDeMedida == "LITROS"){
    $total=$unidadesCompletas*1000+ $unidadCentral * 1000 +$unidadesMedida  ;
    return $total;
  }

  elseif ($unidadDeMedida =="KILOGRAMOS") {

   $total=$unidadesCompletas*1000+ $unidadCentral * 1000 +$unidadesMedida  ;
   return $total;
 }

 elseif ($unidadDeMedida=="METROS") {
   $total=$unidadesCompletas*100+ $unidadCentral * 100 +$unidadesMedida  ;
   return $total;
 }
 elseif($unidadDeMedida=="UNIDADES"){
  $total = $unidadesCompletas + $unidadCentral;
  return $total;
} elseif($unidadDeMedida=="GRAMOS"){
  $total = $unidadesCompletas + $unidadCentral;
  return $total;
} elseif($unidadDeMedida=="MILILITROS"){
  $total = $unidadesCompletas + $unidadCentral;
  return $total;
} elseif($unidadDeMedida=="CENTIMETROS"){
  $total = $unidadesCompletas + $unidadCentral;
  return $total;
} 

}





public  function calcularStockMinimoReal($unidadDeMedida,$stock,$capacidadUnidadMedida){
  if($unidadDeMedida == "LITROS"){
    $total=$stock*1000 * $capacidadUnidadMedida;
    return $total;
  }

  elseif ($unidadDeMedida =="KILOGRAMOS") {

    $total=$stock*1000 *$capacidadUnidadMedida;
    return $total;
  }

  elseif ($unidadDeMedida=="METROS") {
    $total=$stock*100 *$capacidadUnidadMedida;
    return $total;
  }
  elseif($unidadDeMedida=="UNIDADES"){
    $total = $stock* $capacidadUnidadMedida ;
    return $total;
  } 
  elseif($unidadDeMedida=="MILILITROS"){
    $total = $stock *$capacidadUnidadMedida;
    return $total;
  }
  elseif($unidadDeMedida=="GRAMOS"){
    $total = $stock *$capacidadUnidadMedida;
    return $total;
  }
  elseif($unidadDeMedida=="CENTIMETROS"){
    $total = $stock *$capacidadUnidadMedida;
    return $total;
  }

}



public function convertidorStockUnidadesMinimas_UnidadCentral($unidadDeMedida,$stock,$capacidadUnidadMedida){
  if($unidadDeMedida == "LITROS"){
    $total=$stock/1000/ $capacidadUnidadMedida ;
    return $total;
  }
  elseif ($unidadDeMedida =="KILOGRAMOS") {
    $total=$stock/1000 /$capacidadUnidadMedida;
    return $total;
  }
  elseif ($unidadDeMedida=="METROS") {
    $total=$stock/100 /$capacidadUnidadMedida;
    return $total;
  }
  elseif($unidadDeMedida=="UNIDADES"){
    $total = $stock / $capacidadUnidadMedida;
    return $total;
  }   

  elseif($unidadDeMedida=="MILILITROS"){
    $total = $stock / $capacidadUnidadMedida;
    return $total;
  } 

  elseif($unidadDeMedida=="CENTIMETROS"){
    $total = $stock / $capacidadUnidadMedida;
    return $total;
  } 
  elseif($unidadDeMedida=="GRAMOS"){
    $total = $stock  / $capacidadUnidadMedida;
    return $total;
  } 
}




public function  propiedadesUnidadMedida($id){
  $unidades  = DB::table('unidades_medidas')
  ->join('nombre_unidades_medidas', 'unidades_medidas.idUnidadMedida', '=', 'nombre_unidades_medidas.id')
  ->select('unidades_medidas.*', 'nombre_unidades_medidas.*')
  ->where('estado', '=', 'Activo')
  ->where('unidades_medidas.id','=', $id)
  ->first();

  return $unidades;
}

public function actualizarStock($id,$cantidadAlmacen){
  $material=AlmacenEmpaque::findOrFail($id);
  $cantidadActual = $material->cantidad;
  $cantidadTotal = $cantidadActual+ $cantidadAlmacen;
  $material->cantidad=$cantidadTotal;
  $material->update();
}








}
