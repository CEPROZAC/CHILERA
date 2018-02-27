@extends('layouts.principal')
@section('contenido')

<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">

    <h1>Inicio</h1>
    <h2 class="">Materiales</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/almacen/materiales')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacen/materiales')}}">Almacén de Materiales</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Nuevo Producto</strong></h2>
            </div>

            <div class="col-md-4">

              <div class="btn-group pull-right">
                <div class="actions"> 
                </div>
              </div>
            </div>    
          </div>
        </div>
        @if (count($errors) > 0)
        <div class="col-md-12 alert alert-danger">
          <p>Corrige los siguientes errores:</p>
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif 

        {!!Form::model($material,['method'=>'PATCH','route'=>['almacen.materiales.update',$material->id],'files'=>'true'])!!}
        
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" > 
          <div class="form-group">
            <label control-label">Nombre: <strog class="theme_color">*</strog></label>              
            <input name="nombre" type="text" value="{{$material->nombre}}"  maxlength="30" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese el Nombre del Producto"/>
          </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" > 
         <div class="form-group">
           <label for="imagen">Imagen</label>
           <input type="file" name="imagen" value="{{$material->imagen}}" class="form-control">
           @if (($material->imagen)!="")
           <img src="{{asset('imagenes/almacenmaterial/'.$material->imagen)}}" height="100px" width="100px">
           @endif
         </div>
       </div>


       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" > 
         <div class="form-group">
          <label control-label">Descripción: <strog class="theme_color">*</strog></label>
          <input name="descripcion" value="{{$material->descripcion}}" type="text"  maxlength="30" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese la Descripción"/>
        </div> 
      </div>
      

      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" > 
       <div class="form-group">
        <label  control-label">Cantidad en Almacén <strog class="theme_color">*</strog></label>
        <input name="cantidad" value="{{$material->cantidad}}" maxlength="9" type="number" value="1" min="1" max='9999999' step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese la Cantidad en Almacén" onkeypress=" return soloNumeros(event);" />
      </div>    
    </div>  
    
    
    


    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" > 
     <div class="form-group">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="{{url('/almacen/materiales')}}" class="btn btn-default"> Cancelar</a>
    </div>
  </div><!--/form-group-->

</form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->


{!!Form::close()!!}

@endsection
