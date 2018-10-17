@inject('metodo','CEPROZAC\Http\Controllers\EntradasAgroquimicosController')
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
      <li><a style="color: #808080" href="{{url('/almacen/entradas/agroquimicos')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacen/entradas/agroquimicos')}}">Entradas de Almacén Agroquímicos</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Editar Entrada de Agroquímico Factura N°: {{$entrada->factura}}</strong></h2>
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

        <form action="{{url('/almacen/entradas/agroquimicos', [$entrada->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
          {{csrf_field()}}
          <input type="hidden" name="_method" value="PUT">
          {{csrf_field()}}



          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de Compra de Material: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input type="date" name="fecha" id="fecha" value="{{$entrada->fecha}}" class="form-control mask" >
           </div>
         </div>

         <div class="form-group">
          <label class="col-sm-3 control-label">Proveedor de Material : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="prov" id="prov" value="prov"  class="form-control select2" required>  
             @foreach($provedor as $emp)

             @if($emp->id == $entrada->provedor)
             <option value="{{$emp->id}}" selected>{{$emp->nombre}}</option>
             @else
             <option value="{{$emp->id}}">
               {{$emp->nombre}} 
             </option>
             @endif             
             @endforeach               
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>

       <div class="form-group">
        <label class="col-sm-3 control-label">Empresa : <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">
          <select name="recibio" id="recibio" value="recibio"  class="form-control select2" required>  
            @foreach($empresas as $emp)

            @if($emp->id == $entrada->comprador)
            <option value="{{$emp->id}}" selected>{{$emp->nombre}}</option>
            @else
            <option value="{{$emp->id}}">
             {{$emp->nombre}} 
           </option>
           @endif             
           @endforeach                  
         </select>
         <div class="help-block with-errors"></div>
       </div>
     </div>

     <div class="form-group">
      <label class="col-sm-3 control-label">Entregado a : <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">
        <select name="entrega" id="entrega" class="form-control select2" required>  

         @foreach($empleado as $emp)

         @if($emp->id == $entrada->entregado)
         <option value="{{$emp->id}}" selected>{{$emp->nombre}} {{$emp->apellidos}} </option>
         @else
         <option value="{{$emp->id}}">
           {{$emp->nombre}} {{$emp->apellidos}} 
         </option>
         @endif             
         @endforeach               
       </select>
       <div class="help-block with-errors"></div>
     </div>
   </div>


   <div class="form-group">
    <label class="col-sm-3 control-label">Recibe en Almacén CEPROZAC : <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <select name="recibe" id="recibe" value=""  class="form-control select2" required>  
       @foreach($empleado as $emp)

       @if($emp->id == $entrada->recibe_alm)
       <option value="{{$emp->id}}" selected>{{$emp->nombre}} {{$emp->apellidos}} </option>
       @else
       <option value="{{$emp->id}}">
         {{$emp->nombre}} {{$emp->apellidos}} 
       </option>
       @endif             
       @endforeach              
     </select>
     <div class="help-block with-errors"></div>
   </div>
 </div>

 <div class="form-group">
  <label class="col-sm-3 control-label">Observaciónes: <strog class="theme_color"></strog></label>
  <div class="col-sm-6">

    <input name="observacionesq" id="observacionesq" type="text"  value="{{$entrada->observacionesc}}" maxlength="200" onchange="mayus(this);"  class="form-control"  placeholder="Ingrese Observaciónes de la Compra"/>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Número de Factura: <strog class="theme_color">*</strog></label>
  <div class="col-sm-3">
    <input name="factura" id="factura" value="{{$entrada->factura}}"  type="text"  maxlength="10" onchange="mayus(this);"  class="form-control"  value="" placeholder="Ingrese el Número de Factura"/>
    <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('factura')}}</div>
  </div>
</div>


<div class="form-group">
 <label class="col-sm-3 control-label">Tipo de Moneda: <strog class="theme_color">*</strog></label>
 <div class="col-sm-3">
  <select name="moneda"  id ="moneda" class="form-control select" data-live-search="true"  value="{{Input::old('moneda')}}">
    @if($entrada->moneda =="Peso MXM")
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

<br> </br>


