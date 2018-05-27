@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Almacenes Generales</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/almacen/general')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacen/general')}}">Almacenes Generales</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Nuevo Almacén</strong></h2>
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
          <form action="{{route('almacen.general.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate  files="true" enctype="multipart/form-data" accept-charset="UTF-8">
            {{csrf_field()}}


            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="nombre" type="text"  value="{{Input::old('nombre')}}" maxlength="30"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese nombre del Almacén" />

              </div>
            </div>

                <div class="form-group">
              <label class="col-sm-3 control-label">Tipo de Capacidad (casillero,Cajon,Espacio,m2,etc..) : <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="medida" id="medida" type="text"  value="{{Input::old('medida')}}"  maxlength="70"  onchange="mayus(this);"  class="form-control"  required value="" placeholder="Tipo de Capacidad (Casillero,Cajon,m2,etc..):" />
              </div>
            </div>

                <div class="form-group">
              <label class="col-sm-3 control-label">Capacidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="capacidad" id="capacidad" type="text"  value="{{Input::old('capacidad')}}"  maxlength="70"  onKeyUp="generar()" onchange="soloNumeros(this);"   class="form-control" required value="" placeholder="Ingrese la Capacidad del Almacén" />
              </div>
            </div>




                <div class="form-group">
              <label class="col-sm-3 control-label">Descripción: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="descripcion" type="text"  value="{{Input::old('descripcion')}}"  maxlength="70"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese Descripción del Material" />
              </div>
            </div>

              <div class="form-group">
              <label class="col-sm-3 control-label">Espacio Ocupado Actualmente: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="ocupado" id="ocupado" type="text"  value="{{Input::old('ocupado')}}"  maxlength="70"  onchange="soloNumeros(this);"  class="form-control"   value="" placeholder="Ingrese el Espacio Ocupado Actualmente" readonly/>
              </div>
            </div>

                          <div class="form-group">
              <label class="col-sm-3 control-label">Espacio Libre Actualmente: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="libre" id="libre" type="text"  value="{{Input::old('ocupado')}}"  maxlength="70"  onchange="soloNumeros(this);"  class="form-control"    value="" placeholder="Espacio Libre" readonly/>
              </div>
            </div>

            <style>
table, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<p></p>
  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <div class="form-group"> 
<table id="myTable" name="myTable" value="" class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color:#A9D0F5">

        </thead>
  <tr>
  </tr>
</table>
<br>
</div>
</div>

               


   

   <div class="form-group">
    <div class="col-sm-offset-7 col-sm-5">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="{{url('/almacen/general')}}" class="btn btn-default"> Cancelar</a>
    </div>
  </div><!--/form-group-->


</form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script type="text/javascript">

    Array.prototype.sortNumbers = function(){
    return this.sort(
        function(a,b){
            return a - b
        }
    );
}

function generar(){
    var arreglolibre = [];
  var arregloocupado = [];
  var cantidad = document.getElementById('capacidad').value;
  if (cantidad > 0){
  for (var i = 1; cantidad >= i ; i++) {
    var menos =document.getElementById("myTable").rows.length-1
    if (menos > 0) {
      var suma = 1;
      for (var l = 1; l <= menos; l++){        
document.getElementById("myTable").deleteRow(0);
suma++;
      }
     
    }

    //document.getElementById("myTable").deleteRow(i);
     //row.deleteRow(0);
  }
  
  var suma = cantidad / 4; //8
  var cuenta;
  var valor = 1;

  for (cuenta = 1; cuenta <= cantidad ; cuenta++) {
       var table = document.getElementById("myTable");
       var med = document.getElementById("medida");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = med.value+" N° "+valor;
    var agregaHTML = "<input type=button value=Libre class=agrega id="+(valor)+">";
    cell2.innerHTML = agregaHTML;
     document.getElementById(""+valor).style.color = "#00ff00";
    valor++;
    arreglolibre.push(cuenta);
     document.getElementById('libre').value=arreglolibre;




    cell2.addEventListener("click", function(event) {
    var currentId = event.target.id;
    var z =  document.getElementById('capacidad').value;
    // Change the id (last character, some tweak)
  //  alert(event.target.id); // Before
    //event.target.id = event.target.id[event.target.id.length - 1];
    //alert(event.target.id); // After
    var aux = event.target.id;
    var calcula = document.getElementById(""+aux).value;
    var arr = document.getElementById(""+aux).id;


    if (calcula == "Ocupado") {
      for (var i = 0; i < arregloocupado.length; i++) {
  if (arr == arregloocupado[i]) {
    arregloocupado.splice(i, 1);
  }
}

      document.getElementById(""+aux).value = "Libre";
    document.getElementById(""+aux).style.color = "#00ff00";



    arreglolibre.push(arr);
    arregloocupado.sortNumbers();
arreglolibre.sortNumbers();
    document.getElementById('libre').value=arreglolibre;
    document.getElementById('ocupado').value=arregloocupado;
    }else{

      for (var i = 0; i < arreglolibre.length; i++) {
  if (arr == arreglolibre[i]) {
    arreglolibre.splice(i, 1);
  }
}



          document.getElementById(""+aux).value = "Ocupado";
    document.getElementById(""+aux).style.color = "#ff0000";
    arregloocupado.push(arr);
    arregloocupado.sortNumbers();
arreglolibre.sortNumbers();
    document.getElementById('ocupado').value=arregloocupado;
    document.getElementById('libre').value=arreglolibre;
    }
  }); 

}
}
}



  </script>
@endsection


</head>