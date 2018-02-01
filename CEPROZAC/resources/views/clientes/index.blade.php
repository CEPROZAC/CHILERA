@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Clientes</h1>
    <h2 class="">Listado Clientes CEPROZAC</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a href="?c=Inicio">Inicio</a></li>
      <li class="active">CLIENTES</a></li>
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
              <h2 class="content-header theme_color" style="margin-top: -5px;">&nbsp;&nbsp;Clientes CEPROZAC</h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>

                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="clientes/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Cliente"> <i class="fa fa-plus"></i> Registrar </a>

                   <a class="btn btn-sm btn-warning tooltips" href="{{ route('clientes.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

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
                  <th>Nombre </th>
                  <th>Teléfono </th>
                  <th>Dirección </th>
                   <th>Correo </th>
                  <th>Saldo Cliente </th>    
                  <th>Opciónes </th>                              
                </tr>
              </thead>
              <tbody>
                @foreach($cliente  as $clientes)
                <tr class="gradeA">
                  <td>{{$clientes->nombre}} </td>
                  <td>{{$clientes->telefono}} </td>
                  <td>{{$clientes->calle}} #{{$clientes->numero}} {{$clientes->colonia}} {{$clientes->entidad}} {{$clientes->pais}}</td>
                  <td>{{$clientes->email}}</td>
                  
 
                  <td>${{$clientes-> saldocliente}}</td>
               <td>
                         <a href="{{URL::action('ClienteController@edit', $clientes->id)}}"> <button class="btn btn-info">Editar </button> </a>
                          <a href="" data-target="#modal-delete-{{$clientes->id}}" data-toggle="modal"> <button class="btn btn-danger">Eliminar </button> </a>
                    </td>
                </td>
              </tr>
              @include('clientes.modal')
              @endforeach
            </tbody>
            <tfoot>
              <tr>
               <th>Nombre </th>
               <th>Teléfono </th>
               <th>Dirección </th>
               <th>Correo </th>
               <th>Saldo Cliente </th>
                <th>Opciónes </th>  
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