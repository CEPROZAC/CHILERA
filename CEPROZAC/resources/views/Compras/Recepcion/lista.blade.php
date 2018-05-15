@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Lista de Empleados</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/empleados')}}">Inicio</a></li>
      <li class="active">Lista de Empleados</a></li>
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
              <h4 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>INFORMACION DE COMPRA N°: {{$compra->id}}</strong></h4>
            </div>
            <div class="btn-group pull-right">
              <b>

                <div class="btn-group" style="margin-right: 10px;">
                  <a class="btn btn-sm btn-success tooltips" href="{{URL::action('RecepcionCompraController@create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Proveedor"> <i class="fa fa-plus"></i> Registrar </a>

                  <a class="btn btn-sm btn-danger tooltips" href="/empleados" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cancelar"> <i class="fa fa-times"></i> Salir</a>

                </div> 
              </b>
            </div>

          </div>
        </div>
        <div class="porlets-content container clear_both padding_fix">

          <div class="col-lg-6"> 
            <section class="panel default blue_title h4">
              <div class="panel-heading"><span class="semi-bold">Informacion De Compra</span> 
              </div>
              <div class="panel-body">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <th>Número de Compra: </th>
                      <td>{{$compra->id}}</td>
                    </tr>
                    <tr>
                      <th>Fecha:</th>
                      <td>{{$compra->fecha}}</td>
                    </tr>
                    <tr>
                      <th>KG Enviados: </th>
                      <td>{{$compra->kg_enviados}}</td>
                    </tr>
                    <tr>
                      <th>KG Recibidos: </th>
                      <td>{{$compra->kg_recibidos}}</td>
                    </tr>
                    <tr>
                      <th>Diferencia: </th>
                      <td>{{$compra->diferencia}}</td>
                    </tr>
                    <tr>
                      <th>N° De Ticket de Bascula: </th>
                      <td>{{$tickets->numeroTicket}}</td>
                    </tr>
                    <tr>
                      <th>Precio $: </th>
                      <td>${{$compra->precio}}</td>
                    </tr>
                    <th>Observaciónes: </th>
                      <td>${{$compra->observaciones}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </section>
          </div>

          <div class="col-lg-6"> 
            <section class="panel default blue_title h4">
              <div class="panel-heading"><span class="semi-bold">Informacion Del Proveedor</span> 
              </div>
              <div class="panel-body">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <th>Nombre del Proveedor: </th>
                      <td>{{$provedor->nombre}}</td>
                    </tr>
                    <tr>
                      <th>Dirección:</th>
                      <td>{{$provedor->direccion}}</td>
                    </tr>
                    <tr>
                      <th>Email:</th>
                      <td>{{$provedor->email}}</td>
                    </tr>
                    <tr>
                      <th>Teléfono: </th>
                      <td>{{$provedor->telefono}}</td>
                    </tr>
                    <tr>
                      <th> <div style="visibility: hidden"> Dato Nulo</div></th>
                      <td></td>
                    </tr>
                    <tr>
                      <th> <div style="visibility: hidden"> Dato Nulo</div></th>
                      <td></td>
                    </tr>
                    <tr>
                      <th> <div style="visibility: hidden"> Dato Nulo</div></th>
                      <td></td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </section>
          </div>

          <div class="col-lg-6"> 
            <section class="panel default blue_title h4">
              <div class="panel-heading"><span class="semi-bold">Información del Producto </span> 
              </div>
              <div class="panel-body">
                <table class="table table-striped">
                  <tbody>
                   <tr>
                     <th>Nombre: </th>
                     <td>{{$producto->nombre}}</td>
                   </tr>

                   <tr>
                    <th>Calidad: </th>
                    <td>{{$producto->calidad}}</td>
                  </tr>
                  <tr>
                    <th>Unidad de Medida: </th>
                    <td>{{$producto->unidad_de_Medida}}</td>
                  </tr>
                  <tr>

                </tbody>
              </table>
            </div>
          </section>
        </div>

        <div class="col-lg-6"> 
          <section class="panel default blue_title h4">
            <div class="panel-heading"><span class="semi-bold">Transporte en que LLego</span> 
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <tbody>
                   <tr>
                     <th>Nombre del Transporte: </th>
                     <td>{{$transporte->nombre_Unidad}}</td>
                   </tr>
                   <tr>
                    <th>N° Serie: </th>
                    <td>{{$transporte->no_Serie}}</td>
                  </tr>
                  <tr>
                    <th>Placas: </th>
                    <td>{{$transporte->placas}}</td>
                  </tr>
                  <tr>
                  <tr>
                    <th>M3 de Unidad: </th>
                    <td>{{$transporte->m3_Unidad}}</td>
                  </tr>
                  <tr>
                  <tr>
                    <th>Capacidad: </th>
                    <td>{{$transporte->capacidad}}</td>
                  </tr>
                  <tr>

                </tbody>
              </table>
            </div>
          </section>
        </div>



      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div>


@endsection
