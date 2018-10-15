@inject('metodo','CEPROZAC\Http\Controllers\AlmacenMaterialController')
@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Detalle de Producto</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/almacen/materiales')}}">Inicio</a></li>
      <li class="active">Almacen Materiales</a></li>
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
              <h4 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>{{$material->nombre}}</strong></h4>
            </div>
            <div class="btn-group pull-right">
              <b>
                <div class="btn-group" style="margin-right: 10px;">
                  <a class="btn btn-sm btn-danger tooltips" href="{{url('/almacen/materiales')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cancelar"> <i class="fa fa-times"></i> Salir</a>
                </div> 
              </b>
            </div>

          </div>
        </div>
        <div class="porlets-content container clear_both padding_fix">
          <div class="panel-body">
            <div class="col-lg-3">

              <p class="text-left space_p"><strong>Nombre: </strong>{{$material->nombre}}</p>
              <p class="text-left space_p"><?php echo DNS1D::getBarcodeHTML("$material->codigo", "C128");?></p>
              <p class="text-left space_p"><strong>Codigo:</strong> {{$material->codigo}}</p>
              <p class="text-left space_p"><strong>Cantidad en Almacen:</strong> 
                @if($material->unidad_medida== "KILOGRAMOS" || $material->unidad_medida== "LITROS" || $mat->unidad_medida== "METROS" )
                <li>

                  {{$metodo->calcularCantidadAlmacen($material->idMaterial)}} 
                  {{$material->nombreUnidadMedida}}  DE  {{$material-> cantidadUnidadMedida}} {{$material->unidad_medida}} 

                </li>
                <li>

                  {{$metodo->calcularCantidadUnidadCentral($material->idMaterial)}}  {{$material->unidad_medida}} 
                </li>
                <li>
                  {{$metodo->  calcularCantidadUnidadInferior($material->idMaterial)}}      {{$metodo->labelUnidadMedidaMinima($material->idMaterial)}}  
                </li>
                @else
                <li>
                  {{$metodo->calcularCantidadAlmacen($material->idMaterial)}}  {{$material->nombreUnidadMedida}}  DE  {{$material-> cantidadUnidadMedida}} {{$material->unidad_medida}} 
                </li>
                <li>
                  {{$metodo->  calcularCantidadUnidadInferior($material->idMaterial)}}      {{$metodo->labelUnidadMedidaMinima($material->idMaterial)}}  

                </li>
                @endif

              </p>
              <p class="text-left space_p"><strong>Descripcion:</strong> {{$material->descripcion}}</p>
              <p class="text-left space_p"><strong>Ubicacion:</strong> {{$material->ubicacion}}</p>
              <p class="text-left space_p"><strong>Creado:</strong> {{$material->created_at}}</p>

            </div>
            <div class="col-lg-6"> 
              <div class="text-center space_p">
                @if (($material->imagen)!="")
                <img src="{{asset('imagenes/almacenMaterial/'.$material->imagen)}}" alt="{{$material->nombre}}" height="100px" width="100px" class="img-thumbnail">
                @else
                No Hay Imagen Disponible
                @endif
              </div>

            </div>
          </div>







        </div><!--/porlets-content-->
      </div><!--/block-web-->
    </div><!--/col-md-12-->
  </div><!--/row-->
</div>



@endsection