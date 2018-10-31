@inject('metodo','CEPROZAC\Http\Controllers\AlmacenMaterialController')
@extends('layouts.principal')
@section('contenido')
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Almacén de Materiales</h1>
    <h2 class="">Almacén de Materiales</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/almacenes/materiales')}}">Inicio</a></li>
      <li class="active">Almacén de Material</a></li>
    </ol>
  </div>
</div>

<div class="container clear_both padding_fix">
  <div class="row">
    <div class="col-md-12">
      <div class="block-web">
        <div class="header">
          <div class="row" style="margin-top: 15px; margin-bottom: 12px;">
            <div class="col-sm-7">
              <div class="actions"> </div>
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Material </strong></h2>
            </div>
            <div class="col-md-12">
              <div class="btn-group pull-right">
                <b>
                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="{{route('almacen.materiales.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Material"> <i class="fa fa-plus"></i> Registrar Material </a>

                    <a class="btn btn-sm btn-warning tooltips" href="{{route('almacen.materiales.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                    <a class="btn btn-sm btn-danger"  href="{{route('almacen.materiales.salidas.index')}}"  style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i>Salidas de Almacén </a>

                    <a class="btn btn-sm btn btn-info" href="{{route('almacen.entradas.materiales.index')}}"  style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-plus"></i>Entradas de Almacén </a>
                  </div>
                </b>
                <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('factura')}}</div>
              </div>
            </div>
          </div>
        </div>

        <div class="porlets-content">
         <div class="table-responsive" style="overflow-x:auto;">
           <table  class="display table table-bordered table-striped" id="dynamic-table" style="width: 100%;">
            <thead>
              <tr >
               <th>Nombre </th>
               <th>Codigo de Barras </th>
               <th>Ubicacion</th>
               <th>Cantidad en Almacén 
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               </th>
               <th>Stock Minimo</th> 
               <th>Agregar Stock</th>


               <th>Ver</th>

               <td><center><b>Editar</b></center></td>
               <td><center><b>Borrar</b></center></td>                            
             </tr>
           </thead>
           <tbody>
            @foreach($material  as $materiales)
            <!--{{$completos=$metodo->calcularCantidadAlmacen($materiales->idMaterial)}} -->
            <!--{{$stockCompleto=$metodo->convertidorStockUnidadesMinimas_UnidadCentral($materiales->unidad_medida,$materiales->stock_minimo,$materiales->cantidadUnidadMedida)}}--> 
            @if( $completos <= $stockCompleto )
            <tr class="gradeA">


              <td style="background-color: #FFE4E1;">{{$materiales->nombre}} </td>

              @if (($materiales->codigo)!="")
              <td style="background-color: #FFE4E1;"><?php echo DNS1D::getBarcodeHTML("$materiales->codigo", "C128");?>
                <div style="text-align:center;" >
                  {{$materiales->codigo}}
                </div>
                <center>
                  <a href="{{URL::action('AlmacenMaterialController@invoice',$materiales->idMaterial)}}" class="btn btn-primary btn-sm" target="_blank" role="button"><i class="fa fa-print"></i></a> 
                </center>
              </td>
              @else
              <td style="background-color: #FFE4E1;">Codigo de Barras No Generado </td>

              @endif

              <td style="background-color: #FFE4E1;">{{$materiales->ubicacion}}</td>



              <td style="background-color: #FFE4E1;">

                <ul>
                  @if($materiales->unidad_medida== "KILOGRAMOS" || $materiales->unidad_medida== "LITROS" || $materiales->unidad_medida== "METROS" )
                  <li>

                    {{$metodo->calcularCantidadAlmacen($materiales->idMaterial)}} 
                    {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 

                  </li>
                  <li>

                    {{$metodo->calcularCantidadUnidadCentral($materiales->idMaterial)}}  {{$materiales->unidad_medida}} 
                  </li>
                  <li>
                    {{$metodo->  calcularCantidadUnidadInferior($materiales->idMaterial)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idMaterial)}}  
                  </li>
                  @else
                  <li>
                    {{$metodo->calcularCantidadAlmacen($materiales->idMaterial)}}  {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
                  </li>
                  <li>
                    {{$metodo->  calcularCantidadUnidadInferior($materiales->idMaterial)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idMaterial)}}  

                  </li>
                  @endif
                </ul>



              </td>
              <td style="background-color: #FFE4E1;">
               <center>

                 {{$metodo->convertidorStockUnidadesMinimas_UnidadCentral($materiales->unidad_medida,$materiales->stock_minimo,$materiales->cantidadUnidadMedida)}}  {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
               </center>


             </td>
             <td style="background-color: #FFE4E1;">

              <center>
                <a class="btn btn-sm btn-success tooltips" data-target="#modal-delete2-{{$materiales->idMaterial}}" data-toggle="modal" style="margin-right: 10px;"  role="button"> <i class="fa fa-plus"></i></a>
              </center>
              


            </td>

            <td style="background-color: #FFE4E1;"> 
              <center>
               <a href="#" class="btn btn-info btn-sm" role="button"><i class="fa fa-eye" ></i></a>
             </center>
             

           </td>

           <td style="background-color: #FFE4E1;">  <a href="{{URL::action('AlmacenMaterialController@edit',$materiales->idMaterial)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
           </td>
           <td style="background-color: #FFE4E1;"> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$materiales->idMaterial}}" data-original-title="Agregar Stock" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
           </td>
         </td>
       </td>

     </tr>
     @else
     <tr class="gradeA">
      <td>
        {{$materiales->nombre}} 
      </td>

      @if (($materiales->codigo)!="")
      <td><?php echo DNS1D::getBarcodeHTML("$materiales->codigo", "C128");?>
        <div style="text-align:center;" >
          {{$materiales->codigo}}
        </div>
        <a href="{{URL::action('AlmacenMaterialController@invoice',$materiales->idMaterial)}}" class="btn btn-primary btn-sm" target="_blank" role="button"><i class="fa fa-print"></i></a> 
      </td>
      @else
      <td>Codigo de Barras No Generado </td>

      @endif

      <td>{{$materiales->ubicacion}}</td>
      <td> 

       <ul>
        @if($materiales->unidad_medida== "KILOGRAMOS" || $materiales->unidad_medida== "LITROS" || $materiales->unidad_medida== "METROS" )
        <li>

          {{$metodo->calcularCantidadAlmacen($materiales->idMaterial)}} 
          {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 

        </li>
        <li>

          {{$metodo->calcularCantidadUnidadCentral($materiales->idMaterial)}}  {{$materiales->unidad_medida}} 
        </li>
        <li>
          {{$metodo->  calcularCantidadUnidadInferior($materiales->idMaterial)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idMaterial)}}  
        </li>
        @else
        <li>
          {{$metodo->calcularCantidadAlmacen($materiales->idMaterial)}}  {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
        </li>
        <li>
          {{$metodo->  calcularCantidadUnidadInferior($materiales->idMaterial)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idMaterial)}}  

        </li>
        @endif
      </ul>

      <td>

        <center>
          {{$metodo->convertidorStockUnidadesMinimas_UnidadCentral($materiales->unidad_medida,$materiales->stock_minimo,$materiales->cantidadUnidadMedida)}} {{$materiales->nombreUnidadMedida}} 
        </center>

      </td>

      <td >  
       <center>
        <a class="btn btn-sm btn-success tooltips" data-target="#modal-delete2-{{$materiales->idMaterial}}" data-toggle="modal" style="margin-right: 10px;"  role="button"> <i class="fa fa-plus"></i></a>
      </center>

    </td>
    <td>

     <center>
       <a href="{{URL::action('AlmacenMaterialController@verDetallesArticuloMaterial',$materiales->idMaterial)}}" class="btn btn-info btn-sm" role="button"><i class="fa fa-eye" ></i></a>
     </center>
   </td>
   <td>  <a href="{{URL::action('AlmacenMaterialController@edit',$materiales->idMaterial)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
   </td>
   <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$materiales->idMaterial}}" data-original-title="Agregar Stock" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
   </td>
 </td>
</td>

</tr>
@endif
@include('almacen.materiales.modal')
@include('almacen.materiales.modale')
@endforeach
</tbody>
<tfoot>
  <tr>
    <th>Nombre </th>
    <th>Codigo de Barras </th>
    <th>Ubicacion</th>
    <th>Cantidad en Almacén</th>
    <th>Stock Minimo</th>
    <th>Agregar Stock</th>
    <th>Ver</th>
    <td><center><b>Editar</b></center></td>
    <td><center><b>Borrar</b></center></td>      
  </tr>
</tfoot>
</table>
</div><!--/table-responsive-->
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>

@endsection
