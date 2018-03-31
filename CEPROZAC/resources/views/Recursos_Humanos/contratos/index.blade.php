@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Contratos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/contratos')}}">Inicio</a></li>
      <li class="active">Contratos</a></li> 
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
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Contratos </strong></h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>

                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="contratos/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Empleado"> <i class="fa fa-plus"></i> Registrar </a>

                    <a class="btn btn-sm btn-warning tooltips" href="{{route('contratos.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

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
                <th >Nombre Completo</th>
                <th  >Fecha Inicio</th>
                
                <th >Fecha Fin</th>
                <th>Duracion Contrato</th>

                
                <td><center><b>Editar</b></center></td>
                <td><center><b>Borrar</b></center></td>
              </tr>
            </thead>
            <tbody>
              @foreach($contratos  as $contrato)
              <tr class="gradeX">
                <td >{{$contratos->nombre}} {{$contratos->apellidos}} </td>
                
                <td >{{$contrato->fecha_Ingreso}}</td>
                <td >{{$contrato->fecha_Alta_Seguro}}</td>
                <td>{{$contrato->numero_Seguro_Social}}</td>
                <td>{{$contrato->fecha_Nacimiento}}</td>

                <td>  <a href="{{URL::action('EmpleadoController@edit',$contrato->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>
                </td> 
              </td>
              <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$contrato->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
              </td>
            </tr>
            @include('Recursos_Humanos.contratos.modal')
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th >Nombre Completo</th>
              <th  >Fecha Inicio</th>

              <th >Fecha Fin</th>
              <th>Duracion Contrato</th>

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
