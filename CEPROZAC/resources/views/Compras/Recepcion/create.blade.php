@extends('layouts.principal')
@section('contenido')
<style type="text/css">
  .lbldetalle{
    color:#2196F3;
  }
  .h3titulo{
    margin-left: 30px;
    color:#2196F3;
    margin-top: 30px;
  }
</style>
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Recepción de Compra</h1>
    <h2 class="active"></h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a href="?c=Inicio">Inicio</a></li>
      <li><a href="?c=Beneficiario">Recepción de Compra</a></li>
      <li class="active"></li>
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
              <h2 class="content-header theme_color" style="margin-top: -5px;"></h2>
            </div>
            <div class="col-md-4">
              <div class="btn-group pull-right">
                <div class="actions"> 
                </div>
              </div>
            </div>    
          </div>
        </div><!--header-->


        <div class="porlets-content">
          <div  class="form-horizontal row-border" > <!--acomodo-->
            <form class="" id="myForm" action="{{route('contratos.store')}}" method="post" role="form" enctype="multipart/form-data" parsley-validate novalidate data-toggle="validator">
              {{csrf_field()}}
              <div id="smartwizard">
                <ul>
                  <li><a href="#step-1">Recepción de Compra</a></li>
                  <li><a href="#step-2">Muestreo de Materia Prima</a></li>
                  <li><a href="#step-3">Pesaje</a></li>
                  <li><a href="#step-4">Área de Recepción</a></li>
                  <li><a href="#step-5">Fumigación</a></li>
                </ul>
                <div>
                  <div id="step-1" class="">
                    <div class="user-profile-content">

                      <div id="form-step-0" role="form" data-toggle="validator">
                        <h3 class="h3titulo">Informacion de la Compra</h3>

                        <input  name="fecha_compra" type="hidden" id="fecha_compra"  />
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Fecha de Compra: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">

                           <input type="date" name="fecha" id="fecha" value="" class="form-control mask" >
                         </div>
                       </div>

                       <div class="form-group">
                        <label class="col-sm-3 control-label">Proveedor: <strog class="theme_color">*</strog></label>
                        <div class="col-sm-6">
                          <select name="provedor"  class="form-control select2" required>  
                            @foreach($provedores as $empresa)
                            <option value="{{$empresa->id}}">
                             {{$empresa->nombre}}
                           </option>
                           @endforeach              
                         </select>
                         <div class="help-block with-errors"></div>
                       </div>
                     </div><!--/form-group-->
                     <div class="form-group">
                      <label class="col-sm-3 control-label">Transporte Registrado en la Empresa: <strog class="theme_color">*</strog></label>
                      <div class="col-sm-6">
                        <input type="radio" name="registrado" id="registrado" onchange="buscar1()" value="si"> Si<br>
                        <input type="radio" name="registrado" id="registrado" onchange="buscar2()" value="no"> No<br>
                      </div>
                    </div><!--/form-group-->

                    <div class="form-group" id="transportediv" style='display:none;'>
                      <label class="col-sm-3 control-label">Transporte: <strog class="theme_color">*</strog></label>
                      <div class="col-sm-6">
                        <select name="transporte" id="transporte"  class="form-control select2">  
                          @foreach($transportes as $trans)
                          <option value="{{$trans->id}}">
                           {{$trans->nombre_Unidad}}
                         </option>
                         @endforeach              
                       </select>
                       <div class="help-block with-errors"></div>
                     </div>
                   </div><!--/form-group-->

                   <div class="form-group" id="transportediv2" style='display:none;'>
                    <label class="col-sm-3 control-label">Transporte: <strog class="theme_color">*</strog></label>
                    <div class="col-sm-6">
                      <input name="transporte" id="transporte" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control" onkeypress=" value="" placeholder="Ingrese el Transporte"/>


                      <div class="help-block with-errors"></div>
                    </div>
                  </div><!--/form-group-->

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Recibe: <strog class="theme_color">*</strog></label>
                    <div class="col-sm-6">
                      <select name="empleado"  class="form-control select2" required>  
                        @foreach($empleado as $em)
                        <option value="{{$em->id}}">
                         {{$em->nombre}}
                       </option>
                       @endforeach              
                     </select>
                     <div class="help-block with-errors"></div>
                   </div>
                 </div><!--/form-group-->

                 <div class="form-group">
                  <label class="col-sm-3 control-label">Observaciónes: <strog class="theme_color">*</strog></label>
                  <div class="col-sm-6">

                    <input name="observaciones" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" value="" placeholder="Ingrese Observaciónes de la Compra"/>
                  </div>
                </div>

                <div class="form-row">    
                  <label class="col-sm-3 control-label">Precio Total de La Compra: <strog class="theme_color">*</strog></label>
                  <div class="col-sm-6">
                    <div class="input-group">
                     <div class="input-group-addon">$</div>


                     <input name="precio" maxlength="9" type="text" value="{{Input::old('precio')}}" min="0" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Precio de la Compra" onkeypress=" return soloNumeros(event);"/>
                   </div>
                 </div>
               </div>



             </div><!--validator-->
           </div><!--user-profile-content-->
         </div><!--step-1-->

         <div id="step-2" class="">
          <div class="user-profile-content">
            <div id="form-step-1" role="form" data-toggle="validator">
              <h3 class="h3titulo">Materia Prima</h3>

              <div class="form-group">
                <label class="col-sm-3 control-label">Nombre de la Materia Prima: <strog class="theme_color">*</strog></label>
                <div class="col-sm-6">
                  <select name="producto"  class="form-control select2" required>  
                    @foreach($productos as $pro)
                    <option value="{{$pro->id}}">
                     {{$pro->nombre}}
                   </option>
                   @endforeach              
                 </select>
                 <div class="help-block with-errors"></div>
               </div>
             </div><!--/form-group-->

             <div class="form-group">
              <label class="col-sm-3 control-label">Calidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="calidad"  class="form-control select2" required>  
                  @foreach($calidad as $cal)
                  <option value="{{$cal->id}}">
                   {{$cal->nombre}}
                 </option>
                 @endforeach              
               </select>
               <div class="help-block with-errors"></div>
             </div>
           </div><!--/form-group-->

           <div class="form-group">
            <label class="col-sm-3 control-label">Formato de Empaque: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="empaque"  class="form-control select2" required>  
                @foreach($empaque as $em)
                <option value="{{$em->id}}">
                 {{$em->formaEmpaque}}
               </option>
               @endforeach              
             </select>
             <div class="help-block with-errors"></div>
           </div>
         </div><!--/form-group-->

         <div class="form-group ">
          <label class="col-sm-3 control-label">Porcentaje de humedad</label>
          <div class="col-sm-6">
            <input parsley-type="number" type="text" maxlength="3" required parsley-range="[0, 100]" name="porcentaje_Humedad"   class="form-control mask"  onkeypress=" return soloNumeros(event);">
          </div>
        </div>

        <div class="form-group ">
          <label class="col-sm-3 control-label">Número de Pacas</label>
          <div class="col-sm-6">
            <input parsley-type="number" type="text" maxlength="6" required  name="num_pacas" id="num_pacas"   class="form-control" onKeyUp="raiz()"  onkeypress=" return soloNumeros(event);">
          </div>
        </div>

        <div class="form-group ">
          <label class="col-sm-3 control-label">Número de Pacas a Revisar</label>
          <div class="col-sm-6">
            <input parsley-type="number" type="number" maxlength="6" name="pacas_rev" id="pacas_rev"   class="form-control"  readonly onkeypress=" return soloNumeros(event);">
          </div>
        </div>




      </div><!--validator-->
    </div><!--user-profile-content-->
  </div><!--step-2-->

  <div id="step-3" class="">
    <div class="user-profile-content">
      <div id="form-step-2" role="form" data-toggle="validator">
        <h3 class="h3titulo">Datos de Pesaje</h3>


        <div class="form-group">
         <label class="col-sm-3 control-label">Bascula: <strog class="theme_color">*</strog></label>
         <div class="col-sm-6">
          <select name="bascula"  class="form-control select2" required>
            @foreach($servicio as $bascula)
            <option value="{{$bascula->id}}">
             {{$bascula->nombreBascula}} 
           </option>
           @endforeach
         </select>
         <div class="help-block with-errors"></div>
       </div>
     </div><!--/form-group-->

     <div class="form-group">
      <label class="col-sm-3 control-label">Ticket: <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">
        <input name="numeroTicket" type="text"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese numero de Ticket" />
      </div>
    </div>

    <div class="form-group ">
      <label class="col-sm-3 control-label">KG Enviados</label>
      <div class="col-sm-6">
        <input parsley-type="number" type="text" maxlength="5" required parsley-range="[0, 10000]" name="enviados" id="enviados"  class="form-control mask"  placeholder="Ingrese el numero de Kilogramos Enviados"  onKeyUp="calcula()" onkeypress="return soloNumeros(event);">
      </div>
    </div>

    <div class="form-group ">
      <label class="col-sm-3 control-label">KG Recibidos</label>
      <div class="col-sm-6">
        <input parsley-type="number" type="text" maxlength="5" required parsley-range="[0, 10000]" name="recibidos"  onKeyUp="calcula()"  id ="recibidos" class="form-control mask"  placeholder="Ingrese el numero de Kilogramos Recibidos" onkeypress=" return soloNumeros(event);">
      </div>
    </div>

    <div class="form-group ">
      <label class="col-sm-3 control-label">Diferencia</label>
      <div class="col-sm-6">
        <input parsley-type="number" type="text" maxlength="5" parsley-range="[0, 10000]" name="diferencia"  readonly  id="diferencia" class="form-control mask";>
      </div>
    </div>

    <input type="hidden" name="duracionContrato" id="duracionContrato" />    

  </div><!--validator-->
