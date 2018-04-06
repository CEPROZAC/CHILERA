@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">

    <h1>Inicio</h1>
    <h2 class="">Almacén</h2>

    
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/almacen/materiales')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacen/materiales')}}">Salidas de Almacén</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Salida de Material</strong></h2>
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
        <form action="{{route('almacen.materiales.salidas.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>

          {{csrf_field()}}



          <div class="form-group">
            <label class="col-sm-3 control-label">Entrego : <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="entrego" id="entrego" class="form-control selectpicker" value="entrego" data-live-search="true" required >  
                @foreach($empleado as $emp)
                <option value="{{$emp->nombre}} {{$emp->apellidos}} ">
                 {{$emp->nombre}} {{$emp->apellidos}} 
               </option>
               @endforeach              
             </select>
             <div class="help-block with-errors"></div>
           </div>
         </div>


         <div class="form-group">
          <label class="col-sm-3 control-label">Recibio : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="recibio" id="recibio" value="recibio" class="form-control" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->nombre}} {{$emp->apellidos}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>

       <div class="form-group">
        <label class="col-sm-3 control-label">Tipo de Movimiento: <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">
          <input name="movimiento" id="movimiento" value="" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);"  value="" placeholder="Ingrese el Tipo de Movimiento Realizado"/>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label">Destino: <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">
          <input name="destino" id="destino" value="" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);"  value="" placeholder="Ingrese el Destino del Material"/>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label">Fecha de Salida: <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">

         <input type="date" name="fecha" id="fecha" value="" class="form-control mask" >
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
    <img src="/images/correcto.png" width="50" height="32" id="imagen" name="imagen" /> 

    <div class="container clear_both padding_fix">
      <div class="block-web">
       <div class="row">
        <div class="panel panel-primary"> 

          <div class="panel-body">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
              <div class="form-group"> 
                <label for="material">Material </label>
                <select name="id_materialk"  class="form-control selectpicker"  value="id_materialk" data-live-search="true"   id="id_materialk" >  
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
              <label for="scantidad">Cantidad de Salida </label>
              <input name="scantidad" id="scantidad" type="number" value="1" max="{{$mat->cantidad}}" min="1" required="" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" maxlength="5"  />
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
          <th>Id</th>
          <th>Articulo</th>
          <th>Cantidad</th>
          <th>Destino</th>
          <th>Entrego</th>
          <th>Recibio</th>
          <th>Tipo de Movimiento</th>
          <th>Fecha</th>

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

    <div class="form-group">
      <div class="col-sm-6">
        <input  id="codigo2" value="" name="codigo2[]" type="hidden"  maxlength="50"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
      </div>
    </div>

  </div>

</div>


</div>




<div class="form-group">
  <div class="col-sm-offset-7 col-sm-5">
    <button type="submit" onclick="save();" class="btn btn-primary">Guardar</button>
    <a href="/almacen/salidas/material" class="btn btn-default"> Cancelar</a>
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
    document.getElementById("scantidad").max=stock;
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
  document.getElementById("scantidad").max=stock;



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
            document.getElementById("scantidad").max=stock;
          }

        }

        var uno = 1;
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
  var valida = document.getElementById("scantidad");
  var valida2 = document.getElementById("pcantidad");

  if (valida.value > valida2.value) {
    alert("El Stock de Salida no Puede Ser Mayor que la Cantidad Actual en Almacén");

  }else{
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
    var row = tabla.insertRow(id2);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);

    var entrega =  document.getElementById("entrego");
    var nom1 = entrega.value;

    var recibe = document.getElementById("recibio");
    var nom2 = recibe.value;

    var fechas = document.getElementById("fecha");
    var var3 = fechas.value;

    var cantidades = document.getElementById("scantidad");
    var cantidadt = cantidades.value;

    var dest = document.getElementById("destino");
    var dest = dest.value;

    var mov = document.getElementById("movimiento");
    var movt = mov.value;

    cell1.innerHTML =  '<input type="button" value="Eliminar"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';
    cell2.innerHTML = id;
    cell3.innerHTML = nombre;
    cell4.innerHTML = cantidadt;
    cell5.innerHTML = dest;
    cell6.innerHTML = nom1;
    cell7.innerHTML = nom2;
    cell8.innerHTML = movt;
    cell9.innerHTML = var3;

    var x = document.getElementById("id_materialk");
    x.remove(x.selectedIndex);
    cargar();
    document.getElementById("total").value=id2;
    

  }

  
}   
function eliminarFila(value) {

  var fila =  console.log(value + "entro");
  document.getElementById("detalles").deleteRow(value);
  var id2= uno--;
  var menos =document.getElementById("detalles").rows
  var r = menos.length;
  document.getElementById("total").value= r - 2;
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
   document.getElementById("scantidad").max=stock;
break;
}
i++;
}
}

}

function limpiar(){
  document.getElementById("scantidad").value="1";
  document.getElementById("movimiento").value=" ";
  document.getElementById("destino").value=" ";


}


function save() {
 var z = 1
 var arreglo = [];
 var table = document.getElementById('detalles');
 for (var r = 1, n = table.rows.length-1; r < n; r++) {
  for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
   if (z == 1){
        //alert(z)
       // document.getElementById("id_materialk").id=z;
      // document.getElementById("id_materialk").value=table.rows[r].cells[c].innerHTML;
      arreglo.push(table.rows[r].cells[c].innerHTML);
       // alert(table.rows[r].cells[c].innerHTML);
       z ++;
     }

     else if(z == 2){
         //alert(z)
       //  document.getElementById("id_materialk").value=table.rows[r].cells[c].innerHTML;
       arreglo.push(table.rows[r].cells[c].innerHTML);
       // alert(table.rows[r].cells[c].innerHTML);
       z ++;
       

     }else if(z == 3){
         //alert(z)
       //  document.getElementById("scantidad").value=table.rows[r].cells[c].innerHTML;
         arreglo.push(table.rows[r].cells[c].innerHTML);
        //alert(table.rows[r].cells[c].innerHTML);
        z ++;
      }else if(z == 4){
         //alert(z)
        // document.getElementById("destino").value=table.rows[r].cells[c].innerHTML;
         arreglo.push(table.rows[r].cells[c].innerHTML);
       // alert(table.rows[r].cells[c].innerHTML);
       z ++;
     } else if (z == 5){
       //  alert(z)
     //  document.getElementById("entrego").value=table.rows[r].cells[c].innerHTML;
       //  alert(table.rows[r].cells[c].innerHTML);
       arreglo.push(table.rows[r].cells[c].innerHTML);
//alert(arreglo);
z ++;
}else if (z == 6){
 //document.getElementById("recibio").value=table.rows[r].cells[c].innerHTML;
 arreglo.push(table.rows[r].cells[c].innerHTML);
 z ++;

}else if(z == 7){
         //alert(z)
        // document.getElementById("movimiento").value=table.rows[r].cells[c].innerHTML;
         arreglo.push(table.rows[r].cells[c].innerHTML);
         z ++;

       }else{
       // document.getElementById("fecha").value=table.rows[r].cells[c].innerHTML;
        arreglo.push(table.rows[r].cells[c].innerHTML);
        document.getElementById("codigo2").value=arreglo;
        z = 1;

      }

    }
  }
  var tam = arreglo.length / 8;
  document.getElementById("total").value=tam;
}





</script>


@endsection