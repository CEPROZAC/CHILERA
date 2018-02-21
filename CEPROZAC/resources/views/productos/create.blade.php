@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Productos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('productos')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('productos')}}">Productos</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Agregar Producto</strong></h2> 
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
          <form action="{{route('productos.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}
            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="nombre" type="text"  onchange="mayus(this);"  class="form-control" required value="" placeholder="Ingrese nombre del producto" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Descripcion: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="descripcion"  maxlength="25" id="descripcion" onkeyup="mayus(this);"  class="form-control"    required placeholder="Ingrese la descripcion del producto"/>
              </div>
            </div>



            <div class="form-group">
              <label class="col-sm-3 control-label">Calidad <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="calidad" class="form-control" required>  
                 <option value="1era">
                  1era                  
                </option>
                <option value="2da">
                  2da                  
                </option>   
                <option value="2da">
                  3era                 
                </option>              
              </select>
              <div class="help-block with-errors"></div>
            </div>
          </div><!--/form-group-->


          <div class="form-group">
            <label class="col-sm-3 control-label">Unidad de Medida <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="unidad_de_Medida" class="form-control" required>  
               <option value="KILOGRAMOS">
                KILOGRAMOS                
              </option>
              <option value="TONELADA">
                TONELADA                 
              </option>                
            </select>
            <div class="help-block with-errors"></div>
          </div>
        </div><!--/form-group-->

        <div class="form-group">
          <label class="col-sm-3 control-label">Formatos de empaque <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="formato_de_Empaque" class="form-control" required>  
             <option value="TOTE">
              TOTE              
            </option>
            <option value="COSTAL">
              COSTAL                 
            </option>                
          </select>
          <div class="help-block with-errors"></div>
        </div>
      </div><!--/form-group-->

      <div class="form-group ">
        <label class="col-sm-3 control-label">Porcentaje de humedad</label>
        <div class="col-sm-6">
          <input type="text" name="porcentaje_Humedad" class="form-control mask" data-inputmask="'mask':'99%'">
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-3 control-label">Proveedor<strog class="theme_color">*</strog></label>
        <div class="col-sm-6">
          <select name="proveedor" class="form-control" required>
           @foreach($proveedor as $proveedor)
           <option value="{{$proveedor->id}}">
            {{$proveedor->nombre}}
          </option>
          @endforeach
        </select>
        <div class="help-block with-errors"></div>
      </div>
    </div><!--/form-group-->


    <div class="form-group ">
      <label class="col-sm-3 control-label">Imagen</label>
      <div class="col-sm-6">
       <input  name="" type="file" >
     </div>
   </div>

   

   <div class="form-group">
    <div class="col-sm-offset-7 col-sm-5">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="{{url('/productos')}}" class="btn btn-default"> Cancelar</a>
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
  Schema::create('productos', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nombre');
        $table->string('descripcion');
        $table->string('calidad');
        $table->string('unidad_de_Medida');
        $table->string('formato_de_Empaque');
        $table->string('porcentaje_Humedad');
        $table->string('proveedor');
        $table->string('estado');
        $table->timestamps();-->