</div><!--user-profile-content-->
</div><!--step-3-->


<div id="step-4" class="">
  <div class="user-profile-content">
    <div id="form-step-3" role="form" >
      <h3 class="h3titulo">Enviar Materia Prima a Área de Recepción</h3>
      <br>

      <div class="form-group">
       <label class="col-sm-3 control-label">Ubicación a Enviar: <strog class="theme_color">*</strog></label>
       <div class="col-sm-6">
        <select name="almacen" id="almacen"  class="form-control select" onKeyUp="cargar()" required>
          @foreach($almacengeneral as $almacen)
          <option value="{{$almacen->id}}_{{$almacen->capacidad}}_{{$almacen->medida}}_{{$almacen->total_ocupado}}_{{$almacen->total_libre}}_{{$almacen->esp_ocupado}}_{{$almacen->esp_libre}}_{{$almacen->descripcion}}">
           {{$almacen->nombre}} 
         </option>
         @endforeach
       </select>
       <div class="help-block with-errors"></div>
     </div>
   </div><!--/form-group-->

   <div class="form-group">
    <label class="col-sm-3 control-label">Descripción : <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <input name="descripcion" id="descripcion" type="text"  onchange="mayus(this);"  class="form-control"  value="" readonly />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Capacidad de Almacenamiento: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <input name="capacidad" id="capacidad" type="text"   onchange="mayus(this);"  class="form-control"  value=""  readonly/>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Espacio Ocupado: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <input name="ocupado" id="ocupado" type="text"   onchange="mayus(this);"  class="form-control" required value="" readonly/>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Espacio Libre: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <input name="libre" id="libre" type="text"   onchange="mayus(this);"  class="form-control" required value="" readonly/>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Espacio Asignado: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <input name="asignado" id="asignado" type="text"   onchange="mayus(this);"  class="form-control" required value="" readonly/>
    </div>
  </div>


  <div class="form-group">
    <label class="col-sm-3 control-label">Seleccione el Espacio a Donde se Enviará la Materia Prima: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <div class="form-group"> 
        <table id="myTable" name="myTable" value=""  required class="table table-striped table-bordered table-condensed table-hover" >
          <thead style="background-color:#A9D0F5">

          </thead>
          <tr>
          </tr>
        </table>
        <br>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Observaciónes : <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">
      <input name="observacionesu" id="observacionesu" type="text"  onchange="mayus(this);"  class="form-control"  value=""  />
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-6">
      <input  id="totallibre" value="" name="totallibre" type="hidden"  maxlength="50"  class="form-control"  />
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-6">
      <input  id="totalocupado" value="" name="totalocupado" type="hidden"  maxlength="50"  class="form-control" />
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-6">
      <input  id="espacio" value="" name="espacio" type="hidden"  maxlength="50"  class="form-control" />
    </div>
  </div>




