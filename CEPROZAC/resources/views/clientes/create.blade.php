@extends('layouts.principal')
@section('contenido')
<html>
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Clientes Ceprozac</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a href="?c=Inicio">Crear Cliente</a></li>
      <li><a href="?c=Cliente">Nuevo Registro</a></li>
      <li class="active">Ceprozac</li>
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
        </div>
        <div class="porlets-content">
          <form action="{{route('clientes.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}
            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="nombre" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de el Cliente"/>
              </div>
            </div>

              <div class="form-group">
              <label class="col-sm-3 control-label">Calle: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="calle" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese Direccion de el Cliente"/>
              </div>
            </div>

                          <div class="form-group">
              <label class="col-sm-3 control-label">Numero: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="numero" maxlength="4" type="number"  class="form-control" required value="" placeholder="Ingrese el numero de su Domicilio"/>
              </div>
            </div>

                          <div class="form-group">
              <label class="col-sm-3 control-label">Colonia: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="colonia" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese Direccion de la Calle"  />
              </div>
            </div>

                                     <div class="form-group">
              <label class="col-sm-3 control-label">Ciudad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="ciudad" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese La Ciudad" />
              </div>
            </div>
                                     <div class="form-group">
              <label class="col-sm-3 control-label">Entidad: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="entidad" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese La Entidad" />
              </div>
            </div>

                                                 <div class="form-group">
              <label class="col-sm-3 control-label">País: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="pais" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese El País" />
              </div>
            </div>

 
            <div class="form-group">
              <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="telefono" type="text" placeholder="Ingrese el número de teléfono del cliente"   class="form-control mask" data-inputmask="'mask':'(999) 999-9999'">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="email" name="email" value="" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de el cliente"/>

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Saldo Inical Del Cliente: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="saldocliente" type="number"   class="form-control" required value="" placeholder="Ingrese el Saldo Inicial"/>
              </div>
            </div>


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
