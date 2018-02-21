@extends('layouts.principal')
@section('contenido')
<html>
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Empleados</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/clientes')}}">Inicio</a></li>
      <li><a  style="color: #808080" href="{{url('/clientes')}}">Empleados</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Empleado</strong></h2>
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
          <form action="{{route('empleados.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}

            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="nombre" type="text"  maxlength="30" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de el Empleado"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Apellidos: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="nombre" type="text"  maxlength="30" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de el Cliente"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Fecha Ingreso: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

               <input type="text" class="form-control mask" data-inputmask="'alias': 'date'">
             </div>
           </div>

           <div class="form-group">
            <label class="col-sm-3 control-label">Fecha Alta seguro: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" class="form-control mask" data-inputmask="'alias': 'date'">
           </div>
         </div>

         <div class="form-group">
          <label class="col-sm-3 control-label">SSN</label>
          <div class="col-sm-6 ">
            <input type="text" class="form-control mask" data-inputmask="'mask':'999-99-9999'">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">

            <input name="email" name="email" value="" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de el cliente"/>

          </div>
        </div>

        <div class="form-row">    
          <label class="col-sm-3 control-label">Sueldo empleado: <strog class="theme_color">*</strog></label>
          <div class="col-sm-2">
            <div class="input-group">
             <div class="input-group-addon">$</div>

             
             <input name="saldocliente" maxlength="9" type="number" value="1000.00" min="1" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Saldo Inicial" onkeypress=" return soloNumeros(event);"/>
           </div>
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
