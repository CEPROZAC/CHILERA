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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Salida de Material</strong></h2>
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
          <form action="{{route('almacen.materiales.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate  files="true" enctype="multipart/form-data" accept-charset="UTF-8">


            {{csrf_field()}}


                  <div class="form-group">
          <label class="col-sm-3 control-label">Material : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="id_material" class="form-control" required>  
              @foreach($material as $mat)
              <option value="{{$mat->id}}">
               {{$mat->nombre}}
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div><!--/form-group-->


       <div class="form-group">
       @foreach($material as $mat)
               {{$mat->cantidad}}
            
              <label  class="col-sm-3 control-label">Cantidad en Almacén <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="cantidad" maxlength="9" type="number" value="1" min="1" max='{{$mat->cantidad}}' step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese la Cantidad en Almacén" onkeypress=" return soloNumeros(event);" />
               </div>    
               </div>  
                @endforeach 


            <div class="form-group">
              <label class="col-sm-3 control-label">Destino: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="destino" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese el Destino de el Material"/>
              </div>
            </div>

            <div class="form-group">
          <label class="col-sm-3 control-label">Entrego : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="entrego" class="form-control" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">Recibio : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="recibio" class="form-control" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>

        <div class="form-group">
              <label class="col-sm-3 control-label">Tipo de Movimiento: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="tipo_movimiento" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese el Tipo de Movimiento Realizado"/>
              </div>
            </div>



       






     <div class="form-group">
      <div class="col-sm-offset-7 col-sm-5">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/empleados" class="btn btn-default"> Cancelar</a>
      </div>
    </div><!--/form-group-->
  </form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->
</html> 
@endsection
