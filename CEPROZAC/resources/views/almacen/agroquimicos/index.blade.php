@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Almacén de Agroquímicos</h1>
    <h2 class="">Almacén de Agroquímicos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('almacenes/agroquimicos')}}">Inicio</a></li>
      <li class="active">Almacén de Agroquímicos</a></li>
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
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Agroquímicos </strong></h2>
            </div>
            <div class="col-md-12">
              <div class="btn-group pull-right">
                <b>


                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="/almacenes/agroquimicos/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Material"> <i class="fa fa-plus"></i> Registrar </a>

                   <a class="btn btn-sm btn-warning tooltips" href="{{ route('almacen.agroquimicos.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                    <a class="btn btn-sm btn-success tooltips" href="/almacen/salidas/agroquimicos/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i> Registrar Salida de Almacén </a>

                    <a class="btn btn-sm btn-success tooltips" href="/almacen/entradas/agroquimicos/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-plus"></i> Registrar Entrada de Almacén </a>

                    <a class="btn btn-sm btn-success tooltips" href="/materiales/provedores" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Proveedor de Materiales"> <i class="fa fa-plus"></i> Proveedores de Materiales</a>

</div>
                </b>
              </div>
            </div>
          </div>
        </div>

        <div class="porlets-content">
          <div class="table-responsive">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
                <tr>
                  <th>Id </th>
                   <th>Nombre </th>
                   <th>Proveedor </th>
                    <th>Codigo de Barras </th>
                    <th>Imagen </th>
                   <th>Descripción </th>
                  <th>Cantidad</th>
                  <th>Estado</th>  
                  <td><center><b>Editar</b></center></td>
                  <td><center><b>Borrar</b></center></td>                            
                </tr>
              </thead>
              <tbody>
                @foreach($material  as $materiales)
                <tr class="gradeA">
                  <td>{{$materiales->id}} </td>
                  <td>{{$materiales->nombre}} </td>
                  <td>{{$materiales->provedor}} </td>
                  <td><?php echo DNS1D::getBarcodeHTML("$materiales->codigo", "EAN13");?>
                    <div style="text-align:center;">
                    {{$materiales->codigo}}                
                  </div>
                   <a href="{{URL::action('AlmacenAgroquimicosController@invoice',$materiales->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-print"></i></a> 
                  </td>
                  <td>
                      <img src="{{asset('imagenes/almacenagroquimicos/'.$materiales->imagen)}}" alt="{{$materiales->nombre}}" height="100px" width="100px" class="img-thumbnail">
                    </td>              
                   <td>{{$materiales->descripcion}} </td>
                  <td>{{$materiales->cantidad}} {{$materiales->medida}} <a class="btn btn-sm btn-success tooltips" data-target="#modal-delete2-{{$materiales->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"> <i class="fa fa-plus"></i></a> </td>
                  <td>{{$materiales->estado}}</td>

                     <td>  <a href="{{URL::action('AlmacenAgroquimicosController@edit',$materiales->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
                  </td>
                  <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$materiales->id}}" data-original-title="Agregar Stock" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
                  </td>
                </td>
                </td>

              </tr>
              @include('almacen.agroquimicos.modal')
                @include('almacen.agroquimicos.modale')
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                   <th>Id </th>
                   <th>Nombre </th>
                   <th>Proveedor </th>
                    <th>Codigo de Barras </th>
                    <th>Imagen </th>
                   <th>Descripción </th>
                  <th>Cantidad</th>
                  <th>Estado</th>  
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
