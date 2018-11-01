<?php

namespace CEPROZAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CEPROZAC\Http\Requests;
use CEPROZAC\Http\Requests\EntradasMaterialesRequest;
use CEPROZAC\Http\Controllers\Controller;
use CEPROZAC\EntradaAlmacen;
use CEPROZAC\Empleado;
use CEPROZAC\AlmacenLimpieza;
use CEPROZAC\ProvedorMateriales;
use CEPROZAC\Empresas_Ceprozac;

use CEPROZAC\Unidades_Medida;



use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use Validator; 
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Collection as Collection;

class EntradaAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
 
     */ 
    public function index()
    {
      $entrada= DB::table('entradasalmacenmateriales')->where('entradasalmacenmateriales.estado','=','Activo')
      ->join('provedor_materiales','entradasalmacenmateriales.provedor','=', 'provedor_materiales.id')
      ->join('empresas_ceprozac', 'entradasalmacenmateriales.comprador','=', 'empresas_ceprozac.id')
      ->join('empleados as empEntrega', 'entradasalmacenmateriales.entregado','=', 'empEntrega.id')
      ->join('empleados as empRecibe', 'entradasalmacenmateriales.recibe_alm','=', 'empRecibe.id')
      ->select('entradasalmacenmateriales.id as idEntradaMateriales', 'entradasalmacenmateriales.fecha',
        'entradasalmacenmateriales.factura', 'entradasalmacenmateriales.moneda', 'entradasalmacenmateriales.observacionesc',
        'entradasalmacenmateriales.estado as estadoEntrada','empEntrega.nombre as nombreEmpleadoEntrega',
        'empEntrega.apellidos as apellidosEmpleadoEntrega', 'empRecibe.nombre as nombreEmpleadoRecibe', 
        'empRecibe.apellidos as apellidosEmpleadoRecibe' , 'empresas_ceprozac.nombre as nombreEmpresa')
      ->get();

      return view('almacen.limpieza.entradas.index', ['entrada' => $entrada]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
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
      $material=DB::table('almacenmateriales')->where('almacenmateriales.estado','=' ,'Activo')
      ->where('almacenmateriales.cantidad','>=','0')
      ->join('unidades_medidas as u', 'almacenmateriales.idUnidadMedida', '=', 'u.id')
      ->select('u.idUnidadMedida')
      ->join('nombre_unidades_medidas as n', 'u.idUnidadMedida', '=', 'n.id')
      ->select('almacenmateriales.id as idMateriales','almacenmateriales.nombre as nombreMateriales',
        'almacenmateriales.imagen','almacenmateriales.descripcion',
        'almacenmateriales.stock_minimo','almacenmateriales.idUnidadMedida',
        'u.nombre as nombreUnidad','n.nombreUnidadMedida as NombreUnidadP','u.cantidad as cantidadMedida')->get();
      

      $cuenta = count($material);

      if (empty($material)){

        return redirect('/almacen/entradas/materiales')->with('info', 'Para poder registrar una entrada de materiales/refacciones, verifica que el sistema ya cuante con datos de proveedores de materiales, productos de materiales y empleados almacenistas');

         // return view("almacen.materiales.salidas.create")->with('message', 'No Hay Material Registrado, Favor de Dar de Alta Material Para Poder Acceder a Este Modulo');
      }else if (empty($empleado)) {
        return redirect('/almacen/entradas/materiales');


      }else if (empty($provedor)){
        return redirect('/almacen/entradas/materiales');


      }
      else{
        return view("almacen.materiales.entradas.create",["material"=>$material,"provedor"=>$provedor],["empleado"=>$empleado,"empresas"=>$empresas,"unidades"=>$unidades]);

      }
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /*
    public function store(EntradasMaterialesRequest $formulario)
    {
      $cantidad = $formulario->get('cantidad2');

      if ($cantidad > 0){
        $validator = Validator::make(
          $formulario->all(), 
          $formulario->rules(),
          $formulario->messages());
        if ($validator->valid()){

          if ($formulario->ajax()){
            return response()->json(["valid" => true], 200);
          }
          else{
            $material= new almacenmaterial;

            $material->nombre=$formulario->get('nombre2');
            $material->provedor=$formulario->get('provedor_id2');


        if (Input::hasFile('imagen')){ //validar la imagen, si (llamanos clase input y la funcion hash_file(si tiene algun archivo))
            $file=Input::file('imagen');//si pasa la condicion almacena la imagen
            $file->move(public_path().'/imagenes/almacenmaterial',$file->getClientOriginalName());//lo movemos a esta ruta                        
            $material->imagen=$file->getClientOriginalName();
          }
          $material->descripcion=$formulario->get('descripcion2');
          $material->cantidad="0";
          $material->medida=$formulario->get('medida');
          $material->codigo=$formulario->get('codigo');
          $material->estado='Activo';
          $material->save();
        }
      }

      $ultimo = almacenmaterial::orderBy('id', 'desc')->first()->id;
      $ex = $formulario->get('provedor_id2');
      $materiales = DB::table('provedor_materiales')
      ->select('provedor_materiales.nombre')
      ->where('provedor_materiales.id',$ex)->get();

      $provedornombre = $materiales[0]->nombre;
      $material2= new entradaalmacen;
      $material2->id_material=$ultimo;
      $material2->cantidad=$formulario->get('cantidad2');
      $material2->provedor=$provedornombre;
      $material2->comprador=$formulario->get('recibio2');
      $material2->entregado=$formulario->get('entregado_a');
      $material2->recibe_alm=$formulario->get('recibe_alm');
      $material2->observacionesc=$formulario->get('observaciones');
      
      $material2->factura=$formulario->get('factura2');
      $material2->fecha=$formulario->get('fecha2');
      $material2->p_unitario=$formulario->get('preciou2');
      $material2->total= $material2->p_unitario *  $material2->cantidad;
      $material2->importe= $material2->p_unitario *  $material2->cantidad;
      $material2->save();

      $material= DB::table('almacenmaterial')->orderby('created_at','DESC')->take(1)->get();
$date = date('Y-m-d');
$invoice = "2222";
$view =  \View::make('almacen.limpieza.invoice', compact('date', 'invoice','material'))->render();
$pdf = \App::make('dompdf.wrapper');
$pdf->loadHTML($view);
return $pdf->stream('invoice');


           // print_r($cantidad);
    }else{
      $num = 1;
      $y = 0;
      $limite = $formulario->get('total');
   //print_r($limite);

      while ($num <= $limite) {
        $material= new entradaalmacen;
        $unidad = new cantidad_unidades_mate;
            //print_r($num);
        $producto = $formulario->get('codigo2');
        $first = head($producto);
        $name = explode(",",$first);
            //print_r($producto);
            //$first = $name[0]; 
             //$first = $name[1];
        
        $material->id_material=$first = $name[$y];
        $prod=$first = $name[$y];
        $unidad->idProducto=$first = $name[$y];
        $y = $y + 2;
        $aux =$first = $name[$y];
        $unidad->cantidad=$first = $name[$y];
        //$material->cantidad=$first = $name[$y];
        $y = $y + 1;
        $aux2 =$first = $name[$y];
        $medida2= unidadesmedida::where('nombre','=',$aux2)->first()->id;
        $unidad->estado="Activo";
        $unidad->idMedida=$medida2;
        ///si ya exixste//
        $comprueba2= DB::table('cantidad_unidades_mate')->where('idMedida','=',$medida2)->where('idProducto','=',$prod)->get();
        $r=count($comprueba2);
        if ($r > 0){
          $unidadaux=cantidad_unidades_mate::where('idProducto','=',$prod)->where('idMedida','=',$medida2)->first()->id;
          $unidad2=cantidad_unidades_mate::findOrFail($unidadaux);
          $unidad2->cantidad=$unidad2->cantidad + $aux;
          $unidad2->update();
        }else{
          $unidad->save();
        }



        /////

        
        $concat = $aux." ".$aux2;
        $y = $y + 1;
            // print_r($first = $name[$y]);
             //print_r($first = $name[$y]);
        $yy =$first = $name[$y]; 
        $producto2 = $yy;
        $name2 = explode(" ",$producto2);
        $material->cantidad= $name2[0];

        $material->medida= $name2[1];
        $material->medidaaux=$concat;

        $y = $y + 1;
        $material->nota_venta=$first = $name[$y];
        $y = $y + 1;
             //print_r($first = $name[$y]);
            // print_r($first = $name[$y]);
        $material->p_unitario=$first = $name[$y];
        $y = $y + 1;
        $material->iva=$first = $name[$y];
        $y = $y + 1;
        $material->total=$first = $name[$y];
        $material->importe=$first = $name[$y];
        $y = $y + 1;
        $material->estado="Activo";
        $material->provedor=$formulario->get('prov');
        $material->comprador=$formulario->get('recibio');
        $material->entregado=$formulario->get('entregado_a');
        $material->recibe_alm=$formulario->get('recibe_alm');
        $material->observacionesc=$formulario->get('observacionesm');
        $material->fecha=$formulario->get('fecha');
        $material->moneda=$formulario->get('moneda');
        $material->save();
        $num = $num + 1;

      }
      return redirect('/almacen/entradas/materiales');




        //
    }
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
    public function show($id)
    {
      $unidades= DB::table('unidadesmedida')->where('estado','Activo')->get();
      $entradas=DB::table('entradaalmacenmateriales')->where('nota_venta','=',$id)->get();
      $entrada = entradaalmacen::findOrFail($entradas[0]->id);
      $fac=$entrada->nota_venta;
      $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
      $entradas=DB::table('entradaalmacenmateriales')->where('nota_venta','=',$fac)
      ->join('almacenmateriales as a', 'entradaalmacenmateriales.id_material', '=', 'a.id')
      ->select('entradaalmacenmateriales.*','a.nombre as nombremat','a.id as idagro')->get();


      $material=DB::table('almacenmateriales')->join('almacengeneral as alma','almacenmateriales.ubicacion', '=', 'alma.id')
      ->select('almacenmateriales.*','alma.nombre as ubicacion')->where('almacenmateriales.estado','=' ,'Activo')->where('almacenmateriales.cantidad','>=','0')->get();
      $provedor = DB::table('provedores_tipo_provedor')
      ->join('provedor_materiales as p', 'provedores_tipo_provedor.idProvedorMaterial', '=', 'p.id')
      ->select('p.*','p.nombre as nombre')
      ->where('provedores_tipo_provedor.idTipoProvedor','1')->get();
      $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();
        // 
      return view('almacen.materiales.entradas.edit', ['entrada' => $entrada,'empleado' => $empleado,'entradas'=> $entradas,'material'=>$material,'provedor'=>$provedor,'empresas'=>$empresas,'unidades'=>$unidades]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
    public function edit($id)
    {
     $entrada = entradaalmacen::findOrFail($id);
     $fac=$entrada->nota_venta;
     $empleado=DB::table('empleados')->where('estado','=' ,'Activo')->get();
     $entradas=DB::table('entradaalmacenmateriales')->where('nota_venta','=',$fac)
     ->join('almacenmateriales as a', 'entradaalmacenmateriales.id_material', '=', 'a.id')
     ->select('entradaalmacenmateriales.*','a.nombre as nombremat','a.id as idagro')->get();


     $material=DB::table('almacenmateriales')->join('almacengeneral as alma','almacenmateriales.ubicacion', '=', 'alma.id')
     ->select('almacenmateriales.*','alma.nombre as ubicacion')->where('almacenmateriales.estado','=' ,'Activo')->where('almacenmateriales.cantidad','>=','0')->get();
     $provedor = DB::table('provedores_tipo_provedor')
     ->join('provedor_materiales as p', 'provedores_tipo_provedor.idProvedorMaterial', '=', 'p.id')
     ->select('p.*','p.nombre as nombre')
     ->where('provedores_tipo_provedor.idTipoProvedor','1')->get();
     $empresas=DB::table('empresas_ceprozac')->where('estado','=' ,'Activo')->get();
     $unidades= DB::table('unidadesmedida')->where('estado','Activo')->get();
        // 
     return view('almacen.materiales.entradas.edit', ['entrada' => $entrada,'empleado' => $empleado,'entradas'=> $entradas,'material'=>$material,'provedor'=>$provedor,'empresas'=>$empresas,'unidades'=>$unidades]);
        //
        //
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
    public function update(Request $request, $id)
    {
     $entrada = entradaalmacen::findOrFail($id);
     $fac=$entrada->nota_venta;
     $entradas=DB::table('entradaalmacenmateriales')->where('nota_venta','=',$fac)->get();
     $cuenta = count($entradas);

     for ($x=0; $x < $cuenta  ; $x++) {
      $elimina = entradaalmacen::findOrFail($entradas[$x]->id);
      $decrementa=almacenmaterial::findOrFail($elimina->id_material);
      $decrementa->cantidad=$decrementa->cantidad- $elimina->cantidad;
      $v= [$elimina->medidaaux];
      $first = head($v);
      $name = explode(" ",$first);
      $z = count($name);
      $a="";
      for ($i=0; $i < $z; $i++) { 
        if ($i == 1) {
         $a=$name[$i];             
            # code...
       }else if($i > 1) {
        $a=$a." ".$name[$i];
      }else{
        $r=$name[0];
      }
          # code...
    }
//print_r($e[0]);
    $medida2= unidadesmedida::where('nombre','=',$a)->first()->id;
    $unidadaux=cantidad_unidades_mate::where('idProducto','=',$decrementa->id)->where('idMedida','=',$medida2)->first()->id;
    $unidad=cantidad_unidades_mate::findOrFail($unidadaux);
    $unidad->cantidad=$unidad->cantidad - $r;
    $unidad->update();      
    $decrementa->update();
    $elimina->delete();
        # code...
  }
     // $salidas->delete();
  $num = 1;
  $y = 0;
  $limite = $request->get('total');

  while ($num <= $limite) {
    $material= new entradaalmacen;
    $unidad = new cantidad_unidades_mate;

    $producto = $request->get('codigo2');
    $first = head($producto);
    $name = explode(",",$first);
            //$first = $name[0];
             //$first = $name[1];

    $material->id_material=$first = $name[$y];
    $prod=$first = $name[$y];
    $unidad->idProducto=$first = $name[$y];
    $y = $y + 2;
    $aux =$first = $name[$y];
    $unidad->cantidad=$first = $name[$y];
      //$material->cantidad=$first = $name[$y];
    $y = $y + 1;
    $aux2 =$first = $name[$y];
    $medida2= unidadesmedida::where('nombre','=',$aux2)->first()->id;
    $unidad->estado="Activo";
    $unidad->idMedida=$medida2;
        ///si ya exixste//
    $comprueba2= DB::table('cantidad_unidades_mate')->where('idMedida','=',$medida2)->where('idProducto','=',$prod)->get();
    $r=count($comprueba2);
    if ($r > 0){
      $unidadaux=cantidad_unidades_mate::where('idProducto','=',$prod)->where('idMedida','=',$medida2)->first()->id;
      $unidad2=cantidad_unidades_mate::findOrFail($unidadaux);
      $unidad2->cantidad=$unidad2->cantidad + $aux;
      $unidad2->update();
    }else{
      $unidad->save();
    }

    $concat = $aux." ".$aux2;
    $y = $y + 1;
    $yy =$first = $name[$y]; 
    $producto2 = $yy;
    $name2 = explode(" ",$producto2);
    $material->cantidad= $name2[0];

    $material->medida= $name2[1];
    $material->medidaaux=$concat;
    $y = $y + 1;
        //print_r($first = $name[$y]);

    $material->nota_venta=$first = $name[$y];
    $y = $y + 1;

    $material->fecha=$first = $name[$y];
    $y = $y + 1;

    $material->p_unitario=$first = $name[$y];
    $y = $y + 1;

    $material->iva=$first = $name[$y];
    $y = $y + 1;         
    $material->total=$first = $name[$y];
    $material->importe=$first = $name[$y];
    $y = $y + 1;
    $material->moneda=$first = $name[$y];
    $y = $y + 1;
    $material->entregado=$request->get('entregado_a');
    $material->recibe_alm=$request->get('recibe_alm');
    $material->observacionesc=$request->get('observacionesq');
    $material->provedor=$request->get('prov');
    $material->comprador=$request->get('recibio');
    $material->estado="Activo";
    $material->save();
    $num = $num + 1;
<<<<<<< HEAD
  
    $material->nota_venta=$first = $name[$y];
    $y = $y + 1;
    $material->p_unitario=$first = $name[$y];
    $y = $y + 1;

    $material->iva=$first = $name[$y];
    $y = $y + 1;         
    $material->total=$first = $name[$y];
    $material->importe=$first = $name[$y];
    $y = $y + 1;
    $material->entregado=$request->get('entregado_a');
    $material->recibe_alm=$request->get('recibe_alm');
    $material->observacionesc=$request->get('observacionesq');
    $material->provedor=$request->get('prov');
    $material->comprador=$request->get('recibio');
    $material->estado="Activo";
    $material->fecha=$request->get('fecha');
    $material->moneda=$request->get('moneda');
    $material->save();
    $num = $num + 1;

        //
  }
  return redirect('/almacen/entradas/materiales');
  
        //
}

        //
}

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

/*
public function destroy($id)
{
 $material=entradaalmacen::findOrFail($id);
 $material->estado="Inactivo";
 $decrementa=almacenmaterial::findOrFail($material->id_material);
 $decrementa->cantidad=$decrementa->cantidad- $material->cantidad;

 $v= [$material->medidaaux];
 $first = head($v);
 $name = explode(" ",$first);
 $z = count($name);
 $a="";
 for ($i=0; $i < $z; $i++) { 
  if ($i == 1) {
   $a=$name[$i];             
            # code...
   }else if($i > 1) {
    $a=$a." ".$name[$i];
    }else{
      $r=$name[0];
    }
          # code...
  }
//print_r($e[0]);
  $medida2= unidadesmedida::where('nombre','=',$a)->first()->id;
  $unidadaux=cantidad_unidades_mate::where('idProducto','=',$decrementa->id)->where('idMedida','=',$medida2)->first()->id;
  $unidad=cantidad_unidades_mate::findOrFail($unidadaux);
  $unidad->cantidad=$unidad->cantidad - $r;
  $unidad->update();      

  
  $decrementa->update();
  $material->update();
  return Redirect::to('/almacen/entradas/materiales');
        //
}


public function excel()
{        
  /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/

  /*
  Excel::create('entradaalmacenmateriales', function($excel) {
    $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
      $salidas = EntradaAlmacen::where('entradaalmacenmateriales.estado','=','Activo')->join('almacenmateriales','almacenmateriales.id', '=', 'entradaalmacenmateriales.id_material')->join('empleados as emp1', 'entradaalmacenmateriales.entregado', '=', 'emp1.id')
      ->join('empleados as emp2', 'entradaalmacenmateriales.recibe_alm', '=', 'emp2.id')
      ->join('empresas_ceprozac as e', 'entradaalmacenmateriales.comprador', '=', 'e.id')
      ->join('provedor_materiales as prov', 'entradaalmacenmateriales.provedor', '=', 'prov.id')
      ->select('entradaalmacenmateriales.id', 'almacenmateriales.nombre','entradaalmacenmateriales.medidaaux', 'entradaalmacenmateriales.cantidad','almacenmateriales.medida','prov.nombre as prov', 'entradaalmacenmateriales.nota_venta','entradaalmacenmateriales.p_unitario','entradaalmacenmateriales.iva','entradaalmacenmateriales.total','entradaalmacenmateriales.moneda','e.nombre as emp','entradaalmacenmateriales.fecha','emp1.nombre as empnom','emp1.apellidos as empapellidos','emp2.nombre as rec_alma','emp2.apellidos as apellidosrec','entradaalmacenmateriales.observacionesc')
      ->get();       
      $sheet->fromArray($salidas);
      $sheet->row(1,['N°Compra','Material','Cantidad','Cantidad Total','Medida' ,'Proveedor','Numero de Nota ó Factura','Precio Unitario','IVA','Subtotal','Tipo de Moneda','Comprador','Fecha de Compra',"Entrego","Apellidos","Recibe en Almacén CEPROZAC","Apellidos",'Observaciónes de la Compra']);
      $sheet->setOrientation('landscape');
      });
      })->export('xls');
    }
  }
  */
}
