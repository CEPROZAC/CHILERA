@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Lista de Mantenimientos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/empleados')}}">Inicio</a></li>
      <li class="active">Lista de Mantenimientos</a></li>
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
              <h4 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Mantenimientos de : {{$transporte->nombre_Unidad}}</strong></h4>
            </div>

          </div>
        </div>
        <div class="porlets-content container clear_both padding_fix">
          @if($mantenimientos==null)
          <div class="alert alert-danger"> <strong>No</strong> <a class="alert-link" href="{{ route('mantenimiento.create')}}">se encuentran mantenimientos registrados </a> a este Vehiculo. Click Para registrar</div>
          @else
          @foreach($mantenimientos as $mantenimiento)
          <div class="col-lg-6"> 
            <section class="panel default blue_title h4">
              <div class="panel-heading"><span class="semi-bold">{{$mantenimiento->concepto}}</span> 
              </div>
              <div class="panel-body">

                <table class="table table-striped">

                  <tbody>
                    <tr>
                      <th>Concepto: </th>
                      <td>{{$mantenimiento->concepto}}</td>
                    </tr>
                    <tr>
                      <th>Descripcion:</th>
                      <td>{{$mantenimiento->descripcion}}</td>
                    </tr>
                    <tr>
                      <th>Fecha: </th>
                      <td>{{$mantenimiento->fecha}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </section>
          </div>
          @endforeach
          @endif
        </div><!--/porlets-content-->
      </div><!--/block-web-->
    </div><!--/col-md-12-->
  </div><!--/row-->
</div>
@endsection
