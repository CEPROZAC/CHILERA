@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Fumigaciones</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('fumigaciones')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('fumigaciones')}}">Fumigaciones</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Fumigacion</strong></h2>
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
        <form action="{{route('almacenes.agroquimicos.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate  files="true" enctype="multipart/form-data" accept-charset="UTF-8">
          {{csrf_field()}}



      <div class="form-group">
       <label class="col-sm-3 control-label">Hora de Inicio de La Fumigación: <strog class="theme_color">*</strog></label>
       <div class="col-sm-6">
        <input id="inicio" name="inicio" type="time" required>
        <div class="help-block with-errors"></div>
      </div>
    </div><!--/form-group-->

    <div class="form-group">
      <label class="col-sm-3 control-label">Fecha de Inicio: <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">

       <input type="date" name="fechai" id="fechai" value="" class="form-control mask" required>
     </div>
   </div>

   <div class="form-group">
    <label class="col-sm-3 control-label">Fecha de Termino: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">

     <input type="date" name="fechaf" id="fechaf" value="" class="form-control mask" required >
   </div>
 </div>

 <div class="form-group">
   <label class="col-sm-3 control-label">Hora de Termino de La Fumigación: <strog class="theme_color">*</strog></label>
   <div class="col-sm-6">
    <input id="final" name="final" type="time" required>
    <div class="help-block with-errors"></div>
  </div>
</div><!--/form-group-->




<div class="form-group">
 <label class="col-sm-3 control-label">Lote: <strog class="theme_color">*</strog></label>
 <div class="col-sm-6">
  <select name="lote" id="lote"  class="form-control select2" required>

    @foreach($espacio as $almacen)
    <option value="{{$almacen->id}}}">
     PRODUCTO : {{$almacen->nombre_lote}} {{$almacen->almnom}} 
   </option>
   @endforeach
 </select>
 <div class="help-block with-errors"></div>
</div>
</div><!--/form-group-->




<div class="form-group">
 <label class="col-sm-3 control-label">Fumigador: <strog class="theme_color">*</strog></label>
 <div class="col-sm-6">
  <select name="fumigador" id="fumigador"  class="form-control select" required>
    @foreach($empleado as $empleados)
    <option value="{{$empleados->id}}}">
     {{$empleados->nombre}} {{$empleados->apellidos}} 
   </option>
   @endforeach
 </select>
 <div class="help-block with-errors"></div>
</div>
</div><!--/form-group-->

<div class="form-group">
 <label class="col-sm-3 control-label">Entrego Agroquimicos de Almacén: <strog class="theme_color">*</strog></label>
 <div class="col-sm-6">
  <select name="entrego_qui" id="entrego_qui"  class="form-control select" required>
    @foreach($empleado as $empleados)
    <option value=" {{$empleados->nombre}} {{$empleados->apellidos}}">
     {{$empleados->nombre}} {{$empleados->apellidos}} 
   </option>
   @endforeach
 </select>
 <div class="help-block with-errors"></div>
</div>
</div><!--/form-group-->

<div class="form-group">
  <label class="col-sm-3 control-label">Observaciónes: <strog class="theme_color"></strog></label>
  <div class="col-sm-6">

    <input name="observacionesf" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" value="" placeholder="Ingrese Observaciónes de la Fumigación"/>
  </div>
</div>



<div class="col-lg-4 col-lg-offset-4">
 <div class="form-group">
  <label class="col-sm-6 control-label">Buscar Codigo de Barras: <strog class="theme_color">*</strog></label>
  <div class="col-sm-6">
    <input  id="codigo" value="" name="codigo" type="text" onKeyUp="codigos()"  maxlength="13"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
  </div>
</div>
</div>

<div class="form-group">
</div>

<div class="form-group">
 <label class="col-sm-3 control-label">Agroquímicos a Aplicar: <strog class="theme_color">*</strog></label>
 <div class="col-sm-6">
  <select name="quimicos" id="quimicos"  class="form-control select" required>
    @foreach($almacenagroquimicos as $quimico)
    <option value="{{$quimico->id}}_{{$quimico->nombre}}_{{$quimico->codigo}}_{{$quimico->descripcion}}_{{$quimico->cantidad}}_{{$quimico->medida}}">
     {{$quimico->nombre}} 
   </option>
   @endforeach
 </select>
   <span id="erroragro" style="color:#FF0000;"></span>
 <div class="help-block with-errors"></div>
</div>
<a class="btn btn-sm btn-danger"   style="margin-right: 10px;"  onclick="agroquimico();" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Agregar Agroquimico"> <i class="fa fa-plus"></i>Agregar</a>
</div><!--/form-group-->





<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
 <div class="form-group"> 
  <label for="scantidad">Cantidad Aplicada <strog class="theme_color">*</strog></label>
  <input name="scantidad" id="scantidad" type="number" value="1" max="1000000" min="1" required="" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" maxlength="5"  />
</div>    
  <span id="errorcantidad" style="color:#FF0000;"></span>
</div>  

<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
 <div class="form-group"> 
  <label for="pcantidad">Cantidad en Almacén <strog class="theme_color">*</strog></label>
  <input name="pcantidad" id="pcantidad" value="" type="number" disabled class="form-control" />
</div>    
</div>  
<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
 <div class="form-group"> 
  <label for="amedida">Medida </label>
  <input name="amedida" id="amedida" value="" type="text" disabled class="form-control" />
</div>
</div>  

<div class="col-sm-4">
 <div class="form-group"> 
  <label for="descripciona">Descripción </label>
  <input name="descripciona" id="descripciona" disabled class="form-control" />
</div>    
</div> 

<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
  <div class="form-group"> 
    <table id="detalles" name="detalles[]" value="" class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>N°</th>
        <th>Nombre de Agroquimico</th>
        <th>Descripcion</th>
        <th>Cantidad Aplicada</th>

      </thead>
      <tfoot>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tfoot>
      <tbody>

      </tbody>

    </table>

    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
     <div class="form-group"> 
      <label for="total">Total de Elementos </label>
      <input name="total" id="total" type="number"  class="form-control"  readonly/>
    </div>    
  </div>  
</div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Estado de la Fumigacion: <strog class="theme_color">*</strog></label>
  <div class="col-sm-6">
    <select name="status" value="{{Input::old('status')}}" required>
      @if(Input::old('status')=="Proceso")
      <option value='Proceso' selected>En Proceso
      </option>
      <option value="Realizada">Realizada</option>
      @else
      <option value='Realizada' selected>Realizada
      </option>
      <option value="Proceso">En Proceso</option>
      @endif
    </select>

  </div>
</div>

<div class="form-group">
  <div class="col-sm-6">
    <input  id="codigo2" value="" name="codigo2[]" type="hidden"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
  </div>
</div>

<div class="form-group">
  <div class="col-sm-6">
    <input  id="nombre_fum" value="" name="nombre_fum" type="hidden"  class="form-control""/>
  </div>
</div>

    <div class="form-group">
      <div class="col-sm-offset-7 col-sm-5">
        <button type="submit" id="submit" class="btn btn-primary">Guardar</button>
        <a href="{{url('/fumigaciones')}}" class="btn btn-default"> Cancelar</a>
      </div>
    </div><!--/form-group-->



  </form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>
@include('almacen.agroquimicos.modalreactivar')
@endsection