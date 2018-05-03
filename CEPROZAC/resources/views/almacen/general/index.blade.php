@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Almacenes Generales </h1>
    <h2 class="">Almacenes Generales </h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('almacenes/limpieza')}}">Inicio</a></li>
      <li class="active">Almacenes Generales </a></li>
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
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Almacenes Generales CEPROZAC </strong></h2>
            </div>
            <div class="col-md-12">
              <div class="btn-group pull-right">
                <b>


                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="/almacen/general/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Almacén"> <i class="fa fa-plus"></i> Registrar Almacén </a>

                    <a class="btn btn-sm btn-warning tooltips" href="{{ route('almacen.limpieza.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                    <a class="btn btn-sm btn-success tooltips" href="/almacen/salidas/limpieza" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i>Salidas de Almacén </a>

                    <a class="btn btn-sm btn-success tooltips" href="/almacen/entradas/limpieza" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-plus"></i>Entradas de Almacén </a>


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
                  <th>N° Almacén </th>
                  <th>Nombre </th>
                  <th>Capacidad </th>
                  <th>Descripción </th>
                  <th>Espacio Ocupado </th>
                  <th>Espacio Libre </th>
                  <th>Estado</th>  
                  <td><center><b>Editar</b></center></td>
                  <td><center><b>Borrar</b></center></td>                            
                </tr>
              </thead>
              <tbody>
                @foreach($almacen  as $almacenes)
                <tr class="gradeA">
                  <td>{{$almacenes->id}} </td>
                  <td>{{$almacenes->nombre}} </td>
                  <td>{{$almacenes->capacidad}} {{$almacenes->medida}} </td>            
                  <td>{{$almacenes->descripcion}} </td>
                  <td>{{$almacenes->ocupado}} {{$almacenes->medida}}</td>
                  <td>{{$almacenes->libre}} {{$almacenes->medida}}</td>
                  <td>{{$almacenes->estado}}</td>
                  <td>  <a href="{{URL::action('AlmacenGeneralController@edit',$almacenes->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
                  </td>
                  <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$almacenes->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
                  </td>
                </td>
              </td>

            </tr>
            @include('almacen.general.modal')
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>N° Almacén </th>
              <th>Nombre </th>
              <th>Capacidad </th>
              <th>Descripción </th>
              <th>Espacio Ocupado </th>
              <th>Espacio Libre </th>
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
