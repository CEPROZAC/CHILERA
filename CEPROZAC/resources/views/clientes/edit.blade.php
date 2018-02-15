@extends('layouts.principal')
@section('contenido')
<html>
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Clientes</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/clientes')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/clientes')}}">Clientes</a></li>   
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Editar Cliente: {{ $clientes->nombre}}</strong></h2> 
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
          <form action="{{url('clientes', [$clientes->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">

             <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="nombre" type="text"  maxlength="30" onchange="mayus(this);"  class="form-control"  value="{{$clientes->nombre}}"  onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de el Cliente"/>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label">RFC: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="rfc" value="{{$clientes->rfc}}"  maxlength="20" id="RFC"  type="text" required parsley-regexp="([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})"   required parsley-rangelength="[12,13]"  onkeyup="mayus(this);"  class="form-control"   class="form-control" required placeholder="Ingrese RFC del Cliente"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Regimen Fiscal: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
              <select name="fiscal"  class="form-control"  value="{{$clientes->fiscal}}" placeholder="Ingrese el Regimen Fiscal del Cliente">
              <option value="Fisica">Fisica</option>
              <option value="Moral">Moral</option>
              </select>
         
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label">Calle: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="calle" type="text" value="{{ $clientes->calle}}"  maxlength="15" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese Direccion del Cliente"/>
              </div>
            </div>


              <div class="form-group">
              <label class="col-sm-3 control-label">Numero: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input type="number"  value="{{ $clientes->numero}}" min="1" max="999" name="numero" maxlength="4"   class="form-control" onkeypress=" return soloNumeros(event);" required value="" placeholder="Ingrese el numero de su Domicilio" maxlength="4" size="4"/>
              </div>
            </div>


             <div class="form-group">
              <label class="col-sm-3 control-label">Colonia: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="colonia" value="{{ $clientes->colonia}}"  type="text"  maxlength="20" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese Direccion de la Calle"  />
              </div>
            </div>

    

             <div class="form-group">
              <label class="col-sm-3 control-label">Ciudad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="ciudad" type="text"  maxlength="15" onchange="mayus(this);"  class="form-control" value="{{ $clientes->ciudad}}" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese La Ciudad" />
              </div>
            </div>


             <div class="form-group">
              <label class="col-sm-3 control-label">Entidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="entidad" type="text"  maxlength="15" onchange="mayus(this);"  class="form-control" value="{{ $clientes->entidad}}" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese La Entidad" />
              </div>
            </div>




             <div class="form-group">
              <label class="col-sm-3 control-label">País: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="pais" type="text"  maxlength="15" onchange="mayus(this);"  class="form-control" value="{{ $clientes->pais}}"  onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese El País" />
              </div>
            </div>


                   <div class="form-group">
              <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="telefono" type="text" placeholder="Ingrese el número de teléfono del cliente"  value="{{ $clientes->telefono}}"  class="form-control mask" data-inputmask="'mask':'(999) 999-9999'">
              </div>
            </div>



                        <div class="form-group">
              <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="email" name="email" value="{{ $clientes->email}}" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de el cliente"/>

              </div>
            </div>




            <div class="form-row">    
        <label class="col-sm-3 control-label">Nuevo Saldo Del Cliente: <strog class="theme_color">*</strog></label>
    <div class="col-sm-2">
    <div class="input-group">
     <div class="input-group-addon">$</div>

    
         <input name="saldocliente" maxlength="9" type="number" value="1000.00" value="{{ $clientes->saldocliente}}" min="1" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Saldo Inicial" onkeypress=" return soloNumeros(event);"/>
    </div>
        </div>
        </div>
<!--/form-group-->



          <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="/clientes" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
        </form>
      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->
</html> 
@endsection

