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
          <input parsley-type="number" type="number" maxlength="6" required name="pacas_rev" id="pacas_rev"   class="form-control"  readonly onkeypress=" return soloNumeros(event);">
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
          <input parsley-type="number" type="text" maxlength="5" required parsley-range="[0, 10000]" name="diferencia"  readonly  id="diferencia" class="form-control mask";>
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
            <select name="almacen" id="almacen"  class="form-control select2" required>
              @foreach($almacengeneral as $almacen)
              <option value="{{$almacen->id}}_{{$almacen->capacidad}} {{$almacen->medida}}_}_{{$almacen->descripcion}}">
               {{$almacen->nombre}} 
             </option>
             @endforeach
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div><!--/form-group-->

                   <div class="form-group">
              <label class="col-sm-3 control-label">Capacidad de Almacenamiento: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="capacidad" id="capacidad" type="text"  disabled onchange="mayus(this);"  class="form-control" required value="" />
              </div>
            </div>

                             <div class="form-group">
              <label class="col-sm-3 control-label">Espacio Ocupado: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="ocupado" id="ocupado" type="text"  disabled onchange="mayus(this);"  class="form-control" required value="" />
              </div>
            </div>

                                         <div class="form-group">
              <label class="col-sm-3 control-label">Espacio Libre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="libre" id="libre" type="text"  disabled onchange="mayus(this);"  class="form-control" required value="" />
              </div>
            </div>

                                         <div class="form-group">
              <label class="col-sm-3 control-label">Descripción : <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="descripcion" id="descripcion" type="text" disabled onchange="mayus(this);"  class="form-control" required value="" />
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
           <label class="col-sm-3 control-label">Hora de La Fumigación: <strog class="theme_color">*</strog></label>
           <div class="col-sm-6">
<input id="time" name="time" type="time">
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
           <label class="col-sm-3 control-label">Agroquímicos a Aplicar: <strog class="theme_color">*</strog></label>
           <div class="col-sm-6">
            <select name="quimicos" id="quimicos"  class="form-control select2" required>
              @foreach($almacenagroquimicos as $quimico)
              <option value="{{$quimico->id}}}">
               {{$quimico->nombre}} 
             </option>
             @endforeach
           </select>
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

                                 <div class="form-group ">
        <label class="col-sm-3 control-label">Cantidad a Aplicar</label>
        <div class="col-sm-6">
          <input parsley-type="number" type="text" maxlength="3" required parsley-range="[0, 100]" name="cantidad"   class="form-control mask"  onkeypress=" return soloNumeros(event);">
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
                <div class="col-sm-offset-7 col-sm-5">
                  <button type="submit" class="btn btn-primary">Guardar</button>
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
window.onload=function() {
     var select2 = document.getElementById('almacen');
          // alert(select2.value);
          var z = select2.value;
          if (z != ""){
            var selectedOption2 = select2.selectedIndex;
            var cantidadtotal = select2.value;
            limite = "5",
            separador = "_",
            arregloDeSubCadenas = cantidadtotal.split(separador, limite);
            capacidad=arregloDeSubCadenas[1];
              ocupado=arregloDeSubCadenas[2];
               libre=arregloDeSubCadenas[3];
                descripcion=arregloDeSubCadenas[4];
            document.getElementById("capacidad").value=capacidad;
            document.getElementById("ocupado").value=ocupado;
            document.getElementById("libre").value =libre;
            document.getElementById("descripcion").value =descripcion;
          
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
   limite = "5",
            separador = "_",
            arregloDeSubCadenas = cantidadtotal.split(separador, limite);
            capacidad=arregloDeSubCadenas[1];
              ocupado=arregloDeSubCadenas[2];
               libre=arregloDeSubCadenas[3];
                descripcion=arregloDeSubCadenas[4];
            document.getElementById("capacidad").value=capacidad;
            document.getElementById("ocupado").value=ocupado;
            document.getElementById("libre").value =libre;
            document.getElementById("descripcion").value =descripcion;});

    function calcula(){
      var var1 =document.getElementById('enviados').value;
      var var2 =document.getElementById('recibidos').value;
      document.getElementById('diferencia').value=var1-var2;
      var var3 = va1-var2;

      

      
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

      function cargar(){
   var select2 = document.getElementById('almacen');
          // alert(select2.value);
          var z = select2.value;
          if (z != ""){
            var selectedOption2 = select2.selectedIndex;
            var cantidadtotal = select2.value;
            limite = "5",
            separador = "_",
            arregloDeSubCadenas = cantidadtotal.split(separador, limite);
            capacidad=arregloDeSubCadenas[1];
              ocupado=arregloDeSubCadenas[2];
               libre=arregloDeSubCadenas[3];
                descripcion=arregloDeSubCadenas[4];
            document.getElementById("capacidad").value=capacidad;
            document.getElementById("ocupado").value=ocupado;
            document.getElementById("libre").value =libre;
            document.getElementById("descripcion").value =descripcion;
          
          }}


  function calcularTiempo(){
    var fecha1 =document.getElementById('fechaInicio').value;
    var fecha2= document.getElementById('fechaFin').value;
    var ano1 = fecha1.substring(0, 2);
    var mes1 = fecha1.substring(3, 5);
    var dia1 = fecha1.substring(6, 10);
    fech1 =ano1+"-"+mes1+"-"+dia1;
    var ano2 = fecha2.substring(0, 2);
    var mes2 = fecha2.substring(3, 5);
    var dia2 = fecha2.substring(6, 10);
    fech2 =ano2+"-"+mes2+"-"+dia2;
    fecha1m=moment(fech1);
    fecha2m=moment(fech2);
      var diff = fecha2m.diff(fecha1m, 'd'); // Diff in days
      document.getElementById("duracionContrato").value = diff;


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