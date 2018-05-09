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
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Compras </strong></h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>

                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="/compras/recepcion/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Compra"> <i class="fa fa-plus"></i> Registrar </a>

                    <a class="btn btn-sm btn-warning tooltips" href="{{route('contratos.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                  </div>

                </b>
              </div>
            </div>
          </div>
        </div>

        <div class="porlets-content">
         <div class="table-responsive">
           <table class="display table table-bordered table-striped" id="dynamic-table">
            <thead>
              <tr>
                <th  >N° Compra</th>
                <th style="display:none;" >Fecha</th>

                <th style="display:none;">Proveedor</th>
                <th style="display:none;">Producto</th>
                <th style="display:none;">KG Enviados</th>
                <th style="display:none;">KG Recibidos</th>
                <th style="display:none;">Diferencia</th>
                <th >Transporte</th>
                <th >Ticket Bascula</th>
                <th >Precio $</th>
                <th style="display:none;">Observaciones</th>
                <th style="display:none;">Recibio</th>
                <th >Ver Compra</th>
                <td><center><b>Editar</b></center></td>
                <td><center><b>Borrar</b></center></td>
              </tr>
            </thead>
            <tbody>
             @foreach($compra  as $compras)
             
             <tr class="gradeX">


               <td >{{$compras->idcompra}} </td>
               <td style="display:none;" >{{$compras->fecha}}</td>
               <td style="display:none;" >{{$compras->provedornombre}}</td>
               <td style="display:none;">{{$compras->productonombre}}</td>
               <td style="display:none;">{{$compras->kg_enviados}}</td>
               <td style="display:none;">{{$compras->kg_recibidos}}</td>
               <td style="display:none;">{{$compras->diferencia}}</td>
               <td >{{$compras->transporte_nombre}}</td>
               <td  >{{$compras->num_ticket}}</td>
               <td >{{$compras->precio}}</td>

               <td style="display:none;" >{{$compras->observaciones}}</td>
               <td style="display:none;"   >{{$compras->recibio}}</td>
               <td >

                 <center>
                   <a href="{{URL::action('RecepcionCompraController@verInformacion',$compras->idContrato)}}" class="btn btn-info btn-sm" role="button"><i class="fa fa-eye"></i></a>
                 </center>
               </td>

               <td>  <a href="{{URL::action('RecepcionCompraController@edit',$compras->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>
               </td> 
             </td>
             <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$compras->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
             </td>
           </tr>
           @include('Compras.Recepcion.modal')
           @endforeach
         </tbody>
         <tfoot>
          <tr>

                <th  >N° Compra</th>
                <th style="display:none;" >Fecha</th>

                <th style="display:none;">Proveedor</th>
                <th style="display:none;">Producto</th>
                <th style="display:none;">KG Enviados</th>
                <th style="display:none;">KG Recibidos</th>
                <th style="display:none;">Diferencia</th>
                <th >Transporte</th>
                <th >Ticket Bascula</th>
                <th >Precio $</th>
                <th style="display:none;">Observaciones</th>
                <th style="display:none;">Recibio</th>
                <th >Ver Compra</th>
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