<br> </br>



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
     <div class="panel panel-success" >  

      <div class="panel-body">

        <div class="col-sm-3">
          <div class="form-group"> 
            <label for="material">Material </label>
            <select name="id_materialk"   class="form-control select"  value="id_materialk" data-live-search="true"   id="id_materialk" >  
              @foreach($material as $mat)
              <option value="{{$mat->cantidad}}_{{$mat->descripcion}}_{{$mat->codigo}}_{{$mat->id}}_{{$mat->nombre}}_{{$mat->idUnidadMedida}}_{{$mat->nombreUnidad}}_{{$mat->NombreUnidadP}}_{{$mat->cantidadMedida}}">
               {{$mat->nombre}}
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div><!--/form-group--> 




       <div class="col-sm-3">
        <div class="form-group"> 
          <label for="descripcion">Descripción </label>
          <input name="descripcion" id="descripcion" disabled class="form-control" />
        </div>    
      </div>   







      <div class="col-sm-3">
       <div class="form-group"> 
        <label for="preciou">$ Precio Unitario </label>
        <input name="preciou" id="preciou" value="0" type="number" class="form-control" />
        <span id="errorprecio" style="color:#FF0000;"></span>
      </div>    
    </div>  
    <div class="col-sm-1">
       <div class="form-group"> 
        <label for="preciou">% IVA </label>
         <input name="iva" id="iva" value="0" type="text" class="form-control" min="0" max="100" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IVA del Producto" />
        <span id="errorprecio" style="color:#FF0000;"></span>
      </div>    
    </div>   
              <div class="col-sm-1">
       <div class="form-group"> 
        <label for="preciou">% IEPS </label>
       <input name="ieps" id="ieps" value="0" type="text" class="form-control" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IEPS del Producto" />
        <span id="errorprecio" style="color:#FF0000;"></span>
      </div>    
    </div>     


  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Unidad de Medida <strog class="theme_color">*</strog></label>
    <div class="col-sm-3">
      <div class="input-group" >
        <div class="input-group-addon" >Completas</div>
        <input name="unidadesCompletas" id="unidadesCompletas"  parsley-range="[0,500]" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" value="" placeholder="3" onkeypress=" return soloNumeros(event);"/>
        <span id="errorUnidad" style="color:#FF0000;"></span>
      </div>
    </div>
    <div class="col-sm-3">
      <input id="unidadAux" name="unidadAux"  value="Medida" class="form-control currency" readonly="" />
    </div>
  </div>
</div>

<div class="form-group">    
  <label class="col-sm-3 control-label">Unidades Incompletas: <strog class="theme_color">*</strog></label>

  <div class="col-sm-3">
    <div class="input-group" >
      <div class="input-group-addon" id="unidadCentral">KILOGRAMOS</div>
      <input id="Medida" name="unidadCentral"  parsley-range="[0,500]" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" value="" placeholder="3" onkeypress=" return soloNumeros(event);"/>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="input-group" >
      <div class="input-group-addon" id="unidadDeMedida">Gramos</div>
      <input  name="unidadDeMedida"  parsley-range="[0,500]" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency"   id="unidadMinima" placeholder="3" onkeypress=" return soloNumeros(event);"/>
    </div>
  </div>
</div>



<div class="col-sm-3">
  <div class="form-group"> 
    <button type="button" id="btn_add" onclick="agregar();" class="btn btn-primary">Agregar</button>
  </div>
</div>



@include('almacen.agroquimicos.entradas.modale')

