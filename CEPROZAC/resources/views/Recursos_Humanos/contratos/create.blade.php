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
    <h1>Beneficiario con RFC</h1>
    <h2 class="active"></h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a href="?c=Inicio">Inicio</a></li>
      <li><a href="?c=Beneficiario">Beneficiario con RFC</a></li>
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
                  <li><a href="#step-1">Informacion Personal</a></li>
                  <li><a href="#step-2">Informacion Laboral</a></li>
                  <li><a href="#step-3">Datos de Contrato</a></li>
                </ul>
                <div>
                  <div id="step-1" class="">
                    <div class="user-profile-content">

                      <div id="form-step-0" role="form" data-toggle="validator">
                        <h3 class="h3titulo">Informacion Personal</h3>

                        <input  name="fecha_Nacimiento" type="hidden" id="fechaNacimiento"  />
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">

                            <input name="nombre" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de el Empleado"/>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Apellidos: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">

                            <input name="apellidos" type="text"  maxlength="60" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de el Cliente"/>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">CURP<strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">
                            <input name="curp"  maxlength="18" id="curp" type="text" required parsley-regexp="([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)"   required parsley-rangelength="[18,18]"  onkeypress="mayus(this);" onblur="curp2date();"  class="form-control"   placeholder="Ingrese CURP de el empleado"/>
                          </div>
                        </div><!--/form-group-->

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">
                            <input type="text" name="telefono" placeholder="Ingrese el número de teléfono de Empleado" name="telefono" required class="form-control mask" data-inputmask="'mask':'(999) 999-9999'">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Domicilio: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">
                            <input type="text" name="domicilio" placeholder="Ingrese el domicilio" name="domicilio" required class="form-control mask" >
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">

                            <input name="email" value="" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de el cliente"/>

                          </div>
                        </div>


                      </div><!--validator-->
                    </div><!--user-profile-content-->
                  </div><!--step-1-->

                  <div id="step-2" class="">
                    <div class="user-profile-content">
                      <div id="form-step-1" role="form" data-toggle="validator">
                        <h3 class="h3titulo">Informacion Laboral</h3>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Fecha Ingreso: <strog class="theme_color">*</strog></label>
                          <div class="col-sm-6">

                           <input name="fecha_Ingreso" required type="text" class="form-control mask" data-inputmask="'alias': 'date'">
                         </div>
                       </div>

                       <div class="form-group">
                        <label class="col-sm-3 control-label">Fecha Alta seguro: <strog class="theme_color">*</strog></label>
                        <div class="col-sm-6">

                         <input type="text" name="fecha_Alta_Seguro" required class="form-control mask" data-inputmask="'alias': 'date'">
                       </div>
                     </div>

                     <div class="form-group">
                      <label class="col-sm-3 control-label">SSN</label>
                      <div class="col-sm-6 ">
                        <input type="text" name="numero_Seguro_Social" required type="numero_Seguro_Social" class="form-control mask" data-inputmask="'mask':'999-99-9999'">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Empresa contrata: <strog class="theme_color">*</strog></label>
                      <div class="col-sm-6">
                        <select name="rol" class="form-control" required>  
                          @foreach($empresas as $empresa)
                          <option value="{{$empresa->id}}">
                           {{$empresa->nombre}}
                         </option>
                         @endforeach              
                       </select>
                       <div class="help-block with-errors"></div>
                     </div>
                   </div><!--/form-group-->

                   <div class="form-group">
                     <label class="col-sm-3 control-label">Tiempo contrato: <strog class="theme_color">*</strog></label>
                     <div class="col-sm-3">
                       <input parsley-type="number" type="text" maxlength="12" required parsley-range="[1,100]" name="tiempoNumero"   class="form-control mask"  placeholder="28" onkeypress=" return soloNumeros(event);">
                     </div>
                     <div class="col-sm-3">
                       <select name="tiempoUnidad" class="form-control" required>  
                        <option value="DIAS">
                          DIAS 
                        </option>
                        <option value="MESES">
                         MESES
                       </option>
                       <option value="AÑOS">
                         AÑOS
                       </option>

                     </select>
                     <div class="help-block with-errors"></div>
                   </div>
                 </div><!--/form-group-->

                 <div class="form-group">
                   <label class="col-sm-3 control-label">HORAS DE DESCANSO: </label>
                   <div class="col-sm-2">
                     <input type="text" class="form-control mask" placeholder="34" onkeypress=" return soloNumeros(event);">
                   </div>
                   <div class="col-sm-3 left-align">
                     <p class="help-block">HORAS</p>
                   </div>
                 </div>

                 <div class="form-group">
                  <label class="col-sm-3 control-label">HORAS DE ALIMENTACION: </label>
                  <div class="col-sm-2">
                   <input type="text" class="form-control mask" placeholder="34" onkeypress=" return soloNumeros(event);">
                 </div>
                 <div class="col-sm-3 left-align">
                  <p class="help-block">HORAS</p>
                </div>
              </div>

              <div class="form-row">    
                <label class="col-sm-3 control-label">Sueldo empleado: <strog class="theme_color">*</strog></label>
                <div class="col-sm-3">
                  <div class="input-group">
                   <div class="input-group-addon">$</div>


                   <input name="sueldo_Fijo" required parsley-range="[1,50000]" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="189.00" onkeypress=" return soloNumeros(event);"/>
                 </div>
               </div>
             </div>


           </div><!--validator-->
         </div><!--user-profile-content-->
       </div><!--step-2-->

       <div id="step-3" class="">
        <div class="user-profile-content">
          <div id="form-step-2" role="form" data-toggle="validator">
            <h3 class="h3titulo">Datos de Contrato</h3>


            <div class="form-group">
              <label class="col-sm-3 control-label">Fecha Inicio: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

               <input name="fechaInicio" type="text" required class="form-control mask" data-inputmask="'alias': 'date'">
             </div>
           </div>

           <div class="form-group">
            <label class="col-sm-3 control-label">Fecha Fin: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">

             <input name="fechaFin" type="text" required class="form-control mask" data-inputmask="'alias': 'date'">
           </div>
         </div>

         <div class="form-group">
          <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">

            <input name="duracionContrato" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese nombre de el Empleado"/>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-7 col-sm-5">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="/contratos" class="btn btn-default"> Cancelar</a>
          </div>
        </div><!--/form-group-->                        

      </div><!--validator-->
    </div><!--user-profile-content-->
  </div><!--step-3-->

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