</div><!--validator-->
</div><!--user-profile-content-->
</div><!--step-2-->

<div id="step-5" class="">
  <div class="user-profile-content">
    <div id="form-step-4" role="form" >
      <h3 class="h3titulo">Programar Fumigación</h3>
      <br>

      <div class="form-group">
       <label class="col-sm-3 control-label">Hora de Inicio de La Fumigación: <strog class="theme_color">*</strog></label>
       <div class="col-sm-6">
        <input id="inicio" name="inicio" type="time">
        <div class="help-block with-errors"></div>
      </div>
    </div><!--/form-group-->

    <div class="form-group">
      <label class="col-sm-3 control-label">Fecha de Inicio: <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">

       <input type="date" name="fechai" id="fechai" value="" class="form-control mask" >
     </div>
   </div>

   <div class="form-group">
    <label class="col-sm-3 control-label">Fecha de Termino: <strog class="theme_color">*</strog></label>
    <div class="col-sm-6">

     <input type="date" name="fechaf" id="fechaf" value="" class="form-control mask" >
   </div>
 </div>

 <div class="form-group">
   <label class="col-sm-3 control-label">Hora de Termino de La Fumigación: <strog class="theme_color">*</strog></label>
   <div class="col-sm-6">
    <input id="final" name="final" type="time" readonly>
    <div class="help-block with-errors"></div>
  </div>
