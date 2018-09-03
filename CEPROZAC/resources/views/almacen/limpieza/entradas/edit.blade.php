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
      <li><a style="color: #808080" href="{{url('/almacen/entradas/limpieza')}}">Entradas de Almacén Limpieza</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Editar Entrada de Limpieza Factura N°:{{$entrada->factura}}</strong></h2>
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

        <form action="{{url('/almacen/entradas/limpieza', [$entrada->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
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
        <select name="entregado_a" id="entregado_a" value=""  class="form-control select2" required>  

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
      <select name="recibe_alm" id="recibe_alm" value=""  class="form-control select2" required>  
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
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
          <div class="form-group"> 
            <label for="material">Material </label>
            <select name="id_materialk"   class="form-control select"  value="id_materialk" data-live-search="true"   id="id_materialk" >  
              @foreach($material as $mat)
              <option value="{{$mat->cantidad}}_{{$mat->descripcion}}_{{$mat->codigo}}_{{$mat->id}}_{{$mat->nombre}}">
               {{$mat->nombre}}
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div><!--/form-group-->

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
        <th>Subtotal</th>
        <th>Moneda</th>

      </thead>
      <tfoot>
       @foreach($entradas  as $entradas2)
       <tr class="gradeA">
        <td><input type="button" value="Eliminar"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);"> </td>
        <td>{{$entradas2->idagro}} </td>
        <td>{{$entradas2->nombremat}} </td>
        <td>{{$entradas2->cantidad}} </td>
        <td>{{$entradas2->factura}} </td>
        <td>{{$entradas2->fecha}}</td>
        <td>{{$entradas2->p_unitario}} </td>
        <td>{{$entradas2->iva}} </td>
        <td>{{$entradas2->importe}} </td>
        <td>{{$entradas2->moneda}} </td>
      </td>
    </td>

  </tr>    

  @endforeach
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
    <a href="{{url('/almacen/entradas/limpieza')}}" class="btn btn-default"> Cancelar</a>
  </div>
</div><!--/form-group-->
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
      limite = "5",
      separador = "_",
      arregloDeSubCadenas = cantidadtotal.split(separador, limite);
      stock=arregloDeSubCadenas[0];
      descripcion=arregloDeSubCadenas[1];
      codigo=arregloDeSubCadenas[2];
      id=arregloDeSubCadenas[3];
      nombre=arregloDeSubCadenas[4];
      tecla=(document.all) ? event.keyCode : event.which;
      if (codigo == x){
        swal("Producto Encontrado:"+nombre +"!", "Stock de Entrada!", "success",{content: "input", inputType:"number",}).then((value) => {
          var aux =`${value}`;

          document.getElementById("scantidad").value = aux;
  //swal(aux);
});

        document.getElementById('id_materialk').selectedIndex = i;
        document.getElementById("pcantidad").value=stock;
        document.getElementById("descripcion").value=descripcion;

        document.getElementById("scantidad").max=stock;
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
  limite = "5",
  separador = "_",
  arregloDeSubCadenas = cantidadtotal.split(separador, limite);
  stock=arregloDeSubCadenas[0];
  descripcion=arregloDeSubCadenas[1];
  document.getElementById("pcantidad").value=stock;
  document.getElementById("descripcion").value=descripcion;
  document.getElementById("scantidad").value = "1";
  document.getElementById("codigo").select();
  var menos =document.getElementById("detalles").rows;
  var r = menos.length;
  document.getElementById("total").value= r - 1;

  for (var i = 1 ; i <= r-1; i++) {
   cantidadnueva=document.getElementById("detalles").rows[i].cells[8].innerHTML;
   var x=  parseInt(document.getElementById('subtotal').value);
   document.getElementById('subtotal').value = parseInt(cantidadnueva) + x;

 }

}

