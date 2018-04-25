@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class=""> Proveedores</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/materiales/provedores')}}">Inicio</a></li>
      <li><a  style="color: #808080" href="{{url('/materiales/provedores')}}"> Proveedores</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Proveedor de Materiales</strong></h2> 
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
        <form method="post" action="{{url('materiales/provedores/validar')}}" class="form-horizontal row-border" parsley-validate novalidate id='form'>
          {{csrf_field()}}
          <div class="form-group">
            <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

              <input name="nombre" type="text"  onchange="mayus(this);"  value="{{Input::old('nombre')}}" class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre del Provedor" maxlength="80" parsley-rangelength="[1,70]"/>
              <div class="text-danger" id='error_nombre'>{{$errors->formulario->first('nombre')}}</div>

            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">RFC: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="rfc" type="text"  onchange="mayus(this);" value="{{Input::old('rfc')}}"  class="form-control" maxlength="13" id="RFC" type="text" required parsley-regexp="([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})"   required parsley-rangelength="[12,13]"  onkeyup="mayus(this);"   required value="" placeholder="Ingrese RFC del Proveedor"/>
              <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('rfc')}}</div>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input type="text" parsley-type="phone" value="{{Input::old('telefono')}}" placeholder="Ingrese el número de teléfono de proveedor" name="telefono" value="" class="form-control mask" data-inputmask="'mask':'(999) 999-9999'">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Direccion: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

              <input name="direccion" type="text"  value="{{Input::old('direccion')}}" onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese Direccion de proveedor" maxlength="150" parsley-rangelength="[1,150]" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="email" name="email"  value="{{Input::old('email')}}" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de proveedor"/>
            </div>
          </div>

          
          <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{url('/materiales/provedores')}}" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
        </form>
      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->

</html>
<script>
 $(function(){
   $("#form").submit(function(e){

     var fields = $(this).serialize();
     $.post("{{url('materiales/provedores/validar')}}", fields, function(data){

       if(data.valid !== undefined){
         $("#result").html("Enhorabuena formulario enviado correctamente");
         $("#form")[0].reset();
         $("#error_nombre").html('');
         $("#error_email").html('');
       }
       else{
         $("#error_nombre").html('');
         $("#error_email").html('');
         if (data.nombre !== undefined){
          $("#error_nombre").html(data.nombre); 
        }
        if (data.email !== undefined){
         $("#error_email").html(data.email);
       }
     }
     
   });
     
     return false;
   });
 });
</script>
@endsection