</div><!--/form-group-->

<div class="form-group">
 <label class="col-sm-3 control-label">Fumigador: <strog class="theme_color">*</strog></label>
 <div class="col-sm-6">
  <select name="fumigador" id="fumigador"  class="form-control select2" required>
    @foreach($empleado as $empleados)
    <option value="{{$empleados->id}}}">
     {{$empleados->nombre}} {{$empleados->apellidos}} 
   </option>
   @endforeach
 </select>
 <div class="help-block with-errors"></div>
</div>
</div><!--/form-group-->



<div class="col-lg-4 col-lg-offset-4">
 <div class="form-group">
  <label class="col-sm-6 control-label">Buscar Codigo de Barras: <strog class="theme_color">*</strog></label>
  <div class="col-sm-6">
    <input  id="codigo" value="" name="codigo" type="text" onKeyUp="codigos()"  maxlength="13"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
  </div>
</div>
</div>

<div class="form-group">
</div>

<div class="form-group">
 <label class="col-sm-3 control-label">Agroquímicos a Aplicar: <strog class="theme_color">*</strog></label>
 <div class="col-sm-6">
  <select name="quimicos" id="quimicos"  class="form-control select" required>
    @foreach($almacenagroquimicos as $quimico)
    <option value="{{$quimico->id}}_{{$quimico->nombre}}_{{$quimico->codigo}}_{{$quimico->descripcion}}_{{$quimico->cantidad}}_{{$quimico->medida}}">
     {{$quimico->nombre}} 
   </option>
   @endforeach
 </select>
 <div class="help-block with-errors"></div>
</div>
<a class="btn btn-sm btn-danger"   style="margin-right: 10px;"  onclick="agroquimico();" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Agregar Agroquimico"> <i class="fa fa-plus"></i>Agregar</a>
</div><!--/form-group-->

<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
 <div class="form-group"> 
  <label for="scantidad">Cantidad de Salida </label>
  <input name="scantidad" id="scantidad" type="number" value="1" max="1000000" min="1" required="" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" maxlength="5"  />
</div>    
</div>  

<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
 <div class="form-group"> 
  <label for="pcantidad">Cantidad en Almacén </label>
  <input name="pcantidad" id="pcantidad" value="" type="number" disabled class="form-control" />
</div>    
</div>  
<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
 <div class="form-group"> 
  <label for="amedida">Medida </label>
  <input name="amedida" id="amedida" value="" type="text" disabled class="form-control" />
</div>
</div>  

<div class="col-sm-4">
 <div class="form-group"> 
  <label for="descripciona">Descripción </label>
  <input name="descripciona" id="descripciona" disabled class="form-control" />
</div>    
</div> 

<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
  <div class="form-group"> 
    <table id="detalles" name="detalles[]" value="" class="table table-striped table-bordered table-condensed table-hover">
      <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Id</th>
        <th>Nombre de Agroquimico</th>
        <th>Descripcion</th>
        <th>Cantidad de Salida</th>

      </thead>
      <tfoot>
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
</div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Estado de la Fumigacion: <strog class="theme_color">*</strog></label>
  <div class="col-sm-6">
    <select name="status" value="{{Input::old('status')}}">
      @if(Input::old('status')=="Pendiente")
      <option value='Pendiente' selected>Pendiente
      </option>
      <option value="Realizada">Realizada</option>
      @else
      <option value='Realizada' selected>Realizada
      </option>
      <option value="Pendiente">Pendiente</option>
      @endif
    </select>

  </div>
