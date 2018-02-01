@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class=""> Proveedores</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/provedores')}}">Inicio</a></li>
      <li><a  style="color: #808080" href="{{url('/provedores')}}"> Proveedores</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Registrar proveedor</strong></h2> 
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
          <form action="{{route('provedores.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}
            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="nombre" type="text"  onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese nombre de proveedor"/>

              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label">Telefono: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input type="text" placeholder="Ingrese el número de teléfono de proveedor" name="telefono" value="" class="form-control mask" data-inputmask="'mask':'(999) 999-9999'">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Direccion: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="direccion" type="text"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese Direccion de proveedor"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Email: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="email" name="email" value="" required parsley-type="email" class="form-control mask" placeholder="Ingrese email de proveedor"/>

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Empresa Factura<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="empresa_id" class="form-control" required>
                 @foreach($empresas as $empresas)
                 <option value="{{$empresas->id}}">
                  {{$empresas->nombre}}
                </option>
                @endforeach
              </select>
              <div class="help-block with-errors"></div>
            </div>
          </div><!--/form-group-->

          <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{url('/provedores')}}" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
        </form>
      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->

@endsection

<!--
 id         | int(10) unsigned | NO   | PRI | NULL                | auto_increment |
| nombre     | varchar(255)     | NO   |     | NULL                |                |
| telefono   | varchar(255)     | NO   |     | NULL                |                |
| direccion  | varchar(255)     | NO   |     | NULL                |                |
| email      | varchar(255)     | NO   |     | NULL                |                |
| estado     | varchar(255)     | NO   |     | NULL                |                |
| empresa_id | int(10) unsigned | NO   | MUL | NULL                |                |
| created_at | timestamp        | NO   |     | 0000-00-00 00:00:00 |                |
| updated_at | timestamp        | NO   |  
-->
