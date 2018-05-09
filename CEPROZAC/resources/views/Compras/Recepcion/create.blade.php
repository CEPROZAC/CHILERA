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
                  <li><a href="#step-4">Lotificación</a></li>
                </ul>
                <div>
                  <div id="step-1" class="">
                    <div class="user-profile-content">

                      <div id="form-step-0" role="form" data-toggle="validator">
                        <h3 class="h3titulo">Informacion de la Compra</h3>

                        <input  name="fecha_Nacimiento" type="hidden" id="fechaNacimiento"  />
                            <div class="form-group">
        <label class="col-sm-3 control-label">Fecha de Compra: <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">

         <input type="date" name="fecha" id="fecha" value="" class="form-control mask" >
       </div>
     </div>

                         <div class="form-group">
                      <label class="col-sm-3 control-label">Proveedor: <strog class="theme_color">*</strog></label>
                      <div class="col-sm-6">
                        <select name="provedor" class="form-control" required>  
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
                      <label class="col-sm-3 control-label">Transporte: <strog class="theme_color">*</strog></label>
                      <div class="col-sm-6">
                        <select name="transporte" class="form-control" required>  
                          @foreach($transportes as $trans)
                          <option value="{{$trans->id}}">
                           {{$trans->nombre_Unidad}}
                         </option>
                         @endforeach              
                       </select>
                       <div class="help-block with-errors"></div>
                     </div>
                   </div><!--/form-group-->

                                                               <div class="form-group">
                      <label class="col-sm-3 control-label">Recibe: <strog class="theme_color">*</strog></label>
                      <div class="col-sm-6">
                        <select name="empleado" class="form-control" required>  
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
          <div class="col-sm-2">
            <div class="input-group">
             <div class="input-group-addon">$</div>

             
             <input name="precio" maxlength="9" type="number" value="{{Input::old('precio')}}" min="0" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Precio de la Compra" onkeypress=" return soloNumeros(event);"/>
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
                        <select name="producto" class="form-control" required>  
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
                        <select name="calidad" class="form-control" required>  
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
                        <select name="empaque" class="form-control" required>  
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
            <select name="bascula" class="form-control" required>
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
          <input parsley-type="number" type="text" maxlength="5" required parsley-range="[0, 10000]" name="diferencia"   id="diferencia" class="form-control mask";>
        </div>
      </div>

                <input type="hidden" name="duracionContrato" id="duracionContrato" />    

              </div><!--validator-->
            </div><!--user-profile-content-->
          </div><!--step-3-->
          

          <div id="step-4" class="">
            <div class="user-profile-content">
              <div id="form-step-3" role="form" >
                <h3 class="h3titulo">Roles de empleados</h3>
                <br>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th> 
                          Rol
                        </th> 
                        <th>Agregar Rol</th>
                        <th>Quitar Rol</th>
                      </tr>
                    </thead>
                    <tbody id="myTable">
                      <tr>
                        <td>
   



                       </td>
                       <input type="hidden" name="_token" id="idEmpleado">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                       <td colspan="2"><button type="button"  onclick="myCreateFunction()" class="btn btn-success btn-icon"> Agregar <i class="fa fa-plus"></i> </button></td>
                     </tr>
                   </tbody>
                 </table>
               </div>
               <div class="form-group">
                <div class="col-sm-offset-7 col-sm-5">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <a href="/empleados" class="btn btn-default"> Cancelar</a>
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

    function calcula(){
      var var1 =document.getElementById('enviados').value;
      var var2 =document.getElementById('recibidos').value;
      document.getElementById('diferencia').value=var1-var2;
      var var3 = va1-var2;

      

      
    }


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



  @endsection