</div>

<div class="form-group">
  <div class="col-sm-6">
    <input  id="codigo2" value="" name="codigo2[]" type="hidden"  class="form-control"  placeholder="Ingrese el Codigo de Barras"/>
  </div>
</div>





<div class="form-group">
  <div class="col-sm-offset-7 col-sm-5">
    <button type="submit" onclick="save();" class="btn btn-primary">Guardar</button>
    <a href="/compras/recepcion/" class="btn btn-default"> Cancelar</a>
  </div>
</div><!--/form-group--> 

</div><!--validator-->
</div><!--user-profile-content-->
</div><!--step-2-->

</div>
</div>  <!--smartwizard-->            
</form>
</div><!--/form-horizontal-->
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<script type="text/javascript">
  Array.prototype.sortNumbers = function(){
    return this.sort(
      function(a,b){
        return a - b
      }
      );
  }
  window.onload=function() {
     //stock agroquimicos
     var select2 = document.getElementById('quimicos');
     var selectedOption2 = select2.selectedIndex;
     var cantidadtotal = select2.value;
     limite = "6",
     separador = "_",
     arregloDeSubCadenas = cantidadtotal.split(separador, limite);
     var ida =arregloDeSubCadenas[0];
     var nombrea =arregloDeSubCadenas[1];
     var codigoa = arregloDeSubCadenas[2];
     var descripciona = arregloDeSubCadenas[3];
     var cantidada = arregloDeSubCadenas[4];
     var medidaa = arregloDeSubCadenas[5];
     document.getElementById("pcantidad").value=cantidada ;
     document.getElementById("descripciona").value=descripciona;
     document.getElementById("amedida").value=medidaa;
     document.getElementById("scantidad").value = "1";
    //  <option value="{{$quimico->id}}}_{{$quimico->nombre}}_{{$quimico->codigo}}_{{$quimico->descripcion}}_{{$quimico->cantidad}}_{{$quimico->medida}}">


    var select2 = document.getElementById('almacen');
    var z = select2.value;
    if (z != ""){
      var selectedOption2 = select2.selectedIndex;
      var cantidadtotal = select2.value;
      limite = "8",
      separador = "_",
      arregloDeSubCadenas = cantidadtotal.split(separador, limite);
      capacidad=arregloDeSubCadenas[1];
      medida = arregloDeSubCadenas[2];
      ocupado=arregloDeSubCadenas[5];
      libre=arregloDeSubCadenas[6];
      descripcion=arregloDeSubCadenas[7];
      document.getElementById("capacidad").value=capacidad ;
      document.getElementById("ocupado").value=ocupado;
      document.getElementById("libre").value =libre;
      document.getElementById("descripcion").value =descripcion;

    }
    var arreglolibre2 = [];
    var arregloocupado2 = [];
    var arreglolibre = [];
    var arregloocupado = [];
    var arregloespacio= [] ;


    arregloocupado2= document.getElementById("ocupado").value;
    arreglolibre2= document.getElementById("libre").value;
    var tamaño_libre;
    var libres = arreglolibre2.split(",");
    tamaño_libre = libres.length;
    var tamaño_ocupado;
    var ocupado = arregloocupado2.split(",");
    tamaño_ocupado = ocupado.length;

    if (arregloocupado2.length >0){
      for (var x = 0; x < tamaño_ocupado; x++){
        arregloocupado.push(ocupado[x]);
      }}
      if (arreglolibre2.length > 0){
        for (var i = 0; i < tamaño_libre; i++){
          arreglolibre.push(libres[i]);
        }

        var valor = 0;
        for (var cuenta = 1; cuenta <= tamaño_libre ; cuenta++) {
         var table = document.getElementById("myTable");
         var med = medida;
         var row = table.insertRow(0);
         var cell1 = row.insertCell(0);
         var cell2 = row.insertCell(1);
         cell1.innerHTML = med+" N° "+libres[valor];
         var agregaHTML = "<input type=button value=Libre class=agrega id="+libres[(valor)]+">";
         cell2.innerHTML = agregaHTML;
         document.getElementById(""+libres[valor]).style.color = "#00ff00";
         valor++;

         cell2.addEventListener("click", function(event) {
          var currentId = event.target.id;
          var z =  document.getElementById('capacidad').value;
          var aux = event.target.id;
          var calcula = document.getElementById(""+aux).value;
          var arr = document.getElementById(""+aux).id;


          if (calcula == "Ocupado") {
            for (var i = 0; i < arregloocupado.length; i++) {
              if (arr == arregloocupado[i]) {
                arregloocupado.splice(i, 1);
              }
              if (arr == arregloespacio[i]){
                arregloespacio.splice(i,1);
              }
            }

            document.getElementById(""+aux).value = "Libre";
            document.getElementById(""+aux).style.color = "#00ff00";
            arreglolibre.push(arr);
            arregloocupado.sortNumbers();
            arreglolibre.sortNumbers();
            document.getElementById('libre').value=arreglolibre;
            document.getElementById('ocupado').value=arregloocupado;
            document.getElementById('asignado').value=arregloespacio;
            tamaño_libre = arreglolibre.length;
            document.getElementById('totallibre').value=tamaño_libre;
            tamaño_ocupado = arregloocupado.length;
            document.getElementById('totalocupado').value=tamaño_ocupado;
          }else{
            for (var i = 0; i < arreglolibre.length; i++) {
              if (arr == arreglolibre[i]) {
                arreglolibre.splice(i, 1);
              }
            }

            document.getElementById(""+aux).value = "Ocupado";
            document.getElementById(""+aux).style.color = "#ff0000";
            arregloocupado.push(arr);
            arregloespacio.push(arr);
            arregloespacio.sortNumbers();
            arregloocupado.sortNumbers();
            arreglolibre.sortNumbers();
            document.getElementById('ocupado').value=arregloocupado;
            document.getElementById('libre').value=arreglolibre;
            document.getElementById('asignado').value=arregloespacio;
            tamaño_libre = arreglolibre.length;
            document.getElementById('totallibre').value=tamaño_libre;
            tamaño_ocupado = arregloocupado.length;
            document.getElementById('totalocupado').value=tamaño_ocupado;
          }
        })
       }
     }
   }

   var select = document.getElementById('almacen');
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
   capacidad=arregloDeSubCadenas[1];
   medida = arregloDeSubCadenas[2];
   ocupado=arregloDeSubCadenas[5];
   libre=arregloDeSubCadenas[6];
   descripcion=arregloDeSubCadenas[7];
   document.getElementById("capacidad").value=capacidad;
   document.getElementById("ocupado").value=ocupado;
   document.getElementById("libre").value =libre;
   document.getElementById("descripcion").value =descripcion;
   document.getElementById("asignado").value ="";
   generar();
 });

  var select = document.getElementById('quimicos');
  //alert(select);
  select.addEventListener('change',
    function(){
      var selectedOption = this.options[select.selectedIndex];
     // alert(selectedOption.value);
   //   console.log(selectedOption.value + ': ' + selectedOption.text);
   var cantidadtotal = selectedOption.value;
   limite = "6",
   separador = "_",
   arregloDeSubCadenas = cantidadtotal.split(separador, limite);
   var ida =arregloDeSubCadenas[0];
   var nombrea =arregloDeSubCadenas[1];
   var codigoa = arregloDeSubCadenas[2];
   var descripciona = arregloDeSubCadenas[3];
   var cantidada = arregloDeSubCadenas[4];
   var medidaa = arregloDeSubCadenas[5];
   document.getElementById("pcantidad").value=cantidada ;
   document.getElementById("descripciona").value=descripciona;
   document.getElementById("amedida").value=medidaa;
   document.getElementById("scantidad").value = "1";



 });
  var uno = 1;
  function agroquimico(){
     var valida = document.getElementById("scantidad");
  var valida2 = document.getElementById("pcantidad");

  if (valida.value > valida2.value) {
    alert("El Stock de Salida no Puede Ser Mayor que la Cantidad Actual en Almacén");

  }else{

    var select=document.getElementById('quimicos');
    var cantidadtotal = select.value;
    limite = "6",
    separador = "_",
    arregloDeSubCadenas = cantidadtotal.split(separador, limite);
    var id2= uno++;
    var ida =arregloDeSubCadenas[0];
    var nombrea =arregloDeSubCadenas[1];
    var codigoa = arregloDeSubCadenas[2];
    var descripciona = arregloDeSubCadenas[3];
    var cantidada = arregloDeSubCadenas[4];
    var medidaa = arregloDeSubCadenas[5];
    var tabla = document.getElementById("detalles");
    //tabla.setAttribute("id", id2);
    var row = tabla.insertRow(id2);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    var scantidadx = document.getElementById("scantidad");
    var cantidaden = scantidadx.value;

    cell1.innerHTML =  '<input type="button" value="Eliminar"  onClick="eliminarFila(this.parentNode.parentNode.rowIndex);">';
    cell2.innerHTML = ida;
    cell3.innerHTML = nombrea;
    cell4.innerHTML = descripciona;
    cell5.innerHTML = cantidaden;

    var x = document.getElementById("quimicos");
    //x.remove(x.selectedIndex);
    document.getElementById("total").value=id2;
    limpiar();
}
  }

  function eliminarFila(value) {

    document.getElementById("detalles").deleteRow(value);
    var id2= uno--;
    var menos =document.getElementById("detalles").rows
    var r = menos.length;
    document.getElementById("total").value= r - 2;
    limpiar();
  }   

  function calcula(){
    var var1 =document.getElementById('enviados').value;
    var var2 =document.getElementById('recibidos').value;
    document.getElementById('diferencia').value=var1-var2;
    var var3 = va1-var2;
  }

  function codigos(){

    var cuenta = document.getElementById('codigo');
    var x = cuenta.value;
    var z = x.length
    if (z == 12  ) {
      var busca = z;
    //  alert ("12 entro");
    var y = document.getElementById("quimicos").length;
    //  alert(y);
    var i= 0;
    while(i < y){
      var e = document.getElementById("quimicos");
      var value = e.options[e.selectedIndex=i].value;
      var text = e.options[e.selectedIndex=i].text;
      var cantidadtotal = value;
      limite = "6",
      separador = "_",
      arregloDeSubCadenas = cantidadtotal.split(separador, limite);
      var ida =arregloDeSubCadenas[0];
      var nombrea =arregloDeSubCadenas[1];
      var codigoa = arregloDeSubCadenas[2];
      var descripciona = arregloDeSubCadenas[3];
      var cantidada = arregloDeSubCadenas[4];
      var medidaa = arregloDeSubCadenas[5];

      if (codigoa == x){
       document.getElementById('quimicos').selectedIndex = i;
       document.getElementById("pcantidad").value=cantidada;
       document.getElementById("descripciona").value=descripciona;
       document.getElementById("scantidad").value = "1";
       break;
     }
     i++;
   }
 }

}
function limpiar(){
  document.getElementById("scantidad").value="1";
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
var tam = arreglo.length / 9;
document.getElementById("total").value=tam;
}



