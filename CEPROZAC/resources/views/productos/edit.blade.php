@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">productos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/productos')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/productos')}}">Productos</a></li>
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
              <div class="actions"><h3></h3> </div>
              <h2 class="content-header" style="margin-top: -5px;"><strong>Editar Producto: {{ $productos->nombre}}</strong></h2> 
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
          <form action="{{url('productos', [$productos->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">
        
           <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="nombre" type="text"  onchange="mayus(this);"  class="form-control" required value="{{ $productos->nombre}}" placeholder="Ingrese nombre del producto"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Descripcion: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="descripcion" maxlength="25" id="descripcion" onkeyup="mayus(this);"  class="form-control"   class="form-control" required value="{{ $productos->descripcion}}" required placeholder="Ingrese la descripcion del producto"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Calidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input type="text" required value="{{ $productos->calidad}}" placeholder="Ingrese calidad de producto" name="calidad" value="" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Proveedor: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="proveedor" type="text"  onchange="mayus(this);"  class="form-control" required value="{{ $productos->proveedor}}" placeholder="Ingrese Proveedor"/>
              </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{url('/productos')}}" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
          </form>
        </div><!--/porlets-content-->
      </div><!--/block-web-->
    </div><!--/col-md-12-->
  </div><!--/row-->
</div><!--/container clear_both padding_fix-->
@endsection
