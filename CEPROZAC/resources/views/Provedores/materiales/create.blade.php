@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class=""> Proveedores</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/materiales/provedores')}}">Inicio</a></li>
      <li><a  style="color: #808080" href="{{url('/materiales/provedores')}}"> Proveedores</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Proveedor de Materiales</strong></h2> 
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
        <form method="post" action="{{url('materiales/provedores/validar')}}" class="form-horizontal row-border" parsley-validate novalidate '>
          {{csrf_field()}}
          <div class="form-group">
            <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

              <input name="nombre" type="text"  onchange="mayus(this);"  value="{{Input::old('nombre')}}" class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre del Provedor" maxlength="80" parsley-rangelength="[1,70]"/>
              <div class="text-danger" id='error_nombre'>{{$errors->formulario->first('nombre')}}</div>

            </div>
          </div>

          <input name="rfcOculto" id="oculto"  hidden  />
          <div class="form-group">
            <label class="col-sm-3 control-label">RFC: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="rfc" id="rfc" type="text"  onchange="mayus(this);validarprovmat();"  class="form-control" maxlength="13"  type="text" required parsley-regexp="([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})"   required parsley-rangelength="[12,13]"  onkeyup="mayus(this);"   required value="" placeholder="Ingrese RFC del Proveedor"/>
              <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('rfc')}}</div>
              <span id="errorRFC" style="color:#FF0000;"></span>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input type="text" parsley-type="phone" value="{{Input::old('telefono')}}" placeholder="Ingrese el número de teléfono de proveedor" name="telefono" value="" required class="form-control mask" data-inputmask="'mask':'(999) 999-9999'">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Direccion: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

              <input name="direccion" type="text"  value="{{Input::old('direccion')}}" onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese Direccion de proveedor" maxlength="150" parsley-rangelength="[1,150]" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="email" name="email"  value="{{Input::old('email')}}" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de proveedor"/>
            </div>
          </div> 


          <div class="form-group">
           <label class="col-sm-3 control-label">Tipo de Provedor: <strog class="theme_color">*</strog></label>
           <div class="col-sm-3">
             <select name="prov" id="prov" >
               <option value='Agroquimicos' selected>Agroquimicos</option>
               <option value="Refacciones">Refacciones</option>
               <option value="Limpieza">Limpieza</option>
               <option value="Empaque">Empaque</option>
             </select>
             <button type="button" id="btn_add" onclick="agregar();" class="btn btn-primary">Agregar</button>
             <span id="errorprov" style="color:#FF0000;"></span>
           </div>              
         </div>   


         <div class="form-group">
           <label class="col-sm-3 control-label">Provedor: <strog class="theme_color">*</strog></label>
           <div class="col-sm-3">
            <table id="provedores" name="provedores[]"  class="table table-striped table-bordered table-condensed table-hover">
              <thead style="background-color:#A9D0F5">
                <th>Opciones</th>
                <th>Tipo de Provedor</th>

              </thead>
              <tfoot>
                <th></th>
                <th></th>
              </tfoot>
              <tbody>

              </tbody>

            </table>
          </div>
          
        </div>

        <div class="form-group">
          <div class="col-sm-6">
            <input  id="codigo" value="" name="codigo" type="hidden"  maxlength="50"  class="form-control" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6">
            <input  id="codigo2" value="" name="codigo2" type="hidden"  maxlength="50"  class="form-control" />
          </div>
        </div>


        
        <div class="form-group">
          <div class="col-sm-offset-7 col-sm-5">
            <button type="submit" onclick="return save();" class="btn btn-primary">Guardar</button>
            <a href="{{url('/materiales/provedores')}}" class="btn btn-default"> Cancelar</a>
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
  var uno = 1;
  function agregar(){
    var aux = document.getElementById('prov').value;
    var id2= uno++;
    var comprueba = recorre(aux)
    if(comprueba == 1){
     document.getElementById("errorprov").innerHTML = "Este Tipo de Provedor Ya se ha Insertado en la Tabla";

   }else{
     document.getElementById("errorprov").innerHTML = "";

     var tabla = document.getElementById("provedores");
     var cont = tabla.rows.length;
     document.getElementById("codigo").value = cont - 1;
     var row = tabla.insertRow(cont-1);
     var cell1 = row.insertCell(0);
     var cell2 = row.insertCell(1);
     cell1.innerHTML =  '<input type="button" value="Eliminar"  onClick="eliminarfila(this.parentNode.parentNode.rowIndex);">';
     cell2.innerHTML = aux;

   }}

   function eliminarfila(value) {

    document.getElementById("provedores").deleteRow(value);
  //q=q-1;
}

function recorre(valor) {
 var z = 1
 var arreglo = [];
 var table = document.getElementById('provedores');
 for (var r = 1, n = table.rows.length-1; r < n; r++) {
  for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
   if (z == 1){
    var j = table.rows[r].cells[c].innerHTML
    if (valor == j ){
      var r = 1;
      return(r);
      z ++;
    }
  }
}
}
}

function save() {
 if (document.getElementById('codigo').value > 0){
   document.getElementById("errorprov").innerHTML = "";
   var z = 1
   var arreglo = [];
   var table = document.getElementById('provedores');
   for (var r = 1, n = table.rows.length-1; r < n; r++) {
    for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
       // document.getElementById("fecha").value=table.rows[r].cells[c].innerHTML;
       arreglo.push(table.rows[r].cells[c].innerHTML);
       z = 1;

     }
   }
   document.getElementById("codigo2").value=arreglo;
 //var tam = arreglo.length / 2;
 //document.getElementById("codigo").value=tam;
}else{

 document.getElementById("errorprov").innerHTML = "No hay Ningun Tipo de Provedor Asignado";
 return false;

}
}

</script>
@include('Provedores.materiales.modalreactivar')
@endsection