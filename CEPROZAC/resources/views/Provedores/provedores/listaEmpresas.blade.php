@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Lista de Empresas</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/empleados')}}">Inicio</a></li>
      <li class="active">Lista de Empresas</a></li>
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
              <h4 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>LISTA DE EMPRESAS DE: {{$provedor->nombre}}</strong></h4>
            </div>
        
          </div>
        </div>
        <div class="porlets-content container clear_both padding_fix">
        @if($empresas==null)
          <div class="alert alert-danger"> <strong>No</strong> <a class="alert-link" href="{{ route('empresas.create')}}">se encuentran empresas registradas </a> a este proveedor. Click Para registrar</div>
        @else
          @foreach($empresas as $empresa)
          <div class="col-lg-6"> 
            <section class="panel default blue_title h4">
              <div class="panel-heading"><span class="semi-bold">{{$empresa->nombre}}</span> 
              </div>
              <div class="panel-body">

                <table class="table table-striped">

                  <tbody>
                    <tr>
                      <th>Nombre Empresa: </th>
                      <td>{{$empresa->nombre}}</td>
                    </tr>
                    <tr>
                      <th>RFC:</th>
                      <td>{{$empresa->rfc}}</td>
                    </tr>
                    <tr>
                      <th>Rgimen Fiscal: </th>
                      <td>{{$empresa->regimenFiscal}}</td>
                    </tr>
                    <tr>
                      <th>Telefono:</th>
                      <td>{{$empresa->telefono}}</td>
                    </tr>
                    <tr>
                      <th>Direccion</th>
                      <td>{{$empresa->direccion}}</td>
                    </tr>
                    <tr>
                      <th>Correo: </th>
                      <td>{{$empresa->email}}</td>
                    </tr>
                    <tr>
                      <th>Banco: </th>
                      <td>{{$empresa->nombreBanco}}</td>
                    </tr>
                    <tr>
                      <th>Clave Interbancaria: </th>
                      <td>{{$empresa->cve_Interbancaria}}</td>
                    </tr>
                    <tr>
                      <th>Numero de cuenta: </th>
                      <td>{{$empresa->nom_cuenta}}</td>
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
