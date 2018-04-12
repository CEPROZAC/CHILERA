@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Servicio Basculas</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('serviciosBascula')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('serviciosBascula')}}">Servicio Basculas</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Agregar Servicio de Bascula</strong></h2> 
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
        <form action="{{url('serviciosBascula',[$servicioBascula->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
          {{csrf_field()}}
          <input type="hidden" name="_method" value="PUT">

          <div class="form-group">
            <label class="col-sm-3 control-label">Ticket: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="numeroTicket" type="text"  onchange="mayus(this);"  class="form-control" required  placeholder="Ingrese numero de Ticket" value="{{$servicioBascula->numeroTicket}}" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Tipo Vehiculo: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="idPrecioBascula" class="form-control" required>
                @foreach($precio_basculas as $precio)
                @if($precio->id==$servicioBascula->idVehiculo)
                <option value="{{$precio->id}}">
                 {{$empleado->nombre}}   {{$empleado->apellidos}}
               </option>
               @else
               <option value="{{$precio->id}}">
                 {{$precio->tipoVehiculo}}
               </option>
               @endif
               @endforeach
             </select>
             <div class="help-block with-errors"></div>
           </div>
         </div><!--/form-group-->

         <div class="form-group">
           <label class="col-sm-3 control-label">Cajero: <strog class="theme_color">*</strog></label>
           <div class="col-sm-6">
            <select name="idEmpleado" class="form-control" required>
              @foreach($empleados as $empleado)
              @if($empleado->id==$servicioBascula->idEmpleado)
              <option value="{{$precio->id}}">
               {{$empleado->nombre}}   {{$empleado->apellidos}}
             </option>
             @else
             <option value="{{$precio->id}}">
               {{$empleado->nombre}}   {{$empleado->apellidos}}
             </option>
             @endif
             @endforeach
           </select>
           <div class="help-blocks with-errors"></div>
         </div>
       </div><!--/form-group-->

       <div class="form-group">
         <label class="col-sm-3 control-label">Bascula: <strog class="theme_color">*</strog></label>
         <div class="col-sm-6">
          <select name="idBascula" class="form-control" required>
            @foreach($basculas as $bascula)
            @if($bascula->id==$servicioBascula->idBascula)
            <option value="{{$bascula->id}}" selected>
              {{$bascula->nombreBascula}} 
            </option>
            @else
            <option value="{{$bascula->id}}">
             {{$bascula->nombreBascula}} 
           </option>
           @endif
           @endforeach
         </select>
         <div class="help-block with-errors"></div>
       </div>
     </div><!--/form-group-->

     <div class="form-group">
      <div class="col-sm-offset-7 col-sm-5">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{url('/serviciosBascula')}}" class="btn btn-default"> Cancelar</a>
      </div>
    </div><!--/form-group-->


  </form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->

@endsection
