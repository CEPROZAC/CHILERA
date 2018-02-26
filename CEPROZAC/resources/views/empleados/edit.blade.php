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
      <li><a style="color: #808080" href="{{url('/empleados')}}">Inicio</a></li>
      <li><a  style="color: #808080" href="{{url('/empleados')}}">Empleados</a></li>
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
          <form action="{{url('empleados',[$empleado->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}

            <input type="hidden" name="_method" value="PUT">

            <input  name="fecha_Nacimiento" type="hidden" id="fechaNacimiento" value="{{$empleado->fecha_Nacimiento}}"  />
            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="nombre" type="text"  maxlength="30" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="{{$empleado->nombre}}" placeholder="Ingrese nombre de el Empleado"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Apellidos: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="apellidos" type="text"  maxlength="30" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="{{$empleado->apellidos}}" placeholder="Ingrese nombre de el Cliente"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Fecha Ingreso: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

               <input name="fecha_Ingreso" type="text" class="form-control mask" data-inputmask="'alias': 'date'" value="{{$empleado->fecha_Ingreso}}">
             </div>
           </div>

           <div class="form-group">
            <label class="col-sm-3 control-label">Fecha Alta seguro: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="text" name="fecha_Alta_Seguro" class="form-control mask" data-inputmask="'alias': 'date'" value="{{$empleado->fecha_Alta_Seguro}}">
           </div>
         </div>

         <div class="form-group">
          <label class="col-sm-3 control-label">SSN</label>
          <div class="col-sm-6 ">
            <input type="text" name="numero_Seguro_Social" type="numero_Seguro_Social" class="form-control mask" data-inputmask="'mask':'999-99-9999'" value="{{$empleado->numero_Seguro_Social}}">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">CURP<strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <input name="curp"  maxlength="18" id="curp" type="text" required parsley-regexp="([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)"   required parsley-rangelength="[18,18]"  onkeypress="mayus(this);" onblur="curp2date();"  class="form-control"   placeholder="Ingrese CURP de el empleado" value="{{$empleado->curp}}" />
          </div>
        </div><!--/form-group-->

        <div class="form-group">
          <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <input type="text" name="telefono" placeholder="Ingrese el número de teléfono de Empleado" name="telefono"  class="form-control mask" data-inputmask="'mask':'(999) 999-9999'" value="{{$empleado->telefono}}">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">

            <input name="email"  required parsley-type="email" class="form-control mask" placeholder="Ingrese email de el cliente" value="{{$empleado->email}}"/>

          </div>
        </div>


        <div class="form-group">
          <label class="col-sm-3 control-label">Rol empleado: <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="rol" class="form-control" required>  
             @foreach($roles as $rol)
             @if($rol->id==$empleado->rol)
             <option value="{{$rol->id}}" selected>
             {{$rol->rol_Empleado}}
             </option>
             @else
             <option value="{{$rol->id}}">
               {{$rol->rol_Empleado}}
             </option>
             @endif
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div><!--/form-group-->

       <div class="form-row">    
        <label class="col-sm-3 control-label">Sueldo empleado: <strog class="theme_color">*</strog></label>
        <div class="col-sm-2">
          <div class="input-group">
           <div class="input-group-addon">$</div>


           <input name="sueldo_Fijo" maxlength="9" type="number" value="1000.00" min="1" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Saldo Inicial" onkeypress=" return soloNumeros(event);" value="{{$empleado->sueldo_Fijo}}" />
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
