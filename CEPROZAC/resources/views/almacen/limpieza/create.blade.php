@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Limpieza</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('almacenes/limpieza')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('almacenes/limpieza')}}">Almacén de Limpieza</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar Nuevo Producto</strong></h2>
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

        <div id="alerta"> 

        </div>

        <form action="{{route('almacenes.limpieza.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate  files="true" enctype="multipart/form-data" accept-charset="UTF-8">
          {{csrf_field()}}


          <div class="form-group">
            <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="nombre" type="text" id="nombreMaterialLimpieza"  maxlength="30"  onchange="mayus(this);validarMaterialLimpiezaUnico();"  class="form-control" required value="" placeholder="Ingrese nombre del producto" />


            </div>
          </div>
          <input  type="hidden"  name="codigoBarrasOculto" id="codigoBarrasOculto">

          <div class="form-group">
            <label class="col-sm-3 control-label">Codigo de Barras: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <div class="radio">
                <label>
                  <input type="radio" value="1" name="habilitarDeshabilitar" onchange="habilitar(this.value);" checked> Ingrese Codigo de Barras 
                </label>
              </div>
              <div class="radio">
                <label>
                 <input type="radio" value="2" name="habilitarDeshabilitar"  onchange="habilitar(this.value);"> GenerarCodigo de Barras Automatico 
               </label>
             </div>
             <div class="radio">
              <label>
               <input type="radio" value="3" name="habilitarDeshabilitar"  onchange="habilitar(this.value);"> Ninguno
             </label>
           </div>
         </div>
       </div>

       <input name="nombreOculto" id="oculto"  hidden  />

       <input name="nombre_UnidadMedidaOculto" id="nombre_UnidadMedidaOculto" hidden />


       <div class="form-group">
         <label class="col-sm-3 control-label"></label>
         <div class="col-sm-6">
           <input type="text" name="codigo" id="segundo"  maxlength="35"   class="form-control" onchange="validarlimpieza();"  placeholder="Ingrese el Codigo de Barras"  required /><br>
           <span id="errorCodigo" style="color:#FF0000;"></span>
         </div>
       </div>

       <div class="form-group ">
        <label class="col-sm-3 control-label">Imagen</label>
        <div class="col-sm-6">
         <input  name="imagen" type="file"   accept=".jpg, .jpeg, .png" >
       </div>
     </div>


     <div class="form-group">
      <label class="col-sm-3 control-label">Descripción: <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">
        <input name="descripcion" type="text"  value="{{Input::old('descripcion')}}"  maxlength="70"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese Descripción del Material" />
      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">Unidad de Medida <strog class="theme_color">*</strog></label>
      <div class="col-sm-3">
        <select id="medida" name="idUnidadMedida" onchange="obtenerSelect();validarMaterialLimpiezaUnico();" >
          <option value="">
            SELECIONA UNIDAD DE MEDIDA
          </option>
          @foreach($unidades  as $unidad)
          <option value='{{$unidad-> idContenedorUnidadMedida}}'>
            {{$unidad->nombre}} {{$unidad->cantidad}} {{$unidad->nombreUnidadMedida}}
          </option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-3">
        <div class="input-group" >
          <div class="input-group-addon" >Completas</div>
          <input name="unidadesCompletas"  parsley-range="[0,500]" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="3" onkeypress=" return soloNumeros(event);"/>
        </div>
      </div>
    </div>


    <div class="form-group">    
      <label class="col-sm-3 control-label">Unidades Incompletas: <strog class="theme_color">*</strog></label>

      <div class="col-sm-3">
        <div class="input-group" >
          <div class="input-group-addon" id="unidadCentral"></div>
          <input id="Medida" name="unidadCentral"  
          data-number-to-fixed="2"  class="form-control currency" 
          required  placeholder="3" onkeypress="return soloNumeros(event);"
          max="{{$unidad->cantidad}}"
          />
        </div>
      </div>
      <div class="col-sm-3">
        <div class="input-group" >
          <div class="input-group-addon" id="unidadDeMedida"></div>
          <input  name="unidadDeMedida"  max="1000"   class="form-control currency"   id="unidadMinima" placeholder="3"


          onkeypress=" return soloNumeros(event);"/>
        </div>
      </div>
    </div>


    <div class="form-group">
      <label  class="col-sm-3 control-label">Stock Minimo <strog class="theme_color">*</strog></label>
      <div class="col-sm-3">
        <input name="stock_min" maxlength="9" type="number" 
        min="1" max='9999999' step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required  placeholder="Ingrese la Cantidad de Stock Minimo en Almacén" onkeypress=" return soloNumeros(event);" />
      </div> 
      <input  class="col-sm-3" id="contenedor"    readonly />
    </div> 

    
    <div class="form-group">
      <div class="col-sm-offset-7 col-sm-5">
        <button type="submit" id="submit" class="btn btn-primary">Guardar</button>
        <a href="{{url('/almacenes/limpieza')}}" class="btn btn-default"> Cancelar</a>
      </div>
    </div><!--/form-group-->

  </form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>


<script type="text/javascript">

  function validarMaterialLimpiezaUnico(){

    var select = document.getElementById("medida");
    var options=document.getElementsByTagName("option");
    var idRol= select.value;
    var x = select.options[select.selectedIndex].text;
    var nombreMaterialLimpieza = document.getElementById("nombreMaterialLimpieza").value;


    var nombreMaterialLimpieza_UnidadMedida= nombreMaterialLimpieza + " " +x;

    var route = "http://localhost:8000/validarMaterialLimpiezaUnico";
    var oculto =document.getElementById("nombre_UnidadMedidaOculto").value;

    if(nombreMaterialLimpieza != oculto){
      $.get(route,function(res){
        $(res).each(function(key,value){

          materialDeLimpiezaBD = value.nombre+ " "+value.nombreUnidadMedida+" "+value.cantidadUnidadMedida+ " "+ value.unidad_medida;
          if(nombreMaterialLimpieza_UnidadMedida == materialDeLimpiezaBD ){
            document.getElementById('submit').disabled=true;
            document.getElementById("alerta").innerHTML = "<div class=\"alert alert-danger\" id=\'result\'><strong>El producto de limpieza"
            + "que intentas registrar ya "+ 
            "existe en el sistema.</strong></div>";
            return false;
          } else {
            document.getElementById("alerta").innerHTML = "";
            document.getElementById('submit').disabled=false;
          }
        });
      });
    } 
  }



      /////////////////////////////// validar limpieza

      function  validarlimpieza(){

        var codigo =document.getElementById('segundo').value;
        var oculto =document.getElementById('codigoBarrasOculto').value;
        var route = "http://localhost:8000/validarlimpieza/"+codigo;

        $.get(route,function(res){
          if(res.length > 0  &&  res[0].estado =="Inactivo"){
           document.getElementById('submit').disabled=true;
           var idLim = res[0].id;
           document.getElementById("idLim").value= idLim;
           $("#modal-reactivar").modal();

         } 
         else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].codigo != oculto )  {

          document.getElementById("errorCodigo").innerHTML = "El Codigo de Barras que  intenta registrar ya existe en el sistema";
          document.getElementById('submit').disabled=true;

        }
        else {
          document.getElementById("errorCodigo").innerHTML = "";
          document.getElementById('submit').disabled=false;

        }
      });

      }


</script>
@include('almacen.limpieza.modalreactivar')
@endsection
