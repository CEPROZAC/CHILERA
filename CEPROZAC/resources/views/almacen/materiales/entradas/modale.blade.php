<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete2">
  <div class="modal-dialog">
    <div class="modal-content panel default blue_border horizontal_border_1">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Agregar Material a Almácen</h3>
            </div>


            <div class="porlets-content" style="margin-bottom: -50px;">
       <form action="{{route('almacen.entradas.materiales.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate>
            {{csrf_field()}}

              <div class="form-group">
            <label class="col-sm-3 control-label">Nombre: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <input name="nombre" type="text"  value="{{Input::old('nombre')}}" maxlength="30"  onchange="mayus(this);"  class="form-control"  value="" placeholder="Ingrese nombre del producto" />

            </div>
          </div>

                    <div class="form-group">
            <label class="col-sm-3 control-label"> Proveedor: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="provedor_id" class="form-control" required>  
                @foreach($provedor as $provedores)
                <option value="{{$provedores->id}}">
                 {{$provedores->nombre}}
               </option>
               @endforeach              
             </select>
             <div class="help-block with-errors"></div>
           </div>
         </div><!--/form-group-->



         <div class="form-group">
          <label class="col-sm-3 control-label">Codigo de Barras: <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <input type="radio" value="1" name="habilitarDeshabilitar" onchange="habilitar(this.value);" checked> Ingrese Codigo de Barras
            </br> 
            <input type="radio" value="2" name="habilitarDeshabilitar"  onchange="habilitar(this.value);"> GenerarCodigo de Barras Automatico

            <input type="radio" value="3" name="habilitarDeshabilitar"  onchange="habilitar(this.value);"> Ninguno

          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 control-label"> <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
           <input type="text" name="codigo" id="segundo"  maxlength="12"   class="form-control" placeholder="Ingrese el Codigo de Barras"  value="{{Input::old('codigo')}}"/><br>
           <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('codigo')}}</div>
         </div>
       </div>

       <div class="form-group ">
        <label class="col-sm-3 control-label">Imagen</label>
        <div class="col-sm-6">
         <input  name="imagen" type="file"  value="{{Input::old('imagen')}}" accept=".jpg, .jpeg, .png" >
       </div>
     </div>
     



     <div class="form-group">
      <label class="col-sm-3 control-label">Descripción: <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">
        <input name="descripcion" type="text"  value="{{Input::old('descripcion')}}"  maxlength="70"  onchange="mayus(this);"  class="form-control"  value="" placeholder="Ingrese Descripción del Material" />
      </div>
    </div>

    <div class="form-group">
      <label  class="col-sm-3 control-label">Cantidad en Almacén <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">
        <input name="cantidad" maxlength="9" type="number" value="{{Input::old('cantidad')}}" min="1" max='9999999' step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency"  value="" placeholder="Ingrese la Cantidad en Almacén" onkeypress=" return soloNumeros(event);" />
      </div>    
    </div>
 
            </div><!--/porlets-content--> 
          </div><!--/block-web--> 
        </div>
      </section>
    </div>
    <div class="modal-footer" style="margin-top: -10px;">
      <div class="row col-md-5 col-md-offset-7" style="margin-top: -5px;">
         <input type="hidden" name="_token2" value="{{ csrf_token() }}"> 
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         <button type="submit" id="registrar" onclick="registro();" class="btn btn-success">Guardar</button>
         </form>
     </div>
   </div>
 </div><!--/modal-content--> 
</div><!--/modal-dialog--> 
</div><!--/modal-fade--> 

<script>
  function habilitar(value)
  {
    if(value=="1")
    {
// habilitamos
document.getElementById("segundo").disabled=false;
document.getElementById("segundo").value = "";
document.getElementById("segundo").focus(); 
}else if(value=="2"){
// deshabilitamos
document.getElementById("segundo").disabled=false;
document.getElementById("segundo").readonly="readonly";
document.getElementById("segundo").readonly=true;
var aleatorio = Math.floor(Math.random()*999999999999);
document.getElementById("segundo").value=aleatorio;
}else if (value=="3"){
  document.getElementById("segundo").disabled=true;
  document.getElementById("segundo").value = "";
}
 function registro()
 {
  document.getElementById("cantidad").value = 1;

 }
}
</script>
</head>