<div class="form-group"  class="table-responsive"> 
  <table id="detalles" name="detalles[]" value="" class="table table-responsive-xl table-bordered">
    <thead style="background-color:#A9D0F5">
      <th>Opciones</th>
      <th>N°</th>
      <th>Articulo</th>
      <th>Cantidad </th>
      <th>Total</th>
      <th>Precio Unitario</th>
      <th>IVA</th>
      <th>IEPS</th>
      <th>Subtotal</th>

    </thead>
    <tfoot>
     @foreach($entradas  as $entradas2)
     <tr class="gradeA">
      <td><input type="button" value="Eliminar"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);"> </td>
      <td>{{$entradas2->id_material}}</td>
      <td>{{$entradas2->nombreMaterial}}</td>
      <td><li>{{$metodo->Calcula_Cantidad($entradas2->cantidad , $entradas2->cantidadUnidad , $entradas2->nombreUnidadMedida , $entradas2->UnidadNombre)}}</li>
       <li>{{$metodo->Calcula_Cantidad2($entradas2->cantidad , $entradas2->cantidadUnidad , $entradas2->nombreUnidadMedida , $entradas2->UnidadNombre)}}</li>
       <li>{{$metodo->Calcula_Cantidad3($entradas2->cantidad , $entradas2->cantidadUnidad , $entradas2->nombreUnidadMedida , $entradas2->UnidadNombre)}}</li></td>
       @if($entradas2->nombreUnidadMedida == "KILOGRAMOS")
       <td>{{$entradas2->cantidad}} GRAMOS</td>

       @elseif($entradas2->nombreUnidadMedida == "LITROS")
       <td>{{$entradas2->cantidad}} MILILITROS</td>


       @elseif($entradas2->nombreUnidadMedida == "METROS")
       <td>{{$entradas2->cantidad}} CENTIMETROS</td>

       @else
       <td>{{$entradas2->cantidad}} UNIDADES</td>

       @endif
       <td>{{$entradas2->p_unitario}}</td>
       <td>{{$entradas2->iva}}</td>
       <td>{{$entradas2->ieps}}</td>
       <td>{{$metodo->CALCULA_SUB($entradas2->cantidad , $entradas2->cantidadUnidad , $entradas2->p_unitario, $entradas2->iva, $entradas2->ieps,$entradas2->nombreUnidadMedida)}}</td>
     </td>
   </td>
 </tr>    

 @endforeach
</tfoot>
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




<div class="form-group">
  <div class="col-sm-offset-7 col-sm-5">
    <button type="submit" onclick="return save();" class="btn btn-primary">Guardar</button>
    <a href="{{url('/almacen/entradas/agroquimicos')}}" class="btn btn-default"> Cancelar</a>
  </div>
</div><!--/form-group-->
</div>

</form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->
</html> 

<script type="text/javascript">

  function teclas(event) {
    tecla=(document.all) ? event.keyCode : event.which;
   // alert(tecla);

   var cuenta = document.getElementById('codigo');
   var x = cuenta.value;
   var z = x.length
   if (tecla == 13  ) {
    var busca = z;
    //  alert ("12 entro");
    var y = document.getElementById("id_materialk").length;
    //  alert(y);
    var i= 0;
    while(i <= y){


      if (i == y){
        swal("Producto No Encontrado!", "Verifique el Codigo de Barras!", "error");
        break;
      }

      var e = document.getElementById("id_materialk");
      var value = e.options[e.selectedIndex=i].value;
      var text = e.options[e.selectedIndex=i].text;
      var cantidadtotal = value;
      limite = "8",
      separador = "_",
      arregloDeSubCadenas = cantidadtotal.split(separador, limite);
      stock=arregloDeSubCadenas[0];
      descripcion=arregloDeSubCadenas[1];
            codigo=arregloDeSubCadenas[2];
        nombre=arregloDeSubCadenas[4];
      medida=arregloDeSubCadenas[5];
      nombreUnidad=arregloDeSubCadenas[6];
      UnidadP=arregloDeSubCadenas[7];
      tecla=(document.all) ? event.keyCode : event.which;
      if (codigo == x){
        swal("Producto Encontrado:"+nombre +"!", "Stock de Entrada!", "success",{content: "input", inputType:"number",}).then((value) => {
          var aux =`${value}`;

          document.getElementById("unidadesCompletas").value = aux;
  //swal(aux);
});

        document.getElementById('id_materialk').selectedIndex = i;
        document.getElementById("descripcion").value=descripcion;
        document.getElementById("unidadAux").value=nombreUnidad;
        obtenerSelect(UnidadP);
        break;
      }

      i++;
    }


    return false;
  }


}



window.onload=function() {
  var select2 = document.getElementById('id_materialk');
  var selectedOption2 = select2.selectedIndex;
  var cantidadtotal = select2.value;
  limite = "8",
  separador = "_",
  arregloDeSubCadenas = cantidadtotal.split(separador, limite);
  stock=arregloDeSubCadenas[0];
  descripcion=arregloDeSubCadenas[1];
  medida=arregloDeSubCadenas[5];
  nombreUnidad=arregloDeSubCadenas[6];
  UnidadP=arregloDeSubCadenas[7];

  document.getElementById("descripcion").value=descripcion;
  document.getElementById("unidadAux").value=nombreUnidad;
  document.getElementById("codigo").select();

  var menos =document.getElementById("detalles").rows;
  var r = menos.length;
  document.getElementById("total").value= r - 1;

  for (var i = 1 ; i <= r-1; i++) {
   cantidadnueva=document.getElementById("detalles").rows[i].cells[8].innerHTML;
   var x=  parseFloat(document.getElementById('subtotal').value);
   document.getElementById('subtotal').value = parseFloat(cantidadnueva) + x;

 }

 obtenerSelect(UnidadP);

}

