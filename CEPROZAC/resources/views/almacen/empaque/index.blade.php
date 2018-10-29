@inject('metodo','CEPROZAC\Http\Controllers\AlmacenEmpaqueController')
@extends('layouts.principal')
@section('contenido')
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<style>
  table, th, td {
    border: 1px solid black;
  }
</style>
</head>
<body>
  <div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
      <h1>Almacén de Empaques</h1>
      <h2 class="">Almacén de Empaques</h2>
    </div>
    <div class="pull-right">
      <ol class="breadcrumb">
        <li ><a style="color: #808080" href="{{url('/almacenes/empaque')}}">Inicio</a></li>
        <li class="active">Almacén de Empaques</a></li>
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
                <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Empaques  </strong></h2>
              </div>
              <div class="col-md-12">
                <div class="btn-group pull-right">
                  <b>
                    <div class="btn-group" style="margin-right: 10px;">
                      <a class="btn btn-sm btn-success tooltips" href="{{ route('almacenes.empaque.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Material"> <i class="fa fa-plus"></i> Registrar Empaque </a>

                      <a class="btn btn-sm btn-warning tooltips" href="{{ route('almacen.empaque.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                      <a class="btn btn-sm btn-danger"  href="{{ route('almacen.salidas.empaque.index')}}"  style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i>Salidas de Almacén </a>

                      <a class="btn btn-sm btn btn-info" href="{{ route('almacen.entradas.empaque.index')}}"  style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-plus"></i>Entradas de Almacén </a>
                    </div>
                  </b>
                  <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('factura')}}</div>
                </div>
              </div>
            </div>
          </div>

          <div class="porlets-content">
            <div class="table-responsive" style="overflow-x:auto;">
              <table  class="display table table-bordered table-striped" id="dynamic-table">
                <thead>
                  <tr>

                   <th>Nombre </th>

                   <th>Codigo de Barras </th>
                   <th>Imagen </th>
                   <th>Descripción </th>
                   <th>Cantidad en Almacén 
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                   </th>
                   <th>Stock Minimo</th> 
                   <th>Agregar Stock</th>

                   <td><center><b>Editar</b></center></td>
                   <td><center><b>Borrar</b></center></td>                            
                 </tr>
               </thead>
               <tbody>
                @foreach($material  as $materiales)

                <!--{{$completos=$metodo->calcularCantidadAlmacen($materiales->idEmpaque)}} -->
                @if( $completos <= $materiales->stock_minimo )
                

                <tr class="gradeA">


                  <td style="background-color: #FFE4E1;">{{$materiales->formaEmpaque}} </td>

                  @if (($materiales->codigo)!="")
                  <td style="background-color: #FFE4E1;"><?php echo DNS1D::getBarcodeHTML("$materiales->codigo", "C128");?>
                    <div style="text-align:center;" >
                      {{$materiales->codigo}}
                    </div>
                    <center>
                      <a href="{{URL::action('AlmacenEmpaqueController@invoice',$materiales->idEmpaque)}}" class="btn btn-primary btn-sm" target="_blank" role="button"><i class="fa fa-print"></i></a> 
                    </center>
                  </td>
                  @else
                  <td style="background-color: #FFE4E1;">Codigo de Barras No Generado </td>
                  
                  @endif

                  <td style="background-color: #FFE4E1;">
                    @if (($materiales->imagen)!="")

                    <img src="{{asset('imagenes/almacenempaque/'.$materiales->imagen)}}" alt="{{$materiales->formaEmpaque}}" height="100px" width="100px" class="img-thumbnail">
                    @else
                    No Hay Imagen Disponible
                    @endif
                  </td>              
                  <td style="background-color: #FFE4E1;">{{$materiales->descripcion}} </td>
                  <td style="background-color: #FFE4E1;">

                    <ul>
                      @if($materiales->unidad_medida== "KILOGRAMOS" || $materiales->unidad_medida== "LITROS" || $materiales->unidad_medida== "METROS" )
                      <li>

                        {{$metodo->calcularCantidadAlmacen($materiales->idEmpaque)}} 
                        {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 

                      </li>
                      <li>

                        {{$metodo->calcularCantidadUnidadCentral($materiales->idEmpaque)}}  {{$materiales->unidad_medida}} 
                      </li>
                      <li>
                        {{$metodo->  calcularCantidadUnidadInferior($materiales->idEmpaque)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idEmpaque)}}  
                      </li>
                      @else
                      <li>
                        {{$metodo->calcularCantidadAlmacen($materiales->idEmpaque)}}  {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
                      </li>
                      <li>
                        {{$metodo->  calcularCantidadUnidadInferior($materiales->idEmpaque)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idAgroquimico)}}  

                      </li>
                      @endif
                    </ul>



                  </td>
                  <td style="background-color: #FFE4E1;">
                    <center>
                     {{$metodo->convertidorStockUnidadesMinimas_UnidadCentral($materiales->unidad_medida,$materiales->stock_minimo,$materiales->cantidadUnidadMedida)}} {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
                   </center>


                 </td>

                 <td style="background-color: #FFE4E1;">   
                   <center>
                    <a class="btn btn-sm btn-success tooltips" data-target="#modal-delete2-{{$materiales->idEmpaque}}" data-toggle="modal" style="margin-right: 10px;"  role="button"> <i class="fa fa-plus"></i></a>
                  </center>
                </td>

                <td style="background-color: #FFE4E1;">  <a href="{{URL::action('AlmacenEmpaqueController@edit',$materiales->idEmpaque)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
                </td>
                <td style="background-color: #FFE4E1;"> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$materiales->idEmpaque}}" data-original-title="Agregar Stock" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
                </td>
              </td>
            </td>

          </tr>
          @else
          <tr class="gradeA">

            <td>

              {{$materiales->formaEmpaque}} 

            </td>

            @if (($materiales->codigo)!="")
            <td><?php echo DNS1D::getBarcodeHTML("$materiales->codigo", "C128");?>
              <div style="text-align:center;" >
                {{$materiales->codigo}}
              </div>
              <a href="{{URL::action('AlmacenEmpaqueController@invoice',$materiales->idEmpaque)}}" class="btn btn-primary btn-sm" target="_blank" role="button"><i class="fa fa-print"></i></a> 
            </td>
            @else
            <td>Codigo de Barras No Generado </td>

            @endif

            <td>
              @if (($materiales->imagen)!="")
              <img src="{{asset('imagenes/almacenempaque/'.$materiales->imagen)}}" alt="{{$materiales->formaEmpaque}}" height="100px" width="100px" class="img-thumbnail">
              @else
              No Hay Imagen Disponible
              @endif
            </td>              
            <td>{{$materiales->descripcion}} </td>
            <td> 

             <ul>
              @if($materiales->unidad_medida== "KILOGRAMOS" || $materiales->unidad_medida== "LITROS" || $materiales->unidad_medida== "METROS" )
              <li>

                {{$metodo->calcularCantidadAlmacen($materiales->idEmpaque)}} 
                {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 

              </li>
              <li>

                {{$metodo->calcularCantidadUnidadCentral($materiales->idEmpaque)}}  {{$materiales->unidad_medida}} 
              </li>
              <li>
                {{$metodo->  calcularCantidadUnidadInferior($materiales->idEmpaque)}}      {{$metodo->labelUnidadMedidaMinima($materiales->idEmpaque)}}  
              </li>
              @else
              <li>
                {{$metodo->calcularCantidadAlmacen($materiales->idEmpaque)}}  {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
              </li>
              <li>
                {{$metodo->  calcularCantidadUnidadInferior($materiales->idEmpaque)}}     
                {{$metodo->labelUnidadMedidaMinima($materiales->idEmpaque)}}  

              </li>
              @endif
            </ul>

            <td>

              <center>
                {{$metodo->convertidorStockUnidadesMinimas_UnidadCentral($materiales->unidad_medida,$materiales->stock_minimo,$materiales->cantidadUnidadMedida)}}  {{$materiales->nombreUnidadMedida}}  DE  {{$materiales-> cantidadUnidadMedida}} {{$materiales->unidad_medida}} 
              </center>

            </td>

            <td >  
             <center>
               <a class="btn btn-sm btn-success tooltips" data-target="#modal-delete2-{{$materiales->idEmpaque}}" data-toggle="modal" style="margin-right: 10px;"  role="button"> <i class="fa fa-plus"></i></a>
             </center>

           </td>



           <td>  <a href="{{URL::action('AlmacenEmpaqueController@edit',$materiales->idEmpaque)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
           </td>
           <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$materiales->idEmpaque}}" data-original-title="Agregar Stock" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
           </td>
         </td>
       </td>

     </tr>
     @endif
     @include('almacen.empaque.modal')
     @include('almacen.empaque.modale')
     @endforeach
   </tbody>
   <tfoot>
    <tr>

      <th>Nombre </th>
      <th>Codigo de Barras </th>
      <th>Imagen </th>
      <th>Descripción </th>
      <th>Cantidad en Almacén</th>
      <th>Stock Minimo</th>
      <th>Agregar Stock</th>

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
