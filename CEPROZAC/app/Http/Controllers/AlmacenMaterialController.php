<?php
namespace CEPROZAC\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\AlmacenMaterialRequest;
use CEPROZAC\Http\Requests\ModalEntradaMat;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradaAlmacen;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenMaterial;
use CEPROZAC\ProvedorMateriales;
use CEPROZAC\AlmacenGeneral;
use CEPROZAC\DetalleEntradasMaterial;
use CEPROZAC\UnidadesMedida;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use CEPROZAC\empresas_ceprozac;


class AlmacenMaterialController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
      $material = DB::table('almacenmateriales')
      ->join('unidades_medidas', 'almacenmateriales.idUnidadMedida', '=','unidades_medidas.id')
      ->select('unidades_medidas.id')
      ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
      ->join('almacengeneral as alma','almacenmateriales.ubicacion', '=', 'alma.id')
      ->select('almacenmateriales.id as idMaterial','almacenmateriales.nombre',
        'almacenmateriales.codigo','almacenmateriales.imagen','almacenmateriales.descripcion', 
        'almacenmateriales.cantidad','alma.nombre as ubicacion', 'almacenmateriales.stock_minimo','almacenmateriales.idUnidadMedida', 
        'unidades_medidas.nombre as nombreUnidadMedida', 
        'unidades_medidas.cantidad as cantidadUnidadMedida', 'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida')
      ->where('almacenmateriales.estado','=','Activo')
      ->get();


      $provedores= DB::table('provedores_tipo_provedor')
      ->join('provedor_materiales', 'provedores_tipo_provedor.idProvedorMaterial','=','provedor_materiales.id')

      ->join('tipo_provedor','provedores_tipo_provedor.idTipoProvedor','=' ,'tipo_provedor.id')
      ->select('provedor_materiales.*', 'tipo_provedor.nombre as tipo')
      ->where('provedores_tipo_provedor.idTipoProvedor','=','1')
      ->where('provedor_materiales.estado','=','Activo')
      ->get();

      $empleado = DB::table('empleados')->where('estado','Activo')->get();
      $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();

      $unidades  = DB::table('unidades_medidas')
      ->join('nombre_unidades_medidas', 'unidades_medidas.idUnidadMedida', '=', 'nombre_unidades_medidas.id')
      ->select('unidades_medidas.*', 'nombre_unidades_medidas.*')
      ->where('estado', '=', 'Activo')
      ->get();

      return view('almacen.materiales.index', ['material' => $material,'provedores' => $provedores, 'empleado' => $empleado,"empresas"=>$empresas,'unidades'=>$unidades]);
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

     $almacen= DB::table('almacengeneral')->where('estado','Activo')->get();
        //$provedor= DB::table('provedor_materiales')->where('estado','Activo')->where('tipo','like','%Agroquimicos%')->get(); 
     return view('almacen.materiales.create',['provedor' => $provedor,'unidades'=>$unidades, 'almacen'=>$almacen]);

   }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlmacenMaterialRequest $request)
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
      $material= new AlmacenMaterial;
      $material->nombre=$request->get('nombre');

        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenMaterial',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
          }
          $material->descripcion=$request->get('descripcion');  
          $material->ubicacion=$request->get('ubicacion');
          $material->cantidad=$cantidadAlmacen;
          $material->idUnidadMedida=$request->get('idUnidadMedida');
          $material->codigo=$request->get('codigo');
          $material->stock_minimo=$stockMinimo;
          $material->estado='Activo';
          $material->save();
          return Redirect::to('detalle/materiales');
        }

        public function detalle(){ 
          $material = DB::table('almacenmateriales')
          ->join('unidades_medidas', 'almacenmateriales.idUnidadMedida', '=','unidades_medidas.id')
          ->select('unidades_medidas.id')
          ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
          ->join('almacengeneral as alma','almacenmateriales.ubicacion', '=', 'alma.id')
          ->select('almacenmateriales.id as idMaterial','almacenmateriales.nombre',
            'almacenmateriales.codigo','almacenmateriales.imagen','almacenmateriales.descripcion', 
            'almacenmateriales.cantidad','alma.nombre as ubicacion', 'almacenmateriales.stock_minimo','almacenmateriales.idUnidadMedida', 
            'unidades_medidas.nombre as nombreUnidadMedida', 
            'unidades_medidas.cantidad as cantidadUnidadMedida','almacenmateriales.created_at',
            'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida')
          ->where('almacenmateriales.estado','=','Activo')
          ->orderby('almacenmateriales.created_at','DESC')->take(1)->get();
          $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
          $almacen= DB::table('almacengeneral')->where('estado','Activo')->get();

          return view('almacen.materiales.detalle',["material"=>$material,"provedor"=>$provedor,"almacen"=>$almacen]);

        }



        public function detalleEditar(){ 
          $material = DB::table('almacenmateriales')
          ->join('unidades_medidas', 'almacenmateriales.idUnidadMedida', '=','unidades_medidas.id')
          ->select('unidades_medidas.id')
          ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
          ->join('almacengeneral as alma','almacenmateriales.ubicacion', '=', 'alma.id')
          ->select('almacenmateriales.id as idMaterial','almacenmateriales.nombre',
            'almacenmateriales.codigo','almacenmateriales.imagen','almacenmateriales.descripcion', 
            'almacenmateriales.cantidad','alma.nombre as ubicacion', 'almacenmateriales.stock_minimo','almacenmateriales.idUnidadMedida', 
            'unidades_medidas.nombre as nombreUnidadMedida', 
            'unidades_medidas.cantidad as cantidadUnidadMedida','almacenmateriales.created_at',
            'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida')
          ->where('almacenmateriales.estado','=','Activo')
          ->orderby('almacenmateriales.updated_at','DESC')->take(1)->get();
          $provedor= DB::table('provedor_materiales')->where('estado','Activo')->get();
          $almacen= DB::table('almacengeneral')->where('estado','Activo')->get();

          return view('almacen.materiales.detalle',["material"=>$material,"provedor"=>$provedor,"almacen"=>$almacen]);

        }

        public function invoice($id){ 
          $material= DB::table('almacenmateriales')->where('id',$id)->get();

          $date = date('Y-m-d');
          $x = "HOLA" ;
          $invoice = "2222";
       // print_r($materiales);    
          $view =  \View::make('almacen.materiales.invoice', compact('date', 'invoice','x','material'))->render();
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
     return view("almacen.materiales.show",["material"=>almacenmaterial::findOrFail($id)]);
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


      $material = AlmacenMaterial::findOrFail($id);
      $cantidad = $material->cantidad;
      $idUnidadMedida = $material->idUnidadMedida;
      $idAgroquimico = $material->id;

      $unidades=$this->propiedadesUnidadMedida($idUnidadMedida);
      $almacen= DB::table('almacengeneral')->where('estado','Activo')->get();


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

      return view("almacen.materiales.edit",["material"=>$material,"unidadesMedidas" => $unidadesMedidas, 
        "unidadesCompletas"=>$unidadesCompletas, "unidadCentral" =>$unidadCentral, 
        "unidadInferior" =>$unidadInferior,"unidad_medida"=>$unidad_medida,'almacen'=>$almacen,
        "capacidadUnidadMedida"=>$capacidadUnidadMedida]);

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

      $material=AlmacenMaterial::findOrFail($id);
      $unidades=$this->propiedadesUnidadMedida($request->get("idUnidadMedida"));
      $unidadDeMedida=$unidades->nombreUnidadMedida;
      $capacidadUnidadMedida= $unidades->cantidad;
      $totalUnidadesCompletas= $capacidadUnidadMedida* $unidadesCompletas = $request->get('unidadesCompletas');
      $unidadCentral = $request->get('unidadCentral');
      $unidadesMedida =$request->get('unidadDeMedida');
      $stockReal = $request->get('stock_min');
      $stockMinimo = $cantidadAlmacen= $this->calcularStockMinimoReal($unidadDeMedida,$stockReal,$capacidadUnidadMedida);
      $cantidadAlmacen= $this->calcularEquivalencia($unidadDeMedida,$totalUnidadesCompletas, $unidadCentral,$unidadesMedida);

      $material->nombre=$request->get('nombre');

        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenMaterial',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
          }
          $material->descripcion=$request->get('descripcion');
          $material->cantidad=$cantidadAlmacen;
          $material->idUnidadMedida=$request->get('idUnidadMedida');
          $material->codigo=$request->get('codigo');
          $material->stock_minimo=$stockMinimo;
          $material->estado='Activo';
          $material->update();
          return Redirect::to('detalleEditar/materiales');

        }
        //
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $material=AlmacenMaterial::findOrFail($id);
     $material->estado='Inactivo';
     $material->save();
     return Redirect::to('almacen/materiales');
        //
   }
   public function excel()
   {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('almacenmateriales', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
           $material = almacenmaterial::join('provedor_materiales','provedor_materiales.id', '=', 'almacenmateriales.provedor')
           ->join('almacengeneral as alma','almacenmateriales.id', '=', 'alma.id')
           ->select('almacenmateriales.id','almacenmateriales.nombre','provedor_materiales.nombre as nom','almacenmateriales.descripcion','almacenmateriales.cantidad','alma.nombre as ubicaciones')
           ->where('almacenmateriales.estado', 'Activo')
           ->get();       
           $sheet->fromArray($material);
           $sheet->row(1,['ID','Material','Proveedor','Descripción','Stock En Almacén','Ubicación']);
           $sheet->setOrientation('landscape');
         });
        })->export('xls');
      }

      public function stock(modalentradamat $formulario, $id)
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
          $material=AlmacenMaterial::findOrFail($id);
          $idUnidadMedida =$material->idUnidadMedida;
          $unidades=$this->propiedadesUnidadMedida($idUnidadMedida);
          $unidadDeMedida=$unidades->nombreUnidadMedida;
          $capacidadUnidadMedida= $unidades->cantidad;
          $totalUnidadesCompletas= $capacidadUnidadMedida* $unidadesCompletas = $formulario->get('cantidad');
          $cantidadAlmacen= $this->calcularEquivalencia($unidadDeMedida,$totalUnidadesCompletas, 0,0);
          DB::beginTransaction();
          $material2= new EntradaAlmacen;
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
          $idEntradaMaterial=$material2->id;
          $detalleMaterial= new DetalleEntradasMaterial;
          $detalleMaterial->idEntradaMaterial =$idEntradaMaterial;
          $detalleMaterial->id_material = $id;
          $detalleMaterial->cantidad= $cantidadAlmacen;
          $detalleMaterial->p_unitario=$formulario->precioUnitario;
          $detalleMaterial->iva=$formulario->iva;
          $detalleMaterial->ieps=$formulario->ieps;
          $detalleMaterial->save();
          $this->actualizarStock($id, $cantidadAlmacen);
          DB::commit();
          return Redirect::to('almacen/materiales');


        }
      }
    }

    public function validarcodigo($codigo)
    {

      $quimico= AlmacenMaterial::
      select('id','codigo','nombre', 'estado')
      ->where('codigo','=',$codigo)
      ->get();

      return response()->json(
        $quimico->toArray());

    }



    public function activar(Request $request)
    { 
      $id =  $request->get('idMat');
      $quimico=almacenmaterial::findOrFail($id);
      $quimico->estado="Activo";
      $quimico->update();
      return Redirect::to('almacen/materiales');
    }


    public function verDetallesArticuloMaterial($id){


      $material = DB::table('almacenmateriales')
      ->join('unidades_medidas', 'almacenmateriales.idUnidadMedida', '=','unidades_medidas.id')
      ->select('unidades_medidas.id')
      ->join('nombre_unidades_medidas','unidades_medidas.idUnidadMedida','=', 'nombre_unidades_medidas.id')
      ->join('almacengeneral as alma','almacenmateriales.ubicacion', '=', 'alma.id')
      ->select('almacenmateriales.id as idMaterial','almacenmateriales.nombre',
        'almacenmateriales.codigo','almacenmateriales.imagen','almacenmateriales.descripcion', 
        'almacenmateriales.cantidad','alma.nombre as ubicacion',
        'almacenmateriales.stock_minimo','almacenmateriales.idUnidadMedida', 
        'unidades_medidas.nombre as nombreUnidadMedida', 
        'unidades_medidas.cantidad as cantidadUnidadMedida','almacenmateriales.created_at',
        'nombre_unidades_medidas.nombreUnidadMedida as unidad_medida')
      ->where('almacenmateriales.estado','=','Activo')
      ->where('almacenmateriales.id','=', $id)
      ->first();



      return  view('almacen.materiales.verDetallesAlmacen', ['material'=>$material]);
    }




    public function calcularCantidadAlmacen($id){

     $material=AlmacenMaterial::findOrFail($id);
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

 $material=AlmacenMaterial::findOrFail($id);
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


 $material=AlmacenMaterial::findOrFail($id);
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

  $material=AlmacenMaterial::findOrFail($id);
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




public function convertidorStockUnidadesMinimas_UnidadCentral($unidadDeMedida,$stock, $capacidadUnidadMedida){
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
  $material=AlmacenMaterial::findOrFail($id);
  $cantidadActual = $material->cantidad;
  $cantidadTotal = $cantidadActual+ $cantidadAlmacen;
  $material->cantidad=$cantidadTotal;
  $material->update();
}


}

