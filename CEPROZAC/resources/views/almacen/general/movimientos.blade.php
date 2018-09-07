@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">

    <h1>Inicio</h1>
    <h2 class="">Almacén</h2>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/almacenes/agroquimicos')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacenes/agroquimicos')}}">Entradas de Almacén Agroquímicos</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Mover Producto de Almacén : {{$almacen->nombre_lote}} </strong></h2>
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
        <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('codigo')}}</div>
        <form action="{{route('almacen.entradas.agroquimicos.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">

          {{csrf_field()}}



          <div class="form-group">
            <label class="col-sm-3 control-label">Lote Actual: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" name="lotea" id="lotea" value="{{$almacen->nombre_lote}}" class="form-control mask" readonly="" >
           </div>
         </div>

               <div class="form-group">
            <label class="col-sm-3 control-label">Almacén Origen: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" name="almacena" id="almacena" value="{{$almacen->almanombre}}" class="form-control mask" readonly="" >
           </div>
         </div>

                        <div class="form-group">
            <label class="col-sm-3 control-label">Calidad: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" name="calidada" id="calidada" value="{{$almacen->calidadnombre}}" class="form-control mask" readonly="" >
           </div>
         </div>


                        <div class="form-group">
            <label class="col-sm-3 control-label">Proveedor: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" name="proveedora" id="proveedora" value="{{$almacen->nombreprov}}  {{$almacen->apellidos}}" class="form-control mask" readonly="" >
           </div>
         </div>

                                 <div class="form-group">
            <label class="col-sm-3 control-label">N° Fumigaciónes Aplicadas: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" name="fuma" id="fuma" value="{{$almacen->num_fumigaciones}}" class="form-control mask" readonly="" >
           </div>
         </div>

                                                             <div class="form-group">
                        <label class="col-sm-3 control-label">Almacén Destino: <strog class="theme_color">*</strog></label>
                        <div class="col-sm-6">
                          <select name="almacendest"  id="almacendest" class="form-control select2" required>  
                            @foreach($almacengeneral as $almacendest)
                            <option value="{{$almacendest->id}}">
                             {{$almacendest->nombre}}
                           </option>
                           @endforeach              
                         </select>
                         <div class="help-block with-errors"></div>
                       </div>
                     </div><!--/form-group-->
                   
                                                                                <div class="form-group">
                        <label class="col-sm-3 control-label">Espacio Asignado: <strog class="theme_color">*</strog></label>
                        <div class="col-sm-6">
                          <select name="almacendest"  id="almacendest" class="form-control select2" required>  
                            @for($x= 1; $x <= 10; $x++)
                            <option value="{{$almacen->num_fumigaciones}}">
                             {{$x}}
                           </option>
                           @endfor             
                         </select>
                         <div class="help-block with-errors"></div>
                       </div>
                     </div><!--/form-group-->

         



<div class="container clear_both padding_fix">
  <div class="block-web">
   <div class="row">
    <div class="panel panel-primary"> 

      <div class="panel-body">


       <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
         <div class="form-group"> 
          <label for="scantidad">Cantidad de Salida </label>
          <input name="scantidad" id="scantidad" type="number" value="0" max="1000000" min="1" required="" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" maxlength="5"  />
            <span id="errorCantidad" style="color:#FF0000;"></span>
        </div>    
      </div>  

      <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
       <div class="form-group"> 
        <label for="pcantidad">Cantidad en Almacén </label>
        <input name="pcantidad" id="pcantidad" value="{{$almacen->cantidad_act}}" type="number" disabled class="form-control" />
      </div>    
    </div>  

    <div class="col-sm-4">
     <div class="form-group"> 
      <label for="descripcion">Unidad de Medida </label>
      <input name="medida" id="medida" disabled value="{{$almacen->medida}}"  class="form-control" />
    </div>    
  </div>  



  







</div>
</div>






</div>




<div class="form-group">
  <div class="col-sm-offset-7 col-sm-5">
    <button type="submit" onclick="return save();" class="btn btn-primary">Guardar</button>
    <a href="{{url('/almacen/entradas/agroquimicos')}}" class="btn btn-default"> Cancelar</a>
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