function buscar1(){
  document.getElementById('transportediv').style.display = 'block';
  document.getElementById('transportediv2').style.display = 'none';

}
function buscar2(){
  document.getElementById('transportediv2').style.display = 'block';
  document.getElementById('transportediv').style.display = 'none';

}

function raiz(){
  var aux = document.getElementById('num_pacas').value;
  var z = Math.sqrt(aux) + 1 ;
  document.getElementById('pacas_rev').value=z;

}

function generar(){
 document.getElementById('espacio').value = "";
 var arregloespacio= [] ;
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

  }
  var select2 = document.getElementById('almacen');
  var z = select2.value;
  if (z != ""){
    var selectedOption2 = select2.selectedIndex;
    var cantidadtotal = select2.value;
    limite = "8",
    separador = "_",
    arregloDeSubCadenas = cantidadtotal.split(separador, limite);
    capacidad=arregloDeSubCadenas[1];
    medida = arregloDeSubCadenas[2];
    ocupado=arregloDeSubCadenas[5];
    libre=arregloDeSubCadenas[6];
    descripcion=arregloDeSubCadenas[7];

  }
  var arreglolibre2 = [];
  var arregloocupado2 = [];
  var arreglolibre = [];
  var arregloocupado = [];


  arregloocupado2= document.getElementById("ocupado").value;
  arreglolibre2= document.getElementById("libre").value;
  var tamaño_libre;
  var libres = arreglolibre2.split(",");
  tamaño_libre = libres.length;
  var tamaño_ocupado;
  var ocupado = arregloocupado2.split(",");
  tamaño_ocupado = ocupado.length;


 // alert(tamaño_libre);
  //alert(libres[1]);
  if (arregloocupado2.length >0){
    for (var x = 0; x < tamaño_ocupado; x++){
      arregloocupado.push(ocupado[x]);
    }}
    if (arreglolibre2.length > 0){
      for (var i = 0; i < tamaño_libre; i++){
        arreglolibre.push(libres[i]);
      }
      var valor = 0;
      for (var cuenta = 1; cuenta <= tamaño_libre ; cuenta++) {
       var table = document.getElementById("myTable");
       var med = medida;
       var row = table.insertRow(0);
       var cell1 = row.insertCell(0);
       var cell2 = row.insertCell(1);
       cell1.innerHTML = med+" N° "+libres[valor];
       var agregaHTML = "<input type=button value=Libre class=agrega id="+libres[(valor)]+">";
       cell2.innerHTML = agregaHTML;
       document.getElementById(""+libres[valor]).style.color = "#00ff00";
       valor++;

       cell2.addEventListener("click", function(event) {
        var currentId = event.target.id;
        var z =  document.getElementById('capacidad').value;
        var aux = event.target.id;
        var calcula = document.getElementById(""+aux).value;
        var arr = document.getElementById(""+aux).id;


        if (calcula == "Ocupado") {
          for (var i = 0; i < arregloocupado.length; i++) {
            if (arr == arregloocupado[i]) {
              arregloocupado.splice(i, 1);
            }
            if (arr == arregloespacio[i]){
              arregloespacio.splice(i,1);
            }
          }

          document.getElementById(""+aux).value = "Libre";
          document.getElementById(""+aux).style.color = "#00ff00";
          arreglolibre.push(arr);
          arregloocupado.sortNumbers();
          arreglolibre.sortNumbers();
          arregloespacio.sortNumbers();
          document.getElementById('libre').value=arreglolibre;
          document.getElementById('ocupado').value=arregloocupado;
          document.getElementById('espacio').value=arregloespacio;
          tamaño_libre = arreglolibre.length;
          document.getElementById('totallibre').value=tamaño_libre;
          tamaño_ocupado = arregloocupado.length;
          document.getElementById('totalocupado').value=tamaño_ocupado;
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
          arregloespacio.push(arr);
          arregloespacio.sortNumbers();
          document.getElementById('ocupado').value=arregloocupado;
          document.getElementById('libre').value=arreglolibre;
          tamaño_libre = arreglolibre.length;
          document.getElementById('totallibre').value=tamaño_libre;
          tamaño_ocupado = arregloocupado.length;
          document.getElementById('totalocupado').value=tamaño_ocupado;
          document.getElementById('espacio').value=arregloespacio;
        }
      })
     }
   }
 }
}



