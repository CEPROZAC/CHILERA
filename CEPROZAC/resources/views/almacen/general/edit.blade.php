@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Almacenes Generales</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/almacen/general')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacen/general')}}">Almacenes Generales</a></li>
    </ol>
  </div>
</div>
<div class="container clear_both padding_fix">
  <div class="row">
    <div class="col-md-12">
      <div class="block-web">
        <div class="header">
          <div class="row" style="margin-top: 15px; margin-bottom: 12px;">
            <div class="col-sm-8">
              <div class="actions"> </div>
              <h2 class="content-header" style="margin-top: -5px;"><strong>Editar Almacén de {{ $almacen->nombre}}</strong></h2>
            </div>
            <div class="col-md-4">
              <div class="btn-group pull-right">
                <div class="actions"> 
                </div>
              </div>
            </div>    
          </div>
        </div>
         <div class="porlets-content">
         <div class="text-success" id='result'>
          @if(Session::has('message'))
          {{Session::get('message')}}
          @endif
        </div>
        <div class="porlets-content">
          <form action="{{url('/almacen/general', [$almacen->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">


            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="nombre" type="text"  value="{{$almacen->nombre}}" maxlength="30"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese nombre del producto" />

              </div>
            </div>

                <div class="form-group">
              <label class="col-sm-3 control-label">Capacidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="capacidad" type="text"  value="{{$almacen->capacidad}}"  maxlength="70"  onchange="soloNumeros(this);"  class="form-control" required value="" placeholder="Ingrese Descripción del Material" />
              </div>
            </div>


    <div class="form-group">
              <label class="col-sm-3 control-label">Tipo de Capacidad (Cajon,m2,etc..) : <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="medida" type="text"  value="{{$almacen->medida}}"  maxlength="70"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Tipo de Capacidad (Cajon,m2,etc..):" />
              </div>
            </div>

                <div class="form-group">
              <label class="col-sm-3 control-label">Descripción: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="descripcion" type="text"  value="{{$almacen->descripcion}}"  maxlength="70"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese Descripción del Material" />
              </div>
            </div>

              <div class="form-group">
              <label class="col-sm-3 control-label">Espacio Ocupado Actualmente: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="ocupado" type="text"  value="{{$almacen->ocupado}}"  maxlength="70"  onchange="soloNumeros(this);"  class="form-control" required value="" placeholder="Ingrese el Espacio Ocupado Actualmente" />
              </div>
            </div>

               


   

   <div class="form-group">
    <div class="col-sm-offset-7 col-sm-5">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="{{url('/almacen/general')}}" class="btn btn-default"> Cancelar</a>
    </div>
  </div><!--/form-group-->


</form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>
@endsection


</head>