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
      <li><a style="color: #808080" href="{{url('/almacenes/limpieza')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacenes/entradas/limpieza')}}">Entradas de Almacén Limpieza</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Entrada de Limpieza</strong></h2>
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
        <form action="{{route('almacen.entradas.limpieza.store')}}" mmethod="post"  row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">

          {{csrf_field()}}

          <input name="numeroFacturaOculto" id="numeroFacturaOculto"  hidden  />

          <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label><strong>Número de Factura: <strog class="theme_color">*</strog></strong></label>
                <div >
                  <input name="numeroFactura" id="numeroFactura"  type="text"  maxlength="10" onchange="mayus(this);validarFactura();"  class="form-control"  placeholder="Ingrese el Número de Factura" required />

                  <span id="errorNumeroFactura" style="color:#FF0000;"></span>


                </div>
              </div>
            </div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label ><strong>Fecha de Compra de Material: <strog class="theme_color">*</strog></strong></label>
                <div >

                 <input type="date" name="fechaCompra" id="fecha"  class="form-control mask" >
               </div>
             </div>
           </div>
         </div>


         <div class="row">

          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
           <div class="form-group">
            <label ><strong>Proveedor de Material : <strog class="theme_color">*</strog></strong></label>

            <select name="prov" id="prov"   class="form-control select" required>  
              @foreach($provedor as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>



       <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
         <div class="form-group">
          <label ><strong>Empresa : <strog class="theme_color">*</strog></strong></label>

          <select name="empresaEncargadaCompra" id="empresaCompra"  class="form-control select" required>  
            @foreach($empresas as $emp)
            <option value="{{$emp->id}}">
             {{$emp->nombre}} 
           </option>
           @endforeach              
         </select>
         <div class="help-block with-errors"></div>
       </div>
     </div>
   </div>

   <div class="row">

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
     <div class="form-group">
      <label ><strong>Entregado a : <strog class="theme_color">*</strog></strong></label>
      <div >

        <select name="empleadoEntrega"   id="empleadoEntrega" class="form-control select" required>  
          @foreach($empleado as $emp)
          <option value="{{$emp->id}}">
           {{$emp->nombre}} {{$emp->apellidos}} 
         </option>
         @endforeach              
       </select>
       <div class="help-block with-errors"></div>
     </div>
   </div>
 </div>

 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
   <div class="form-group">
    <label><strong>Recibe en Almacén CEPROZAC : <strog class="theme_color">*</strog></strong></label>

    <div >
      <select name="empleadoRecibe" id="empleadoRecibe" value=""  class="form-control select" required>  
        @foreach($empleado as $emp)
        <option value="{{$emp->id}}">
         {{$emp->nombre}} {{$emp->apellidos}} 
       </option>
       @endforeach              
     </select>
     <div class="help-block with-errors"></div>
   </div>
 </div>
</div>

<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
  <div class="form-group">
    <label><strong>Observaciónes: <strog class="theme_color"></strog></strong></label>
    <div >
      <input name="observaciones" id="observaciones" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control" placeholder="Ingrese Observaciones de la Compra"/>
    </div>
  </div>
</div>
</div>


<div class="row">
 <div class="panel panel-success" >  
  <div class="panel-body">



    <div class="row">   

     <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
      <div class="form-group">
        <label for="material"><strong>Buscar Código de Barras:</strong> </label>
        <input  id="codigo" value="" name="codigo" type="text" onkeypress="return teclas(event);"  maxlength="35"  class="form-control"  placeholder="Ingrese el Código de Barras"/>
      </div>
    </div>  



    <div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
      <div class="form-group"> 
        <label for="material"><strong>Material:</strong> </label>
        <select name="id_material"   class="form-control select"  onchange="obtnerMedida();obtenerUnidadMedida();
        limpiarErrorProducto();" data-live-search="true"   id="idMaterial" >  
        <option>
          SELECIONA UN PRODUCTO
        </option>
        @foreach($material as $mat)
        <option value="">

        </option>
        @endforeach              
      </select>
      <span id="errorProducto" style="color:#FF0000;"></span>
    </div><!--/form-group--> 
  </div>

  <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
    <div class="form-group"> 
      <label for="preciou"><strong>Precio Unitario: </strong> </label>
      <div class="input-group"> <span class="input-group-addon">$</span>
        <input type="text" id="precioUnitario" class="form-control" onfocus ="limpiarPrecioUnitario();" onchange="limpiarErrorPrecioUnitario();"  
        placeholder="0.00" value="0.00">
      </div>
      <span id="errorprecio" style="color:#FF0000;"></span>
    </div>    
  </div>

  <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
    <div class="form-group"> 
      <label for="material"><strong>IVA</strong> </label>
      <select name="iva" id="iva"  class="form-control select"  required  >  

        <option value="0">
         0%
       </option>
       <option value="16">
         16%
       </option>

     </select>
     <div class="help-block with-errors"></div>
   </div><!--/form-group--> 
 </div>

 <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
  <div class="form-group"> 
    <label for="preciou"><strong>% IEPS: </strong> </label>
    <input name="ieps" id="ieps"  type="text" class="form-control"
    onfocus="limpiarIEPS()" ; 
    onkeypress=" return soloNumeros(event);" placeholder="0" onchange="limpiarErrorIEPS();" value="0" />
    <span id="errorIEPS" style="color:#FF0000;" ></span>
  </div>    
</div>

</div>


<div class="row">

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group"> 
      <label ><strong>Unidades de Medida</strong> </label>
      <input id="contenedor" name="unidadAux"  value="Medida" class="form-control currency" readonly="" placeholder="0"/>
    </div>    
  </div>

</div>

<div class="row">
  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>Canitdades: </strong></label>
      <div >
        <div class="input-group"> <span class="input-group-addon">Completas</span>
          <input id="unidadesCompletas" type="text" class="form-control" placeholder="0">
        </div>
      </div>
    </div><!--/form-group-->
  </div>

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>&nbsp;</strong></label>
      <div >
        <div  class="input-group" > <span id="unidadCentral"  class="input-group-addon"></span>
          <input  id="Medida"  type="text" class="form-control" placeholder="0">
        </div>
      </div>
    </div><!--/form-group-->
  </div>


  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>&nbsp;</strong></label>
      <div >
        <div class="input-group" > <span id="unidadDeMedida" class="input-group-addon"></span>
          <input type="text" class="form-control"  id="unidadMinima" placeholder="0">
        </div>
      </div>
    </div><!--/form-group-->
  </div>

</div>

<div class="row">
  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
    <div class="form-group" >
      <label ><strong>&nbsp; </strong></label>
      <div >
      </div>
      <button type="button" id="btn_add" onclick="agregarProducto();validar();calcularCantidad();" class="btn btn-primary">Agregar</button>
    </div>
  </div>

</div>


<div class="form-group"  class="table-responsive"> 
  <table id="detalles"  class="table table-responsive-xl table-bordered">
    <thead style="background-color:#A9D0F5">
      <th  width="10%">Opciones</th>
      <th width="35%">Articulo</th>
      <th width="10%">Cantidad </th>
      <th width="12.5%">Precio Unitario</th>
      <th width="10%">IVA</th>
      <th width="10%">IEPS</th>
      <th width="12.5%">Subtotal</th>
    </thead>
  </table>

  <label ><strong>&nbsp; </strong></label>
  <div class="row" >

    <div class="col-lg-10 col-sm-9 col-md-9 col-xs-12" >
    </div>
    <div class="col-lg-2 col-sm-3 col-md-3 col-xs-12" >
      <div class="form-group">
       <label ><strong>Tipo de Moneda: <strog class="theme_color">*</strog></strong></label>
       <div >
        <select name="tipoMoneda"  id ="moneda" class="form-control select" data-live-search="true"  value="{{Input::old('moneda')}}">
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
  </div>
</div>

<div class="row" >
  <div class="form-group">
    <div class="col-lg-10  col-xs-12" >
    </div>
    <button type="submit" id="submit" onclick="return save();" class="btn btn-primary">Guardar</button>
    <a href="{{url('/almacen/entradas/limpieza')}}" class="btn btn-default"> Cancelar</a>
  </div>

</div><!--/form-group-->

</div>

</div>
</div>
</div>
</form>

</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->


@include('almacen.empaque.entradas.modale')
@endsection