<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input; 
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\DetallesEntradasAgroquimicosRequest;
use CEPROZAC\Http\Requests\EntradasAgroquimicosRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradasAgroquimicos;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenAgroquimicos;
use CEPROZAC\ProvedorMateriales;
use CEPROZAC\Empresas_Ceprozac;
use CEPROZAC\Unidades_Medida;
use CEPROZAC\DetallesEntradasAgroquimicos;
use CEPROZAC\NombreUnidadesMedida;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;

class EntradasAgroquimicosController extends Controller
{ 
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {

     $errorProveedor="";
     $errorMaterial="";
     $errorEmpleado="";

     $entrada= DB::table('entradasagroquimicos')->where('entradasagroquimicos.estado','=','Activo')
     ->join('provedor_materiales','entradasagroquimicos.provedor','=', 'provedor_materiales.id')
     ->join('empresas_ceprozac', 'entradasagroquimicos.comprador','=', 'empresas_ceprozac.id')
     ->join('empleados as empEntrega', 'entradasagroquimicos.entregado','=', 'empEntrega.id')
     ->join('empleados as empRecibe', 'entradasagroquimicos.recibe_alm','=', 'empRecibe.id')
     ->select('entradasagroquimicos.id as idEntradaAgroquimicos', 'entradasagroquimicos.fecha',
      'entradasagroquimicos.factura', 'entradasagroquimicos.moneda', 'entradasagroquimicos.observacionesc',
      'entradasagroquimicos.estado as estadoEntrada','empEntrega.nombre as nombreEmpleadoEntrega',
      'empEntrega.apellidos as apellidosEmpleadoEntrega', 'empRecibe.nombre as nombreEmpleadoRecibe', 
      'empRecibe.apellidos as apellidosEmpleadoRecibe' , 'empresas_ceprozac.nombre as nombreEmpresa')
     ->get();

     return view('almacen.agroquimicos.entradas.index', ["entrada"=>$entrada,
      "errorEmpleado"=>$errorEmpleado,
      "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]);



        //
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {

      $entrada= DB::table('entradasagroquimicos')->where('entradasagroquimicos.estado','=','Activo')
      ->join('provedor_materiales','entradasagroquimicos.provedor','=', 'provedor_materiales.id')
      ->join('empresas_ceprozac', 'entradasagroquimicos.comprador','=', 'empresas_ceprozac.id')
      ->join('empleados as empEntrega', 'entradasagroquimicos.entregado','=', 'empEntrega.id')
      ->join('empleados as empRecibe', 'entradasagroquimicos.recibe_alm','=', 'empRecibe.id')
      ->select('entradasagroquimicos.id as idEntradaAgroquimicos', 'entradasagroquimicos.fecha',
        'entradasagroquimicos.factura', 'entradasagroquimicos.moneda', 'entradasagroquimicos.observacionesc',
        'entradasagroquimicos.estado as estadoEntrada','empEntrega.nombre as nombreEmpleadoEntrega',
        'empEntrega.apellidos as apellidosEmpleadoEntrega', 'empRecibe.nombre as nombreEmpleadoRecibe', 
        'empRecibe.apellidos as apellidosEmpleadoRecibe' , 'empresas_ceprozac.nombre as nombreEmpresa')
      ->get();
      $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
      $provedor = DB::table('provedores_tipo_provedor')
      ->join('provedor_materiales as p', 'provedores_tipo_provedor.idProvedorMaterial', '=', 'p.id')
      ->select('p.*','p.nombre as nombre')
      ->where('provedores_tipo_provedor.idTipoProvedor','2')->get();
      $unidades  = DB::table('unidades_medidas')
      ->join('nombre_unidades_medidas', 'unidades_medidas.idUnidadMedida', '=', 'nombre_unidades_medidas.id')
      ->select('unidades_medidas.id as idContenedorUnidadMedida','unidades_medidas.nombre','unidades_medidas.cantidad', 'unidades_medidas.idUnidadMedida', 'nombre_unidades_medidas.*')
      ->where('estado', '=', 'Activo')
      ->get();
      $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();
      $material=DB::table('almacenagroquimicos')->where('almacenagroquimicos.estado','=' ,'Activo')
      ->where('almacenagroquimicos.cantidad','>=','0')
      ->join('unidades_medidas as u', 'almacenagroquimicos.idUnidadMedida', '=', 'u.id')
      ->select('u.idUnidadMedida')
      ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
      ->select('almacenagroquimicos.id as idAgroquimico','almacenagroquimicos.nombre as nombreAgroquimico',
        'almacenagroquimicos.imagen','almacenagroquimicos.descripcion',
        'almacenagroquimicos.stock_minimo','almacenagroquimicos.idUnidadMedida',
        'u.nombre as nombreUnidad','n.nombreUnidadMedida as NombreUnidadP','u.cantidad as cantidadMedida')->get();
      

      if (empty($material) && empty($empleado) && empty($provedor)){

        $errorProveedor="Registrar proveedores para poder continuar.";
        $errorMaterial="Registrar agroquímicos para poder continuar";
        $errorEmpleado="Registrar empleados almacenista para poder continuar";

        return view('/almacen/agroquimicos/entradas/index',["entrada"=>$entrada,"errorEmpleado"=>$errorEmpleado,
          "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]);



      }else if (empty($material)  && empty($provedor)) {

        $errorProveedor="Registrar proveedores para poder continuar.";
        $errorMaterial="Registrar agroquímicos para poder continuar";
        $errorEmpleado="";
        return view('/almacen/agroquimicos/entradas/index',["entrada"=>$entrada,"errorEmpleado"=>$errorEmpleado,
          "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]);


      }  else if (empty($material) && empty($empleado)) {

        $errorProveedor="";
        $errorMaterial="Registrar agroquímicos para poder continuar";
        $errorEmpleado="Registrar empleados almacenista para poder continuar";
        return view('/almacen/agroquimicos/entradas/index',["entrada"=>$entrada,"errorEmpleado"=>$errorEmpleado,
          "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]); 

      } else if (empty($material)) {

       $errorProveedor="";
       $errorMaterial="Registrar agroquímicos para poder continuar";
       $errorEmpleado="";

       return view('/almacen/agroquimicos/entradas/index',["entrada"=>$entrada,"errorEmpleado"=>$errorEmpleado,
        "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]);

     } else if (empty($empleado)) {

      $errorProveedor="";
      $errorMaterial="";
      $errorEmpleado="Registrar empleados almacenista para poder continuar";

      return view('/almacen/agroquimicos/entradas/index',["entrada"=>$entrada,"errorEmpleado"=>$errorEmpleado,
        "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]);

    }else if (empty($provedor)){

     $errorProveedor="Registrar proveedores para poder continuar.";
     $errorMaterial="";
     $errorEmpleado="";
     return view('/almacen/agroquimicos/entradas/index',["entrada"=>$entrada,"errorEmpleado"=>$errorEmpleado,
      "errorProveedor"=>$errorProveedor,"errorMaterial"=>$errorMaterial]);
   }
   else{
    return view("almacen.agroquimicos.entradas.create",["entrada"=>$entrada,"material"=>$material,"provedor"=>$provedor],["empleado"=>$empleado,"empresas"=>$empresas,"unidades"=>$unidades]);

  }
        //
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(EntradasAgroquimicosRequest $formulario)
    {

      DB::beginTransaction();
      $datosGeneralesEntradaAgroquimico= new EntradasAgroquimicos;
      $datosGeneralesEntradaAgroquimico->factura=$formulario->get('numeroFactura');
      $datosGeneralesEntradaAgroquimico->fecha=$formulario->get('fechaCompra');
      $datosGeneralesEntradaAgroquimico->provedor=$formulario->get('provedor');
      $datosGeneralesEntradaAgroquimico->fecha=$formulario->get('fechaCompra');
      $datosGeneralesEntradaAgroquimico->comprador=$formulario->get('empresaEncargadaCompra');
      $datosGeneralesEntradaAgroquimico->moneda=$formulario->get('tipoMoneda');
      $datosGeneralesEntradaAgroquimico->entregado=$formulario->get('empleadoEntrega');
      $datosGeneralesEntradaAgroquimico->recibe_alm=$formulario->get('empleadoRecibe');
      $datosGeneralesEntradaAgroquimico->observacionesc=$formulario->get('observaciones');
      $datosGeneralesEntradaAgroquimico->estado="Activo";
      $datosGeneralesEntradaAgroquimico->save();

      $idEntradaAgroquimicos = $datosGeneralesEntradaAgroquimico->id;
      $idMaterial= $formulario->get('idMaterial');
      $cantidad = $formulario->get('cantidadTotal');
      $p_unitario= $formulario->get('precioUnitario');
      $iva=$formulario->get('iva');
      $ieps=$formulario->get('ieps');
      $subTotal=$formulario->get('subTotal');
      $cont = 0;
      while($cont < count($idMaterial))
      {
        $agroquimicos= new DetallesEntradasAgroquimicos;
        $agroquimicos->idEntradaAgroquimicos=$idEntradaAgroquimicos;
        $agroquimicos->id_material=$idMaterial[$cont];
        $agroquimicos->cantidad=$cantidad[$cont];
        $agroquimicos->p_unitario=$p_unitario[$cont];
        $agroquimicos->iva=$iva[$cont];
        $agroquimicos->ieps=$ieps[$cont];
        $agroquimicos->subTotal=$subTotal[$cont];
        $cont = $cont+1;
        $agroquimicos->save();
      }


      DB::commit();

      return redirect('/almacen/entradasagroquimicos');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($factura)
    {


     $material=DB::table('almacenagroquimicos')->where('almacenagroquimicos.estado','=' ,'Activo')->where('almacenagroquimicos.cantidad','>=','0')
     ->join('unidades_medidas as u', 'almacenagroquimicos.idUnidadMedida', '=', 'u.id')
     ->select('u.idUnidadMedida')
     ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
     ->select('almacenagroquimicos.*','u.nombre as nombreUnidad','n.nombreUnidadMedida as NombreUnidadP','u.cantidad as cantidadMedida')->get();

     $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
     $provedor = DB::table('provedores_tipo_provedor')
     ->join('provedor_materiales as p', 'provedores_tipo_provedor.idProvedorMaterial', '=', 'p.id')
     ->select('p.*','p.nombre as nombre')
     ->where('provedores_tipo_provedor.idTipoProvedor','2')->get();
     $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();


     $entradas=DB::table('detalles_entradas_agroquimicos')
     ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
     ->select('a.idUnidadMedida')
     ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
     ->select('u.idUnidadMedida')
     ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
     ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
     ->select('detalles_entradas_agroquimicos.*','e.*','a.nombre as nombreMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida','u.nombre as UnidadNombre')
     ->where('e.factura','=',$factura)->get(); 


     $entrada=DB::table('detalles_entradas_agroquimicos')
     ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
     ->select('a.idUnidadMedida')
     ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
     ->select('u.idUnidadMedida')
     ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
     ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
     ->select('detalles_entradas_agroquimicos.*','e.*','a.nombre as nombreMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida')
     ->where('e.factura','=',$factura)->first(); 

        // 
     return view('almacen.agroquimicos.entradas.edit', ['entrada'=>$entrada,'empleado' => $empleado,'entradas'=> $entradas,'material'=>$material,'provedor'=>$provedor,'empresas'=>$empresas]);
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


      return redirect('/almacen/entradas/agroquimicos');
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


     $entradas=DB::table('detalles_entradas_agroquimicos')
     ->where('idEntradaAgroquimicos','=',$id)->get(); 
     $cuenta = count($entradas);
     for ($x=0; $x < $cuenta  ; $x++) {
      $elimina = DetallesEntradasAgroquimicos::findOrFail($entradas[$x]->id);
      $decrementa=almacenagroquimicos::findOrFail($elimina->id_material);
      $decrementa->cantidad=$decrementa->cantidad- $elimina->cantidad;
      $decrementa->update();
        //$elimina->delete();PENDIENTE CHECAR SI SE ELIMINA O SE QUEDA
        # code...
    }
    $entrada = entradasagroquimicos::findOrFail($id);
    $entrada->estado="Inactivo";
    $entrada->update();


    return Redirect::to('/almacen/entradas/agroquimicos');   
        //
  }


  public function excel()
  {         
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('entradasagroquimicos', function($excel) {
          $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
           $entrada=DetallesEntradasAgroquimicos::
           join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
           ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
           ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
           ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
           ->join('provedor_materiales as prov', 'e.provedor', '=', 'prov.id')
           ->join('empresas_ceprozac as emp', 'e.comprador', '=', 'emp.id')
           ->join('empleados as Empleado1', 'e.entregado', '=', 'Empleado1.id')
           ->join('empleados as Empleado2', 'e.entregado', '=', 'Empleado2.id')
           ->select('detalles_entradas_agroquimicos.idEntradaAgroquimicos as IdEntrada','a.nombre as nombreMaterial','detalles_entradas_agroquimicos.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida','emp.nombre as empresaNombre','prov.nombre as NombreProvedor','e.factura','detalles_entradas_agroquimicos.p_unitario','detalles_entradas_agroquimicos.iva','detalles_entradas_agroquimicos.ieps','e.moneda','e.fecha as FechaCompra','Empleado1.nombre as NombreEmp1','Empleado1.apellidos as Ape1','Empleado2.nombre','Empleado2.apellidos','e.observacionesc as Observaciónes Observa')->get();       
           $sheet->fromArray($entrada);
           $sheet->row(1,['N°Compra','Material','Cantidad','Medida' ,'Comprador','Proveedor','Numero de Factura','Precio Unitario','IVA','IEPS','Tipo de Moneda','Fecha de Compra',"Entrego","Apellidos","Recibe en Almacén CEPROZAC","Apellidos",'Observaciónes de la Compra']);
           $sheet->setOrientation('landscape');
         });
        })->export('xls');
      }


      public function show(EntradasAgroquimicosRequest $formulario,$factura)
      {
        $material=DB::table('almacenagroquimicos')->where('almacenagroquimicos.estado','=' ,'Activo')->where('almacenagroquimicos.cantidad','>=','0')
        ->join('unidades_medidas as u', 'almacenagroquimicos.idUnidadMedida', '=', 'u.id')
        ->select('u.idUnidadMedida')
        ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
        ->select('almacenagroquimicos.*','u.nombre as nombreUnidad','n.nombreUnidadMedida as NombreUnidadP','u.cantidad as cantidadMedida')->get();

        $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
        $provedor = DB::table('provedores_tipo_provedor')
        ->join('provedor_materiales as p', 'provedores_tipo_provedor.idProvedorMaterial', '=', 'p.id')
        ->select('p.*','p.nombre as nombre')
        ->where('provedores_tipo_provedor.idTipoProvedor','2')->get();
        $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();


        $entradas=DB::table('detalles_entradas_agroquimicos')
        ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
        ->select('a.idUnidadMedida')
        ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
        ->select('u.idUnidadMedida')
        ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
        ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
        ->select('detalles_entradas_agroquimicos.*','e.*','a.nombre as nombreMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida','u.nombre as UnidadNombre')
        ->where('e.factura','=',$factura)->get(); 


        $entrada=DB::table('detalles_entradas_agroquimicos')
        ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
        ->select('a.idUnidadMedida')
        ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
        ->select('u.idUnidadMedida')
        ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
        ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
        ->select('detalles_entradas_agroquimicos.*','e.*','a.nombre as nombreMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida')
        ->where('e.factura','=',$factura)->first(); 

        // 
        return view('almacen.agroquimicos.entradas.edit', ['entrada'=>$entrada,'empleado' => $empleado,'entradas'=> $entradas,'material'=>$material,'provedor'=>$provedor,'empresas'=>$empresas]);


        // return redirect('/almacen/entradas/agroquimicos');
        //
      }



      public function CALCULA_TOTAL($id){


      }


      public function pdfentradaAgroquimicos($id) 
      {

       $data2 =DB::table('detalles_entradas_agroquimicos')
       ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
       ->select('a.idUnidadMedida')
       ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
       ->select('u.idUnidadMedida')
       ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
       ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
       ->select('detalles_entradas_agroquimicos.*','e.*','a.nombre as nombreMaterial','a.id as idMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida','u.nombre as UnidadNombre')
       ->where('e.factura','=',$id)->get();

       $entrada=DB::table('detalles_entradas_agroquimicos')
       ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
       ->select('a.idUnidadMedida')
       ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
       ->select('u.idUnidadMedida')
       ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
       ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
       ->select('e.comprador', 'e.entregado','e.recibe_alm','e.provedor')
       ->join('empresas_ceprozac as emp', 'e.comprador', '=', 'emp.id')
       ->join('empleados as empleado', 'e.entregado', '=', 'empleado.id')
       ->join('empleados as empleado2', 'e.recibe_alm', '=', 'empleado2.id')
       ->join('provedor_materiales as prov', 'e.provedor', '=', 'prov.id')
       ->select('detalles_entradas_agroquimicos.*','e.*','a.nombre as nombreMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida','emp.nombre as empresaNombre','empleado.nombre as nombre1','empleado.apellidos as apellido1','empleado2.nombre as nombre2','empleado2.apellidos as apellido2','prov.nombre as ProvedorNombre','prov.direccion as ProvedorDireccion','prov.telefono as ProvedorTelefono','prov.email as ProvedorEmail')
       ->where('e.factura','=',$id)->first(); 

       $date = date('Y-m-d');
       $invoice = "2222";
       $view =  \View::make('almacen.agroquimicos.entradas.invoice', compact('date', 'invoice','entrada','data2'))->render();
       $pdf = \App::make('dompdf.wrapper');
       $pdf->loadHTML($view);
       return $pdf->stream('invoice');
     }

     public function verEntradaAgroquimicos($id){
      $data2 =DB::table('detalles_entradas_agroquimicos')
      ->join('almacenagroquimicos as a', 'detalles_entradas_agroquimicos.id_material', '=', 'a.id')
      ->select('a.idUnidadMedida')
      ->join('unidades_medidas as u', 'a.idUnidadMedida', '=', 'u.id')
      ->select('u.idUnidadMedida')
      ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
      ->join('entradasagroquimicos as e', 'detalles_entradas_agroquimicos.idEntradaAgroquimicos', '=', 'e.id')
      ->select('detalles_entradas_agroquimicos.id as idDetalleEntrada','detalles_entradas_agroquimicos.idEntradaAgroquimicos',
        'detalles_entradas_agroquimicos.id_material','detalles_entradas_agroquimicos.cantidad',
        'detalles_entradas_agroquimicos.p_unitario', 'detalles_entradas_agroquimicos.iva',
        'detalles_entradas_agroquimicos.ieps','detalles_entradas_agroquimicos.subTotal'
        ,'e.id as idEntradaAgroquimicos','a.nombre as nombreMaterial','a.id as idMaterial','u.cantidad as cantidadUnidad','n.nombreUnidadMedida as nombreUnidadMedida','u.nombre as UnidadNombre')
      ->where('e.id','=',$id)->get();

      $entrada= DB::table('entradasagroquimicos')->where('entradasagroquimicos.estado','=','Activo')
      ->join('provedor_materiales','entradasagroquimicos.provedor','=', 'provedor_materiales.id')
      ->join('empresas_ceprozac', 'entradasagroquimicos.comprador','=', 'empresas_ceprozac.id')
      ->join('empleados as empEntrega', 'entradasagroquimicos.entregado','=', 'empEntrega.id')
      ->join('empleados as empRecibe', 'entradasagroquimicos.recibe_alm','=', 'empRecibe.id')
      ->select('entradasagroquimicos.id as idEntradaAgroquimicos', 'entradasagroquimicos.fecha',
        'entradasagroquimicos.factura', 'entradasagroquimicos.moneda', 'entradasagroquimicos.observacionesc',
        'entradasagroquimicos.estado as estadoEntrada','empEntrega.nombre as nombreEmpleadoEntrega',
        'empEntrega.apellidos as apellidosEmpleadoEntrega', 'empRecibe.nombre as nombreEmpleadoRecibe', 
        'empRecibe.apellidos as apellidosEmpleadoRecibe' , 'empresas_ceprozac.nombre as nombreEmpresa', 'provedor_materiales.nombre as ProvedorNombre')
      ->where('entradasagroquimicos.id', '=', $id)
      ->first();

      return view("almacen.agroquimicos.entradas.reporte",["data2"=>$data2,'entrada'=>$entrada]);

    }


    public function calcularCantidadAlmacen($id){
      $entrada=DetallesEntradasAgroquimicos::findOrFail($id);
      $idMaterial=$entrada->id_material;
      $material=AlmacenAgroquimicos::findOrFail($idMaterial);
      $idUnidadMedida = $material->idUnidadMedida;
      $unidad_medida  = $this->propiedadesUnidadMedida($idUnidadMedida);
      $cantidadAlmacen=$entrada->cantidad;
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

      $entrada=DetallesEntradasAgroquimicos::findOrFail($id);
      $idMaterial=$entrada->id_material;
      $material=AlmacenAgroquimicos::findOrFail($idMaterial);
      $idUnidadMedida = $material->idUnidadMedida;
      $unidad_medida  =  $this->propiedadesUnidadMedida($idUnidadMedida);
      $cantidadAlmacen=$entrada->cantidad;
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


   $entrada=DetallesEntradasAgroquimicos::findOrFail($id);
   $idMaterial=$entrada->id_material;
   $material=AlmacenAgroquimicos::findOrFail($idMaterial);
   $idUnidadMedida = $material->idUnidadMedida;
   $unidad_medida  = $this->propiedadesUnidadMedida($idUnidadMedida);
   $cantidadAlmacen=$entrada->cantidad;
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


public function calcularImporte($precioUnitario,$cantidad,$unidadNombre
  ,$cantidadContenidadxUnidadMedida,$unidadDeMedida){
  if($unidadDeMedida == "LITROS"){
    $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
    $precioUnidadMinima= $precio_x_UnidadMedida/1000;
    $importe = $cantidad*$precioUnidadMinima;
    return $importe;
  }
  elseif ($unidadDeMedida =="KILOGRAMOS") {
   $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
   $precioUnidadMinima= $precio_x_UnidadMedida/1000;
   $importe = $cantidad*$precioUnidadMinima;
   return $importe;
 }
 elseif ($unidadDeMedida=="METROS") {
  $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
  $precioUnidadMinima= $precio_x_UnidadMedida/100;
  $importe = $cantidad*$precioUnidadMinima;
  return $importe;

}
elseif($unidadDeMedida=="UNIDADES"){
 $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
 $precioUnidadMinima= $precio_x_UnidadMedida/1000;
 $importe = $cantidad*$precioUnidadMinima;
 return $importe;
}   

elseif($unidadDeMedida=="MILILITROS"){
 $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
 $precioUnidadMinima= $precio_x_UnidadMedida/1000;
 $importe = $cantidad*$precioUnidadMinima;
 return $importe;
} 

elseif($unidadDeMedida=="CENTIMETROS"){
 $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
 $precioUnidadMinima= $precio_x_UnidadMedida/1000;
 $importe = $cantidad*$precioUnidadMinima;
 return $importe;
} 
elseif($unidadDeMedida=="GRAMOS"){
 $precio_x_UnidadMedida= $precioUnitario/$cantidadContenidadxUnidadMedida;
 $precioUnidadMinima= $precio_x_UnidadMedida/1000;
 $importe = $cantidad*$precioUnidadMinima;
 return $importe;
} 



return $precioUnitario.' '.$cantidad.' '.$unidadNombre;

}

public function labelUnidadMedidaMinima($id){



  $entrada=DetallesEntradasAgroquimicos::findOrFail($id);
  $idMaterial=$entrada->id_material;
  $material=AlmacenAgroquimicos::findOrFail($idMaterial);
  $idUnidadMedida = $material->idUnidadMedida;
  $unidad_medida  = $this->propiedadesUnidadMedida($idUnidadMedida);
  $cantidadAlmacen=$entrada->cantidad;
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


public function calculoIVA($importe,$iva){
  $ivaPagado=$importe*($iva/100);
  return $ivaPagado;

}


public function calculoIEPS($importe,$ieps){
  $iepsPagado=$importe*($ieps/100);
  return $iepsPagado;

}

public function calcularSubTotal($iva,$ieps,$importe){
  return $iva+$ieps+$importe;
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



public function validarNumeroFactura($numeroFactura)
{
  $factura= EntradasAgroquimicos::
  select('id as idFactura','factura','estado')
  ->where('factura','=',$numeroFactura)
  ->get();
  return response()->json(
    $factura->toArray());
}

}