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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Entrada de Agroquímico</strong></h2>
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
        <form action="{{route('almacen.entradas.agroquimicos.store')}}" method="post"  row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">

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

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
         <div class="form-group">
          <label ><strong>Proveedor de Material : <strog class="theme_color">*</strog></strong></label>

          <select name="provedor" id="prov" value="prov"  class="form-control select2" required>  
            @foreach($provedor as $emp)
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
       <label ><strong>Empresa : <strog class="theme_color">*</strog></strong></label>

       <select name="empresaEncargadaCompra" id="empresaCompra"   class="form-control select2" required>  
        @foreach($empresas as $emp)
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
     <label ><strong>Entregado a : <strog class="theme_color">*</strog></strong></label>
     <div >
      <select name="empleadoEntrega"   class="form-control select2" required>  
        @foreach($empleado as $emp1)
        <option value="{{$emp1->id}}">
         {{$emp1->nombre}} {{$emp1->apellidos}} 
       </option>
       @endforeach              
     </select>
     <div class="help-block with-errors"></div>
   </div>
 </div>
</div>
</div>


<div class="row">

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
   <div class="form-group">
    <label><strong>Recibe en Almacén CEPROZAC : <strog class="theme_color">*</strog></strong></label>
    <div >
      <select name="empleadoRecibe" class="form-control select2" required>  
        @foreach($empleado as $emp2)
        <option value="{{$emp2->id}}">
         {{$emp2->nombre}} {{$emp2->apellidos}}
       </option>
       @endforeach              
     </select>
     <div class="help-block with-errors"></div>
   </div>
 </div>
</div>


<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
  <div class="form-group">
    <label><strong>Observaciónes: <strog class="theme_color"></strog></strong></label>
    <div >
      <input name="observaciones" id="observacionesq" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control"  placeholder="Ingrese Observaciónes de la Compra"/>
    </div>
  </div>
</div>

</div>


<div class="row">
 <div class="panel panel-success" >  

  <div class="panel-body">


    <div class="row">


      <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group"> 
          <label for="material"><strong>Material:</strong> </label>
          <select name="id_material"   class="form-control select"  onchange="obtnerMedida();obtenerUnidadMedida();
          limpiarErrorProducto();" data-live-search="true"   id="idMaterial" >  
          <option>
            SELECIONA UN PRODUCTO
          </option>
          @foreach($material as $mat)
          <option value="{{$mat->idAgroquimico}}">
           {{$mat->nombreAgroquimico}} {{$mat->nombreUnidad}} DE {{$mat->cantidadMedida}} {{$mat->NombreUnidadP}}
         </option>
         @endforeach              
       </select>
       <span id="errorPrdducto" style="color:#FF0000;"></span>
     </div><!--/form-group--> 
   </div>




   <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
    <div class="form-group"> 
      <label for="preciou"><strong>Precio Unitario: </strong> </label>
      <div class="input-group"> <span class="input-group-addon">$</span>
        <input type="text" id="precioUnitario" class="form-control" onfocus ="limpiarPrecioUnitario();" onchange="limpiarErrorPrecioUnitario();"  
        placeholder="19.54" value="0.00">
      </div>
      <span id="errorprecio" style="color:#FF0000;"></span>
    </div>    
  </div>


  <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
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






 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
  <div class="form-group"> 
    <label for="preciou"><strong>% IEPS: </strong> </label>
    <input name="ieps" id="ieps"  type="text" class="form-control"
    onfocus="limpiarIEPS()" ; 
    onkeypress=" return soloNumeros(event);" placeholder="5" onchange="limpiarErrorIEPS();" value="0" />
    <span id="errorIEPS" style="color:#FF0000;" ></span>
  </div>    
</div>

</div>



<div class="row">

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>Unidad de Medida:</strong></label>
      <div >
        <div class="input-group"> <span class="input-group-addon">Completas</span>
          <input id="unidadesCompletas" type="text" class="form-control" placeholder="2">
        </div>
      </div>
    </div><!--/form-group-->
  </div>


  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group"> 
      <label ><strong>Contenedor </strong> </label>
      <input id="contenedor" name="unidadAux"  value="Medida" class="form-control currency" readonly="" />
    </div>    
  </div>


  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>Unidad de Medida:</strong></label>
      <div >
        <div  class="input-group" > <span id="unidadCentral"  class="input-group-addon">Kilogramos</span>
          <input  id="Medida"  type="text" class="form-control" placeholder="0">
        </div>
      </div>
    </div><!--/form-group-->
  </div>

</div>


<div class="row">

  <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
    <div class="form-group">
      <label ><strong>&nbsp;</strong></label>
      <div >
        <div class="input-group" > <span id="unidadDeMedida" class="input-group-addon">Gramos</span>
          <input type="text" class="form-control"  id="unidadMinima" placeholder="0">
        </div>
      </div>
    </div><!--/form-group-->
  </div>

  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    <div class="form-group">
      <label ><strong>&nbsp; </strong></label>
      <div >

        <button type="button" id="btn_add" onclick="agregarProducto();validar();calcularCantidad();" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>

</div>