var select = document.getElementById('id_materialk');
  //alert(select);
  select.addEventListener('change',
    function(){
      var selectedOption = this.options[select.selectedIndex];
     // alert(selectedOption.value);
   //   console.log(selectedOption.value + ': ' + selectedOption.text);
   var cantidadtotal = selectedOption.value;
   limite = "8",
   separador = "_",
   arregloDeSubCadenas = cantidadtotal.split(separador, limite);
   stock=arregloDeSubCadenas[0];
   descripcion=arregloDeSubCadenas[1];
   medida=arregloDeSubCadenas[5];
   nombreUnidad=arregloDeSubCadenas[6];
   UnidadP=arregloDeSubCadenas[7];

   document.getElementById("descripcion").value=descripcion;
   document.getElementById("unidadAux").value=nombreUnidad;
   obtenerSelect(UnidadP);

   // id_materiales=arregloDeSubCadenas[3];



 });

  function cargar(){
   var select2 = document.getElementById('id_materialk');
          // alert(select2.value);
          var z = select2.value;
          if (z != ""){
            var selectedOption2 = select2.selectedIndex;
            var cantidadtotal = select2.value;
            limite = "6",
            separador = "_",
            arregloDeSubCadenas = cantidadtotal.split(separador, limite);
            stock=arregloDeSubCadenas[0];
            descripcion=arregloDeSubCadenas[1];
            medida=arregloDeSubCadenas[5];
            document.getElementById("descripcion").value=descripcion;
          }

        }

        var uno = 1;
        var subtota=0;

        function agregar(){
          var valor = document.getElementById('id_materialk');
          var x = valor.value;
    //alert(x);
    if (x == "") {
     // alert("No hay Datos que Cargar");
     var uno = 1;

     // llenado();
   }
   else{
 // alert("llena");
 llenado();
}

}

