@inject('metodo','CEPROZAC\Http\Controllers\EntradasAgroquimicosController')
@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Entradas Agroquimicos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/almacen/salidas/agroquimicos')}}">Inicio</a></li>
      <li class="active">Reporte de Entrada de Almacén de Agroquimicos</a></li>
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
              <h4 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>INFORMACION DE FACTURA N°: {{$entrada->factura}} </strong></h4>
            </div>
            <div class="btn-group pull-right">
              <b>

                <div class="btn-group" style="margin-right: 10px;">
                  <a class="btn btn-sm btn-success tooltips" href="{{ route('almacen.entradas.agroquimicos.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i> Registrar Entrada de Almacén</a>

                  <a class="btn btn-sm btn-danger tooltips" href="/almacen/entradas/agroquimicos" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cancelar"> <i class="fa fa-times"></i> Salir</a>

                  <a class="btn btn-sm btn btn-info" href="{{URL::action('EntradasAgroquimicosController@pdfentradaAgroquimicos',$entrada->factura)}}" target="_blank" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-print"></i>Imprimir Reporte</a>

                </div>  
              </b>
            </div>

          </div>
        </div>
        <div class="porlets-content container clear_both padding_fix">
          <div class="invoice">

            <div class="invoice_body">
              <div  class="pull-left">

                <strong>Numero de Factura:</strong> {{$entrada->factura}}<br>
                <strong>Proveedor: </strong>{{$entrada->ProvedorNombre}}<br>
                <strong>Fecha: </strong>{{$entrada->fecha}}<br>
                <br>
                <br>
              </div>
              <div class="pull-right"> 
               <strong>Entrega: </strong>{{$entrada->nombreEmpleadoEntrega}} {{$entrada->apellidosEmpleadoEntrega}}<br>
               <strong>Recibe: </strong>{{$entrada->nombreEmpleadoRecibe}} {{$entrada->apellidosEmpleadoRecibe}}<br>
               <strong>Observaciones: </strong>{{$entrada->observacionesc}}<br>
             </div>

             <br/>

             <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">Material</th>
                  <th>Precio U.</th>
                  <th>Cantidad</th>
                  <th>Importe</th>
                  <th>IVA</th>
                  <th>IEPS</th>
                  <th>SUBTOTAL</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data2 as $producto)
                <tr class="tr_border">
                  <td class="text-center">{{$producto->nombreMaterial}} {{$producto->idDetalleEntrada}}</td>
                  <td class="text-right">${{$producto->p_unitario}}</td>
                  <td> 
                   @if($producto->nombreUnidadMedida== "KILOGRAMOS" || $producto->nombreUnidadMedida== "LITROS" || $producto->nombreUnidadMedida== "METROS" )
                   <li>

                    {{$metodo->calcularCantidadAlmacen($producto->idDetalleEntrada)}} 
                    {{$producto->UnidadNombre}}  DE  {{$producto-> cantidadUnidad}} {{$producto->nombreUnidadMedida}} 

                  </li>
                  <li>

                    {{$metodo->calcularCantidadUnidadCentral($producto->idDetalleEntrada)}}  {{$producto->nombreUnidadMedida}} 
                  </li>
                  <li>
                    {{$metodo->calcularCantidadUnidadInferior($producto->idDetalleEntrada)}}     
                    {{$metodo->labelUnidadMedidaMinima($producto->idDetalleEntrada)}}  
                  </li>
                  @else
                  <li>
                    {{$metodo->calcularCantidadAlmacen($producto->idDetalleEntrada)}}  {{$producto->UnidadNombre}}  DE  {{$producto->cantidadUnidad}} {{$producto->nombreUnidadMedida}} 
                  </li>
                  <li>
                    {{$metodo->calcularCantidadUnidadInferior($producto->idDetalleEntrada)}}      {{$metodo->labelUnidadMedidaMinima($producto->idDetalleEntrada)}}  
                  </li>
                  @endif
                </td>
                <td>{{$importe=round($metodo->calcularImporte($producto->p_unitario,
                $producto->cantidad,$producto->nombreUnidadMedida,$producto->cantidadUnidad,$producto->nombreUnidadMedida),2)}} </td>
                <td>{{$iva =round($metodo->calculoIVA($importe,$producto->iva),2)}}</td>
                <td>{{$ieps =round($metodo->calculoIEPS($importe,$producto->ieps),2)}}</td>
                <td>{{round($metodo->calcularSubTotal($iva,$ieps,$importe),2)}}</td>
              </tr>
              @endforeach

            </tbody>
          </table>

        </div>

      </div>



    </div><!--/porlets-content-->
  </div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>


@endsection