<div class="form-group"  class="table-responsive"> 
  <table id="detalles"  class="table table-responsive-xl table-bordered">
    <thead style="background-color:#A9D0F5">
      <th  width="10%">Opciones</th>
      <th width="30%">Articulo</th>
      <th width="30%">Cantidad </th>
      <th width="7.5%">Precio Unitario</th>
      <th width="7.5%">IVA</th>
      <th width="7.5%">IEPS</th>
      <th width="7.5%">Subtotal</th>
    </thead>
  </table>


  <div class="row">
    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-8">
      <div class="form-group"> 
        <label  for="subtotal"><strong>Total</strong> </label>
        <input name="subtotal" id="subtotal" type="number" value="0"  maxlength="5" class="form-control"  readonly/>
      </div>    
    </div>

    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-8">
     <div class="form-group"> 
      <label for="total"><strong>Total de Elementos</strong> </label>
      <input name="total" id="total" type="number"  class="form-control"  readonly/>
    </div>    
  </div>  
</div>

</div>
</div>



<div class="form-group">
  <div class="col-sm-offset-7 col-sm-5">
    <button type="submit" id="submit" onclick="return save();" class="btn btn-primary">Guardar</button>
    <a href="{{url('/almacen/entradas/agroquimicos')}}" class="btn btn-default"> Cancelar</a>
  </div>
</div><!--/form-group-->

</div>

</form>

</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->
</html> 


<script type="text/javascript">

  function agregarProducto() {

    var select = document.getElementById("idMaterial");
    var options=document.getElementsByTagName("option");
    var idMaterial= select.value;
    var x = select.options[select.selectedIndex].text;
    var iva = document.getElementById("iva").value;
    var ieps = document.getElementById("ieps").value;

    var precioUnitario = document.getElementById("precioUnitario").value;
    var precioRedondeado=precioUnitario*(1+(iva/100))*(1+(ieps/100));
    precioRedondeado = precioRedondeado.toFixed(2);
    if(!validarProductosDuplicados(x) && !validar()==false ){
      var fila="<tr>"+
      "<td width=\"10%\">"+"<button type=\"button\"  onclick=\"myDeleteFunction(this)\" class=\"btn btn-danger btn-icon\">"+
    "Quitar<i class=\"fa fa-times\"></i> </button>"+"</td>"+ //Coclumna 1
    "<td width=\"30%\">"+x+"</td>"
    +"<td  width=\"30%\">"+calcularCantidad()+"</td>"
    +"<td  width=\"7.5%\" style=\"text-align:right\">"+precioUnitario+"</td>"
    +"<td  width=\"7.5%\" style=\"text-align:right\">"+iva+"%"+"</td>"
    +"<td  width=\"7.5%\" style=\"text-align:right\">"+ieps+"%"+"</td>"
    +"<td  width=\"7.5%\" style=\"text-align:right\">"+"$"+precioRedondeado+"</td>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById("detalles").appendChild(btn);
    limpiar();
  //  validarRolesCrear();
} 

}



function calcularCantidad(){


  var select = document.getElementById("idMaterial");
  var options=document.getElementsByTagName("option");
  var idMaterial= select.value;
  var idUnidadMedida;

  var unidadesCompletas =parseInt(document.getElementById('unidadesCompletas').value);
  var unidadCentral = parseInt(document.getElementById('Medida').value);
  var unidadesMedida = parseInt(document.getElementById('unidadMinima').value);
  var nombreUnidadMedida;

  var capacidad=0;;
  var totalUnidadesCompletas;

  var total;
  var route = "http://localhost:8000/obtenerPropiedadesAgroquimicos/"+idMaterial;
  $.get(route,function(res){

   idUnidadMedida= res.idUnidadMedida;

   var routePropiedadesUnidadMedida = "http://localhost:8000/propiedadesUnidadMedidaCantidadJson/"+idUnidadMedida;
   $.get(routePropiedadesUnidadMedida,function(resPropiedadesUnindadMedida){

    nombreUnidadMedida = resPropiedadesUnindadMedida.nombreUnidadMedida;
    capacidad = resPropiedadesUnindadMedida.cantidad; 
    totalUnidadesCompletas = unidadesCompletas * capacidad; 

    total = calcularEquivalencia(nombreUnidadMedida,totalUnidadesCompletas,unidadCentral,unidadesMedida); 
  });

 });

  return total;
}


function calcularEquivalencia(unidadDeMedida,unidadesCompletas,unidadCentral,unidadesMedida){

  if(unidadDeMedida == "LITROS"){
    total=unidadesCompletas*1000+ unidadCentral * 1000 +unidadesMedida  ;
    return total;
  }

  else if (unidadDeMedida =="KILOGRAMOS") {

    total=unidadesCompletas*1000+ unidadCentral * 1000 +unidadesMedida  ;
    return total;
  }

  else if (unidadDeMedida=="METROS") {
    total=unidadesCompletas*100+ unidadCentral * 100 +unidadesMedida  ;
    return total;
  }
  else if(unidadDeMedida=="UNIDADES"){
    total = unidadesCompletas + unidadCentral;
    return total;
  } else if(unidadDeMedida=="GRAMOS"){
    total = unidadesCompletas + unidadCentral;
    return total;
  } else if(unidadDeMedida=="MILILITROS"){
    total = unidadesCompletas + unidadCentral;
    return total;
  } else if(unidadDeMedida=="CENTIMETROS"){
    total = unidadesCompletas + unidadCentral;
    return total;
  } 

}


</script>

@endsection