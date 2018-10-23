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
        <form action="{{route('almacen.entradas.agroquimicos.store')}}" method="post" 
        parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
        {{csrf_field()}}


        <div class="row">



          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label><strong>Número de Factura: <strog class="theme_color">*</strog></strong></label>
              <div >
                <input name="factura" id="factura" value="{{Input::old('factura')}}" type="text"  maxlength="10" onchange="mayus(this);"  class="form-control"  placeholder="Ingrese el Número de Factura"/>
                <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('factura')}}</div>
                <?php
                $x = $errors->formulario->first('factura');
                $y =Input::old('factura');
                ?>
                @if ( $x != "")
                <a class="btn btn-primary btn-sm" href="{{URL::action('EntradasAgroquimicosController@show',$y)}}"  style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Modificar Factura"> <i class="fa fa-edit"></i> Modificar Factura </a>
                @endif
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label ><strong>Fecha de Compra de Material: <strog class="theme_color">*</strog></strong></label>
              <div >

               <input type="date" name="fecha" id="fecha"  class="form-control mask" >
             </div>
           </div>
         </div>

       </div>


       <div class="row">



         <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
          <div class="form-group">
           <label ><strong>Tipo de Moneda: <strog class="theme_color">*</strog></strong></label>
           <div >
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
      </div>

      <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
       <div class="form-group">
        <label ><strong>Proveedor de Material : <strog class="theme_color">*</strog></strong></label>

        <select name="prov" id="prov" value="prov"  class="form-control select2" required>  
          @foreach($provedor as $emp)
          <option value="{{$emp->id}}">
           {{$emp->nombre}} 
         </option>
         @endforeach              
       </select>
       <div class="help-block with-errors"></div>

     </div>
   </div>


   <div class="row">

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
     <div class="form-group">
       <label ><strong>Empresa : <strog class="theme_color">*</strog></strong></label>

       <select name="recibio" id="recibio" value="recibio"  class="form-control select2" required>  
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
      <select name="entrega"   class="form-control select2" required>  
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
      <select name="recibe" class="form-control select2" required>  
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
      <input name="observacionesq" id="observacionesq" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control"  placeholder="Ingrese Observaciónes de la Compra"/>
    </div>
  </div>
</div>

</div>


<div class="row"> 
  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    <div class="form-group">
      <label ><strong>Buscar Codigo de Barras: <strog class="theme_color">*</strog></strong></label>
      <div>
        <input  id="codigo" value="" name="codigo" type="text" onkeypress="return teclas(event);"  maxlength="35"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
      </div>

    </div>
  </div>

  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    <div class="form-group">
      <label>&nbsp; &nbsp;</label>
      <div>

        <a class="btn btn-sm btn-success tooltips" href="{{ route('almacenes.agroquimicos.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" target="_blank" title="" data-original-title="Registrar nuevo Material">
         <i class="fa fa-plus"></i> Registrar Nuevo Material </a>
       </div>
     </div>
   </div>
 </div>


 <div class="row">



  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    <div class="form-group"> 
      <label for="material"><strong>Material:</strong> </label>
      <select name="id_materialk"   class="form-control select"  value="id_materialk" data-live-search="true"   id="id_materialk" >  
        @foreach($material as $mat)
        <option value="{{$mat->cantidad}}_{{$mat->descripcion}}_{{$mat->codigo}}_{{$mat->id}}_{{$mat->nombre}}_{{$mat->idUnidadMedida}}_{{$mat->nombreUnidad}}_{{$mat->NombreUnidadP}}_{{$mat->cantidadMedida}}">
         {{$mat->nombre}} {{$mat->nombreUnidad}} DE {{$mat->cantidadMedida}} {{$mat->NombreUnidadP}}
       </option>
       @endforeach              
     </select>
     <div class="help-block with-errors"></div>
   </div><!--/form-group--> 
 </div>




 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
  <div class="form-group"> 
    <label for="preciou"><strong>Precio Unitario: </strong> </label>
    <input name="preciou" id="preciou" value="0" type="number" class="form-control" />
    <span id="errorprecio" style="color:#FF0000;"></span>
  </div>    
</div>

<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
  <div class="form-group"> 
    <label for="material"><strong>IVA</strong> </label>
    <select name="iva"   class="form-control select"  required  >  

      <option value="1">
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
    <input name="ieps" id="ieps" value="0" type="text" class="form-control" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IEPS del Producto" />
    <span id="errorprecio" style="color:#FF0000;"></span>
  </div>    
</div>

</div>



