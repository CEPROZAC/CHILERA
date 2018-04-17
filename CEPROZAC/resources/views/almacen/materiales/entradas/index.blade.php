@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Almacén de Materiales</h1>
    <h2 class="">Entradas</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('almacen/materiales')}}">Inicio</a></li>
      <li class="active">Entradas de Almacén de Materiales</a></li>
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
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Entradas de Almacén de Materiales </strong></h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>

                  <div class="btn-group" style="margin-right: 10px;">
                   <a class="btn btn-sm btn-success tooltips" href="/almacen/entradas/materiales/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i> Registrar Salida de Almacén </a>

                   <a class="btn btn-sm btn-warning tooltips" href="{{ route('almacen.materiales.entradas.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>



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
                  <th>N°Compra </th>
                  <th>Fecha de Entrada</th>  
                  <th>Proveedor de Material </th>
                  <th>N°Nota </th>
                  <th>Nombre de Material</th>
                  <th>Cantidad Comprada</th>
                    <th>Precio Unitario </th>
                   <th>Subtotal </th>
                    <th>Total de Compra </th>
                  <th>Comprador</th>
                  
                  <td><center><b>Borrar</b></center></td>                            
                </tr>
              </thead>
              <tbody>
                @foreach($entrada  as $entradas)
                <tr class="gradeA">
                  <td>{{$entradas->id}} </td>
                  <td>{{$entradas->fecha}} </td>
                   <td>{{$entradas->provedor}} </td>
                   <td>{{$entradas->nota_venta}} </td>
                   <td>{{$entradas->nombremat}} </td>
                   <td>{{$entradas->cantidad}} </td>
                   <td>${{$entradas->p_unitario}} </td>
                    <td>${{$entradas->importe}} </td>
                    <td>${{$entradas->total}} </td>
                     <td>{{$entradas->comprador}} </td>
                  <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$entradas->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
                  </td>
                </td>
                </td>

              </tr>
              @include('almacen.materiales.entradas.modal')
              
            
                 @endforeach
            </tbody>
            <tfoot>
              <tr>
                  <th>N°Entrada </th>
                  <th>Fecha de Entrada</th>  
                  <th>Proveedor </th>
                  <th>N°Nota </th>
                  <th>Nombre de Material</th>
                  <th>Cantidad </th>
                    <th>Precio Unitario </th>
                   <th>Subtotal </th>
                    <th>Total de Compra </th>
                  <th>Comprador</th>
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