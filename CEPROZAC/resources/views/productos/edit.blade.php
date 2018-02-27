@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">productos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/productos')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/productos')}}">Productos</a></li>
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
              <div class="actions"><h3></h3> </div>
              <h2 class="content-header" style="margin-top: -5px;"><strong>Editar Producto: {{ $productos->nombre}}</strong></h2> 
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
          <form action="{{url('productos', [$productos->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
              <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="nombre" type="text"  onchange="mayus(this);"  class="form-control" required value="{{ $productos->nombre}}" placeholder="Ingrese nombre del producto"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Descripcion: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="descripcion" maxlength="25" id="descripcion" onkeyup="mayus(this);"  class="form-control"   class="form-control" required value="{{ $productos->descripcion}}" required placeholder="Ingrese la descripcion del producto"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Calidad<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="calidad" class="form-control" required>
                  @if($productos->calidad=="1era")
                  <option value="1era" selected>
                    1era
                  </option>
                  <option value="2da" >
                    2da
                  </option>
                  <option value="3era">
                    3era
                  </option>
                  @elseif($productos->calidad=="2da")
                  <option value="1era">
                    1era
                  </option>
                  <option value="2da" selected>
                    2da
                  </option>
                  <option value="3era">
                    3era
                  </option>
                  @else
                  <option value="1era">
                    1era
                  </option>
                  <option value="2da" >
                    2da
                  </option>
                  <option value="3era" selected>
                    3era
                  </option>
                  @endif
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div><!--/form-group-->


            <div class="form-group">
              <label class="col-sm-3 control-label">Unidad de Medida <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="unidad_de_Medida" class="form-control" required>  
                  @if($productos->unidad_de_Medida=="KILOGRAMOS")
                  <option value="KILOGRAMOS" selected>
                    KILOGRAMOS                
                  </option>
                  <option value="TONELADA">
                    TONELADA                 
                  </option>     
                  @else 
                  <option value="KILOGRAMO" >
                    KILOGRAMOS                
                  </option>
                  <option value="TONELADA" selected>
                    TONELADA                 
                  </option>     
                  @endif           
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div><!--/form-group-->

            <div class="form-group">
              <label class="col-sm-3 control-label">Formatos de empaque <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="formato_de_Empaque" class="form-control" required>  
                  @if($productos->formato_de_Empaque=="TOTE")
                  <option value="TOTE" selected>
                    TOTE              
                  </option>
                  <option value="COSTAL">
                    COSTAL                 
                  </option> 
                  @else
                  <option value="TOTE" >
                    TOTE              
                  </option>
                  <option value="COSTAL" selected>
                    COSTAL                 
                  </option> 
                  @endif               
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div><!--/form-group-->

            <div class="form-group ">
              <label class="col-sm-3 control-label">Porcentaje de humedad</label>
              <div class="col-sm-6">
                <input type="text" name="porcentaje_Humedad" value="{{ $productos->porcentaje_Humedad}}"  class="form-control mask" data-inputmask="'mask':'99%'">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-3 control-label">Proveedor<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="proveedor" class="form-control" required>
                 @foreach($proveedores as $proveedor)
                 @if($proveedor->id==$productos->proveedor)
                 <option value="{{$proveedor->id}}" selected>
                  {{$proveedor->nombre}}
                </option>
                @else
                <option value="{{$proveedor->id}}">
                  {{$proveedor->nombre}}
                </option>
                @endif
                @endforeach
              </select>
              <div class="help-block with-errors"></div>
            </div>
          </div><!--/form-group-->

           <input type="text" hidden name="nombreimagen" value="{{$productos->imagen}}">

          <div class="form-group ">
            <label class="col-sm-3 control-label">Imagen</label>
            <div class="col-sm-6">
             <input  type="file" hidden name="imagen"  value="{{$productos->imagen}}" class="form-control"  accept=".jpg, .jpeg, .png">
             @if (($productos->imagen)!="")
             <img src="{{asset('imagenes/productos/'.$productos->imagen)}}" height="100px" width="100px">
             @endif
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