var select = document.getElementById('id_materialk');
  //alert(select);
  select.addEventListener('change',
    function(){
      var selectedOption = this.options[select.selectedIndex];
     // alert(selectedOption.value);
   //   console.log(selectedOption.value + ': ' + selectedOption.text);
   var cantidadtotal = selectedOption.value;
   limite = "5",
   separador = "_",
   arregloDeSubCadenas = cantidadtotal.split(separador, limite);
   stock=arregloDeSubCadenas[0];
   descripcion=arregloDeSubCadenas[1];
   // id_materiales=arregloDeSubCadenas[3];

  // console.log(arregloDeSubCadenas); 
  document.getElementById("pcantidad").value=stock;
  document.getElementById("descripcion").value=descripcion;
  document.getElementById("scantidad").value = "1";



});

  function cargar(){
   var select2 = document.getElementById('id_materialk');
          // alert(select2.value);
          var z = select2.value;
          if (z != ""){
            var selectedOption2 = select2.selectedIndex;
            var cantidadtotal = select2.value;
            limite = "5",
            separador = "_",
            arregloDeSubCadenas = cantidadtotal.split(separador, limite);
            stock=arregloDeSubCadenas[0];
            descripcion=arregloDeSubCadenas[1];
            document.getElementById("pcantidad").value=stock;
            document.getElementById("descripcion").value=descripcion;
            document.getElementById("scantidad").value = "1";
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
  var fechav = document.getElementById('fecha').value;
  var provedorv =  document.getElementById('prov').value;
  var empresav =  document.getElementById('recibio').value;
  var entregadov = document.getElementById('entregado_a').value;
  var recibev = document.getElementById('recibe_alm').value;
  var notav = document.getElementById('factura').value;
  var entradav = document.getElementById('scantidad').value;
  var preciou = document.getElementById('preciou').value;
  var ivax = document.getElementById('iva').value * .010;
  var tipo_moneda = document.getElementById('moneda').value ;
  if(fechav !== "" && provedorv !== "" && empresav !=="" &&entregadov !=="" && recibev!=="" && notav!=="" &&entradav!=="" && preciou!=="" && ivax !== ""){
   if (preciou > 0){
     document.getElementById("errorprecio").innerHTML = "";
     if (entradav > 0){
      document.getElementById("errorCantidad").innerHTML = "";
      

      var select=document.getElementById('id_materialk');
      var cantidadtotal = select.value;
      limite = "5",
      separador = "_",
      arregloDeSubCadenas = cantidadtotal.split(separador, limite);
      var id2= uno++;
      cantidad=arregloDeSubCadenas[0];
      descripcion=arregloDeSubCadenas[1];
      codigo=arregloDeSubCadenas[2];
      id=arregloDeSubCadenas[3];
      nombre=arregloDeSubCadenas[4];
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
    var cell10 = row.insertCell(9);


    var fechas = document.getElementById("fecha");
    var var3 = fechas.value;
    //alert(var3);
    var prove = document.getElementById("prov");
    var proved = prove.value;
    var recibiox = document.getElementById("recibio");
    var recibe = recibiox.value;
    //alert(recibe);
    var notax = document.getElementById("factura");
    var notas = notax.value;

    var scantidadx = document.getElementById("scantidad");
    var cantidaden = scantidadx.value;



    var preciox = document.getElementById("preciou");
    var precio = preciox.value;

    var ivatotal = cantidaden * precio * ivax;
    cell1.innerHTML =  '<input type="button" value="Eliminar"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';
    cell2.innerHTML = id;
    cell3.innerHTML = nombre;
    cell4.innerHTML = cantidaden;
    cell5.innerHTML = notas;
    cell6.innerHTML = var3;
    cell7.innerHTML = precio;
    cell8.innerHTML = ivatotal;
    cell9.innerHTML = precio * cantidaden + ivatotal ;
    cell10.innerHTML = tipo_moneda;

    var x = document.getElementById("id_materialk");
    //x.remove(x.selectedIndex);
    cargar();
    var menos =document.getElementById("detalles").rows
    var r = menos.length;
    document.getElementById("total").value= r - 1;
    var sub = precio * cantidaden + ivatotal ;
    var auxsuma= document.getElementById("subtotal").value;
    var sumatodo = parseInt(sub) + parseInt(auxsuma);
    document.getElementById("subtotal").value=sumatodo;
  }else{
   // swal("Alerta!", "La Cantidad de Entrada debe ser Mayor de 0!", "error");
   document.getElementById("errorCantidad").innerHTML = "La Cantidad de Entrada debe ser Mayor de 0";
 }}else{
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
  document.getElementById("subtotal").value= parseInt(sub) - parseInt(cantidadanueva);
  limpiar();
}

function codigos(){
  var cuenta = document.getElementById('codigo');
  var x = cuenta.value;
  var z = x.length
  if (z == 12  ) {
    var busca = z;
    //  alert ("12 entro");
    var y = document.getElementById("id_materialk").length;
    //  alert(y);
    var i= 0;
    while(i < y){
      var e = document.getElementById("id_materialk");
      var value = e.options[e.selectedIndex=i].value;
      var text = e.options[e.selectedIndex=i].text;
      var cantidadtotal = value;
      limite = "5",
      separador = "_",
      arregloDeSubCadenas = cantidadtotal.split(separador, limite);
      stock=arregloDeSubCadenas[0];
      descripcion=arregloDeSubCadenas[1];
      codigo=arregloDeSubCadenas[2];
      id=arregloDeSubCadenas[3];
      nombre=arregloDeSubCadenas[4];

      if (codigo == x){
    //alert(i);
    document.getElementById('id_materialk').selectedIndex = i;
    document.getElementById("pcantidad").value=stock;
    document.getElementById("descripcion").value=descripcion;
    document.getElementById("scantidad").value = "1";
    break;
  }else{
    alert('Codigo de Barras No Encontado');
    break;
  }
  i++;
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

     }else if(z == 8){
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

</script>

@endsection 