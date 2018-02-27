@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class=""> Vehículos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/provedores')}}">Inicio</a></li>
      <li><a  style="color: #808080" href="{{url('/provedores')}}"> Vehículos</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Vehículos</strong></h2> 
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
          <form action="{{route('provedores.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}
            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="nombre" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese numero de serie de Vehículo" maxlength="35" parsley-rangelength="[1,35]"/>

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Numero de Serie: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="no_Serie" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de Vehículo" maxlength="35" parsley-rangelength="[1,35]"/>

              </div>
            </div>



            <div class="form-group">
              <label class="col-sm-3 control-label">Placas: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="no_Serie" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese placas del Vehículo" maxlength="35" parsley-rangelength="[1,35]"/>

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Poliza de Seguro: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="no_Serie" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese poliza de seguro de Vehículo" maxlength="35" parsley-rangelength="[1,35]"/>

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Vigencia Seguro: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

               <input name="fecha_Ingreso" type="text" class="form-control mask" data-inputmask="'alias': 'date'">
             </div>
           </div>

           <div class="form-group">
            <label class="col-sm-3 control-label">Aseguradora: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

              <input name="no_Serie" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Aseguradora a la  que esta afiliada Vehículo" maxlength="35" parsley-rangelength="[1,35]"/>

            </div>
          </div>


           <div class="form-group">
             <label class="col-sm-3 control-label">Capacidad de la unidad:</label>
             <div class="col-sm-6">
              <input parsley-type="number" type="text" class="form-control" required placeholder="Ingrese capacidad de la unidad en metros cubicos" />
            </div>
          </div><!--/form-group-->

             <div class="form-group">
              <label class="col-sm-3 control-label">Empleados<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="chofer_id" class="form-control" required>
                 @foreach($empleados as $empleado)
                 <option value="{{$empleado->id}}">
                  {{$empleado->nombre}}
                </option>
                @endforeach
              </select>
              <div class="help-block with-errors"></div>
            </div>
          </div><!--/form-group-->

          <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{url('/transportes')}}" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
        </form>
      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->

@endsection

