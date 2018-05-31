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
              <label class="col-sm-3 control-label">Capacidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="capacidad" id="capacidad" type="text"  value="{{Input::old('capacidad')}}"  maxlength="70"  onchange="soloNumeros(this);"   class="form-control" required value="" placeholder="Ingrese la Capacidad del Almacén" />
              </div>
            </div>


    <div class="form-group">
              <label class="col-sm-3 control-label">Tipo de Capacidad (Cajon,m2,etc..) : <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="medida" type="text"  value="{{Input::old('medida')}}"  maxlength="70"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Tipo de Capacidad (Cajon,m2,etc..):" />
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
                <input name="ocupado" id="ocupado" type="text"  value="{{Input::old('ocupado')}}"  maxlength="70"  onchange="soloNumeros(this);"  class="form-control" required value="" placeholder="Ingrese el Espacio Ocupado Actualmente" />
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

<table id="myTable">
  <tr>
  </tr>
</table>
<br>

               


   

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

function generar(){
  var cantidad = document.getElementById('capacidad').value;
  var suma = cantidad / 4;
  var cuenta;
  var valor = 1;
  for (cuenta = 1; cuenta <= suma; cuenta++) {
       var table = document.getElementById("myTable");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    cell1.innerHTML = '<input type="button" value="valor"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';
    valor++;
    cell2.innerHTML =  '<button id="15" type="button" onclick="eliminarFila(1)">valor</button>';
    valor++;
    cell3.innerHTML =  '<input type="button" value="valor"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';   
     valor++;
    cell4.innerHTML =  '<input type="button" value="valor"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';
    valor++;
}
}

function eliminarFila(value) {

}


  </script>
@endsection


</head>