function llenado(){
  var x = document.getElementById('unidadesCompletas').value;
  var y =document.getElementById('Medida').value;
  var z =document.getElementById('unidadMinima').value;

  if(x == "" && y == ""    && z == ""){
   document.getElementById("errorUnidad").innerHTML = "La Cantidad de Entrada debe ser Mayor de 0";
   return false;

 }
 document.getElementById("errorUnidad").innerHTML = "";
 

 document.getElementById("errorUnidad").innerHTML = "";
 var provedorv =  document.getElementById('prov').value;
 var empresav =  document.getElementById('recibio').value;

 var notav = document.getElementById('factura').value;
 var preciou = document.getElementById('preciou').value;
 var ivax = document.getElementById('iva').value * .010;
 var iepsx = document.getElementById('ieps').value  * .010;

 
 if( provedorv !== "" && empresav !=="" && notav!=="" && preciou!=="" && ivax !== ""){
   if (preciou > 0){
     document.getElementById("errorprecio").innerHTML = "";
     var select=document.getElementById('id_materialk');
     var cantidadtotal = select.value;
     limite = "9",
     separador = "_",
     arregloDeSubCadenas = cantidadtotal.split(separador, limite);
     var id2= uno++;
     cantidad=arregloDeSubCadenas[0];
     descripcion=arregloDeSubCadenas[1];
     codigo=arregloDeSubCadenas[2];
     id=arregloDeSubCadenas[3];
     nombre=arregloDeSubCadenas[4];
     UnidadP=arregloDeSubCadenas[7];
     CantidadP=arregloDeSubCadenas[8];

     var comprueba = recorre2(id)
     if (comprueba == 1){
      swal("Alerta!", "Este Material Ya se ha Insertado en la Tabla!", "error");
      return false;
    }

    var tabla = document.getElementById("detalles");
    //tabla.setAttribute("id", id2);

    var row = tabla.insertRow(1);
    row.style.backgroundColor = "white";
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);



    //alert(var3);
    var prove = document.getElementById("prov");
    var proved = prove.value;

    //alert(recibe);
    var notax = document.getElementById("factura");
    var notas = notax.value;

    var cantidades = document.getElementById("unidadesCompletas");
    var cantidaden = cantidades.value;




    if (UnidadP == "KILOGRAMOS" || UnidadP == "LITROS"  || UnidadP == "METROS"){
      var x = document.getElementById('unidadesCompletas').value;
      var y = document.getElementById('Medida').value;
      var z = document.getElementById('unidadMinima').value;
      x= (x * CantidadP)*1000;
      y= y*1000;
      if(x > 0 && y > 0 &&  z > 0){        
        var cantidad_Total="<li>"+document.getElementById('unidadesCompletas').value .concat(" "+document.getElementById('unidadAux').value)+"</li>"+"<br/>"+"<li>"+document.getElementById('Medida').value .concat(" "+document.getElementById('unidadCentral').innerHTML)+"</li>"+"<br/>" +"<li>"+document.getElementById('unidadMinima').value.concat(" "+document.getElementById('unidadDeMedida').innerHTML)+"</li>";
        var cantidad_completa= parseInt(x) + parseInt(y) + parseInt(z);

      }else if(x > 0 && y > 0 && z <= 0){
        var cantidad_Total="<li>"+document.getElementById('unidadesCompletas').value .concat(" "+document.getElementById('unidadAux').value)+"</li>"+"<br/>"+"<li>"+document.getElementById('Medida').value .concat(" "+document.getElementById('unidadCentral').innerHTML)+"</li>";
        var cantidad_completa = parseInt(x) + parseInt(y);
      }else if (x > 0 && y <= 0 && z <= 0){
        var cantidad_Total="<li>"+document.getElementById('unidadesCompletas').value .concat(" "+document.getElementById('unidadAux').value)+"</li>";
        var cantidad_completa= x;

      }


    }else {
      var cantidad_Total="<li>"+document.getElementById('unidadesCompletas').value .concat(" "+document.getElementById('unidadAux').value)+"</li>";
      var cantidad_completa= document.getElementById('unidadesCompletas').value;

    }

    if (UnidadP == "KILOGRAMOS"){
      var numbreUnidadAux="GRAMOS"; 
    }else if(UnidadP == "LITROS"){
      var   numbreUnidadAux="MILILITROS"; 
    }else if(UnidadP == "METROS"){
     var numbreUnidadAux="CENTIMETROS"

   }else{
    var  numbreUnidadAux="UNIDADES"
  }



  var preciox = document.getElementById("preciou");
  var precio = preciox.value;

  var ivatotal = cantidaden * precio * ivax;
  var iepstotal = cantidaden * precio * iepsx;
  cell1.innerHTML =  '<input type="button" value="Eliminar"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';
  cell2.innerHTML = id;
  cell3.innerHTML = nombre;
  cell4.innerHTML =  cantidad_Total;
  cell5.innerHTML = cantidad_completa + " " +numbreUnidadAux;
  cell6.innerHTML = precio;
  cell7.innerHTML = ivatotal;
  cell8.innerHTML = iepstotal;
  cell9.innerHTML = precio * cantidaden + ivatotal + iepstotal;

  var x = document.getElementById("id_materialk");
    //x.remove(x.selectedIndex);
    cargar();
    var menos =document.getElementById("detalles").rows
    var r = menos.length;
    document.getElementById("total").value= r - 1;
    var sub = precio * cantidaden + ivatotal + iepstotal;
    var auxsuma= document.getElementById("subtotal").value;
    var sumatodo = parseFloat(sub) + parseFloat(auxsuma);
    document.getElementById("subtotal").value=sumatodo;
  }else{
    //alert('El precio Unitario no Puede Ser Menor de 0');
   // swal("Alerta!", "El precio Unitario no Puede Ser Menor de 0!", "error");
   document.getElementById("errorprecio").innerHTML = "El precio Unitario no Puede Ser Menor de 0";
 }}else{
  swal("Alerta!", "Faltan campos Por llenar Favor de Verificar!", "error");
    //alert("Faltan campos Por llenar Favor de Verificar");
  }
}  