<div class="row">

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>Unidad de Medida:</strong></label>
      <div >
        <div class="input-group"> <span class="input-group-addon">Completas</span>
          <input type="text" class="form-control" placeholder="Username">
        </div>
      </div>
    </div><!--/form-group-->
  </div>


  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group"> 
      <label for="preciou"><strong>Contenedor </strong> </label>
      <input id="unidadAux" name="unidadAux"  value="Medida" class="form-control currency" readonly="" />
    </div>    
  </div>


  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label ><strong>Unidad de Medida:</strong></label>
      <div >
        <div class="input-group"> <span class="input-group-addon">Kilogramos</span>
          <input type="text" class="form-control" placeholder="Username">
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
        <div class="input-group"> <span class="input-group-addon">Gramos</span>
          <input type="text" class="form-control" placeholder="Username">
        </div>
      </div>
    </div><!--/form-group-->
  </div>

  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    <div class="form-group">
      <label ><strong>&nbsp; </strong></label>
      <div >

        <button type="button" id="btn_add" onclick="agregar();" class="btn btn-primary">Agregar</button>
      </div>
    </div>
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
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
      <td style="display:none;"></td>
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
 // document.getElementById("pcantidad").value=stock;
 document.getElementById("descripcion").value=descripcion;
 document.getElementById("unidadAux").value=nombreUnidad;
 document.getElementById("codigo").select();
  // <option value="{{$mat->cantidad}}_{{$mat->descripcion}}_{{$mat->codigo}}_{{$mat->id}}_{{$mat->nombre}}_{{$mat->idUnidadMedida}}">
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
   // id_materiales=arregloDeSubCadenas[3];

  // console.log(arregloDeSubCadenas); 
 // document.getElementById("pcantidad").value=stock;
 document.getElementById("descripcion").value=descripcion;
 document.getElementById("unidadAux").value=nombreUnidad;
 obtenerSelect(UnidadP);


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
            //document.getElementById("pcantidad").value=stock;
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

 var select2 = document.getElementById('id_materialk');
 var cantidadtotal = select2.value;
 limite = "3",
 separador = "_",
 arregloDeSubCadenas = cantidadtotal.split(separador, limite);
 unidadaux = arregloDeSubCadenas[0];
 medida=arregloDeSubCadenas[1];
 cantidadaux=arregloDeSubCadenas[2];



 var notav = document.getElementById('factura').value;
 var preciou = document.getElementById('preciou').value;
 var ivax = document.getElementById('iva').value * .010;
 var iepsx = document.getElementById('ieps').value  * .010;
 if(notav!=="" && preciou!=="" && ivax !== ""){
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
    var recibiox = document.getElementById("recibio");
    var recibe = recibiox.value;
    //alert(recibe);
    var notax = document.getElementById("factura");
    var notas = notax.value;




    var cantidades = document.getElementById("unidadesCompletas");
    var cantidaden = cantidades.value;
    var cantidadth = cantidadaux * cantidaden;
    var u = "";
    var medidaaux = u.concat(cantidadth," ",unidadaux);


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
    document.getElementById("total").value= r - 2;

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
  limpiar();
}  



function recorre2(valor) {
 var z = 1
 var arreglo = [];
 var table = document.getElementById('detalles');
 for (var r = 1, n = table.rows.length-1; r < n; r++) {
  for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
   if (z == 1){
    var j = table.rows[r].cells[c].innerHTML;

    if (valor == j ){             
      var r = 1;
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

function eliminarFila(value) {

  var fila =  console.log(value + "entro");
  var cantidadanueva=document.getElementById("detalles").rows[value].cells[8].innerHTML;
  document.getElementById("detalles").deleteRow(value);
  var id2= uno--;
  var menos =document.getElementById("detalles").rows
  var r = menos.length;
  document.getElementById("total").value= r - 2;
  var sub= document.getElementById("subtotal").value;
  document.getElementById("subtotal").value= parseFloat(sub) - parseFloat(cantidadanueva);
  limpiar();
}


function limpiar(){
 // document.getElementById("scantidad").value="1";
 //document.getElementById("factura").value="";
 document.getElementById("preciou").value="";
 document.getElementById("unidadCentral").value="";
 document.getElementById("unidadMinima").value="";
 document.getElementById("unidadesCompletas").value="";


}
function save() {
 if (document.getElementById('total').value > 0){
   var z = 1
   var arreglo = [];
   var table = document.getElementById('detalles');
   for (var r = 1, n = table.rows.length-1; r < n; r++) {
    for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
     if (z == 1){
      arreglo.push(table.rows[r].cells[c].innerHTML);
      z ++;
    }

    else if(z == 2){
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
document.getElementById("total").value= r - 2;
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