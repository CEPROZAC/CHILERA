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


         


<a class="btn btn-sm btn-success tooltips" href="{{ route('almacenes.agroquimicos.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" target="_blank" title="" data-original-title="Registrar nuevo Material"> <i class="fa fa-plus"></i> Registrar Nuevo Material </a>


<div class="col-lg-4 col-lg-offset-4">
 <div class="form-group">
  <label class="col-sm-6 control-label">Buscar Codigo de Barras: <strog class="theme_color">*</strog></label>
  <div class="col-sm-6">
  <input  id="codigo" value="" name="codigo" type="text" onkeypress="return teclas(event);"  maxlength="35"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
  </div>
</div>
</div>

<div class="container clear_both padding_fix">
  <div class="block-web">
   <div class="row">
    <div class="panel panel-primary"> 

      <div class="panel-body">


       <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
         <div class="form-group"> 
          <label for="scantidad">Cantidad de Entrada </label>
          <input name="scantidad" id="scantidad" type="number" value="1" max="1000000" min="1" required="" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" maxlength="5"  />
            <span id="errorCantidad" style="color:#FF0000;"></span>
        </div>    
      </div>  

      <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
       <div class="form-group"> 
        <label for="pcantidad">Cantidad en Almacén </label>
        <input name="pcantidad" id="pcantidad" value="" type="number" disabled class="form-control" />
      </div>    
    </div>  

    <div class="col-sm-4">
     <div class="form-group"> 
      <label for="descripcion">Descripción </label>
      <input name="descripcion" id="descripcion" disabled class="form-control" />
    </div>    
  </div>  

            <div class="col-lg-2">
          <div class="form-group">
            <label>Tipo de Moneda: <strog class="theme_color">*</strog></label>
              <select name="moneda"  id ="moneda" class="form-control select" data-live-search="true"  value="{{Input::old('moneda')}}">
                @if(Input::old('moneda')=="Peso MXM")
                <option value='Peso MXN' selected>Peso MXN
                </option>
                <option value="Dolar USD">Dolar USD</option>
                @else
                <option value='Dolar USD' selected>Dolar USD
                </option>
                <option value="Peso MXN">Peso MXN</option>
                @endif
              </select>          
            </div>
          </div>

  <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
   <div class="form-group"> 
    <label for="preciou">$ Precio Unitario </label>
    <input name="preciou" id="preciou" value="0" type="number" class="form-control" />
        <span id="errorprecio" style="color:#FF0000;"></span>
  </div>    
</div>    

  <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
   <div class="form-group"> 
    <label for="iva">% IVA </label>
    <input name="iva" id="iva" value="0" type="text" class="form-control" min="0" max="100" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IVA del Producto" />
  </div>    
</div> 

  <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
   <div class="form-group"> 
    <label for="ieps">% IEPS </label>
    <input name="ieps" id="ieps" value="0" type="text" class="form-control" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IEPS del Producto" />
  </div>    
</div>  






</div>



<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
  <div class="form-group"> 
    <button type="button" id="btn_add" onclick="agregar();" class="btn btn-primary">Agregar</button>
  </div>
</div>

</div>



<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
  <div class="form-group"> 
    <table id="detalles" name="detalles[]" value="" class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>N°Articulo</th>
        <th>Articulo</th>
        <th>Cantidad de Entrada</th>
        <th>N° Factura</th>
        <th>Fecha de Compra</th>
        <th>Precio Unitario</th>
        <th>IVA</th>
        <th>IEPS</th>
        <th>Subtotal</th>
        <th>Moneda</th>

      </thead>
      <tfoot>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
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
        <label  for="subtotal">Total </label>
        <input name="subtotal" id="subtotal" type="number" value="0"  maxlength="5" class="form-control"  readonly/>
      </div>    
    </div>

    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
     <div class="form-group"> 
      <label for="total">Total de Elementos </label>
      <input name="total" id="total" type="number"  class="form-control"  readonly/>
    </div>    
  </div>  



  <div class="form-group">
    <div class="col-sm-6">
      <input  id="codigo2" value="" name="codigo2[]" type="hidden"   class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
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