</script>

<script type="text/javascript">
  $(document).ready(function(){
        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('Finish')
        .addClass('btn btn-info')
        .on('click', function(){
          if( !$(this).hasClass('disabled')){
            var elmForm = $("#myForm");
            if(elmForm){
              elmForm.validator('validate');
              var elmErr = elmForm.find('.has-error');
              if(elmErr && elmErr.length > 0){
                alert('Oops we still have error in the form');
                return false;
              }else{
                alert('Great! we are ready to submit form');
                elmForm.submit();
                return false;
              }
            }
          }
        });
        var btnCancel = $('<button style="margin-left:-200px;"></button>').text('Cancel')
        .addClass('btn btn-danger')
        .on('click', function(){
          $('#smartwizard').smartWizard("reset");
          $('#myForm').find("input, textarea").val("");
        });


        // Smart Wizard
        $('#smartwizard').smartWizard({
          selected: 0,
          theme: 'arrows',
          transitionEffect:'fade',
          toolbarSettings: {toolbarPosition: 'bottom'},
          anchorSettings: {
            markDoneStep: true, // add done css
            markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
            removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
          }
        });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
          var elmForm = $("#form-step-" + stepNumber);
          // stepDirection === 'forward' :- this condition allows to do the form validation
          // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
          if(stepDirection === 'forward' && elmForm){
            elmForm.validator('validate');
            var elmErr = elmForm.children('.has-error');
            if(elmErr && elmErr.length > 0){
              // Form validation failed
              return false;
            }
          }
          return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
          // Enable finish button only on last step
          if(stepNumber == 3){
            $('.btn-finish').removeClass('disabled');
          }else{
            $('.btn-finish').addClass('disabled');
          }
        });

      });

    </script>



    @endsection