function eliminarFila(value) {

  var cantidadanueva=document.getElementById("detalles").rows[value].cells[8].innerHTML;
  document.getElementById("detalles").deleteRow(value);
  var id2= uno--;
  var menos =document.getElementById("detalles").rows
  var r = menos.length;
  document.getElementById("total").value= r - 1;
  var sub= document.getElementById("subtotal").value;
  document.getElementById("subtotal").value= parseFloat(sub) - parseFloat(cantidadanueva);
  limpiar();
}


function recorre2(valor) {
 var z = 1
 var arreglo = [];
 var table = document.getElementById('detalles');
 for (var r = 1, n = table.rows.length; r < n; r++) {
  for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
   if (z == 1){
    var j = table.rows[r].cells[c].innerHTML
    if (valor == j ){
      var r = 1;
      z ++;
      return(r);
    }else{
     z ++;
   }
 }
 else if(z == 2){
   z ++;
 }else if(z == 3){
  z ++;
}else if(z == 4){
 z ++;
} else if (z == 5){
  z ++;
}else if (z == 6){
 z ++;

}else if(z == 7){
 z ++;

}else if(z == 8){
 z ++;

}else{
 z = 1;

}

}
}
}


function limpiar(){
  document.getElementById("scantidad").value="1";
  //document.getElementById("factura").value="";
  document.getElementById("preciou").value="";
}
function save() {
 if (document.getElementById('total').value > 0){
   var z = 1
   var arreglo = [];
   var table = document.getElementById('detalles');
   for (var r = 1, n = table.rows.length-1; r <= n; r++) {
    for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
     if (z == 1){
        //alert(z)
       // document.getElementById("id_materialk").id=z;
      // document.getElementById("id_materialk").value=table.rows[r].cells[c].innerHTML;
      arreglo.push(table.rows[r].cells[c].innerHTML);
     //  alert(table.rows[r].cells[c].innerHTML);
     z ++;
   }

   else if(z == 2){
         //alert(z)
       //  document.getElementById("id_materialk").value=table.rows[r].cells[c].innerHTML;
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z ++;
     }else if(z == 3){
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z ++;
     }else if(z == 4){
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z ++;
     } else if (z == 5){
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z ++;
     }else if (z == 6){
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z ++;

     }else if(z == 7){
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z ++;

     }else{
      arreglo.push(table.rows[r].cells[c].innerHTML);
      document.getElementById("codigo2").value=arreglo;
      z = 1;

    }

  }
}
var menos =document.getElementById("detalles").rows
var r = menos.length;
document.getElementById("total").value= r - 1;
}else{
  //alert('No hay Elementos Agregados, Para Poder Guardar');
  swal("Alerta!", "No hay Elementos Agregados, Para Poder Guardar!", "error");
  return false;

}}

function obtenerSelect(valor) {
 //MILILITROS

//myArr.includes( 'donna' ) 
 if(valor == "MILILITROS"){  //MILILITROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='MILILITROS';  
  $("#Medida").show();


} else if(valor =="GRAMOS"){  //GRAMOS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='GRAMOS';  
  $("#Medida").show();

} else if(valor == "CENTIMETROS" ) {  //CENTIMETROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='CENTIMETROS';  
  $("#Medida").show();


} else if(valor == "LITROS" ){  //LITROS

 $("#unidadDeMedida").show();
 $("#unidadMinima").show();


 document.getElementById('unidadCentral').innerHTML='LITROS';  
 document.getElementById('unidadDeMedida').innerHTML='MILILITROS';  

 $("#unidadCentral").show();
 $("#Medida").show();
} else if(valor == "METROS"){  //METROS
 $("#unidadDeMedida").show();
 $("#unidadMinima").show();
 document.getElementById('unidadCentral').innerHTML='METROS';  
 document.getElementById('unidadDeMedida').innerHTML='CENTIMETROS';  


 $("#Medida").show();

}  else if(valor == "KILOGRAMOS") {  //KILOGRAMOS

 $("#unidadDeMedida").show();
 $("#unidadMinima").show();

 document.getElementById('unidadCentral').innerHTML='KILOGRAMOS';  
 document.getElementById('unidadDeMedida').innerHTML='GRAMOS';  

 $("#unidadCentral").show();
 $("#Medida").show();

} else if (valor == "UNIDADES") {  //UNIDADES

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='UNIDADES';  
  $("#Medida").show();

} 

}

</script>

@endsection 