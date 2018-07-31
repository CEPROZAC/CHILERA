<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete2-{{$materiales->id}}">
  <div class="modal-dialog">
    <div class="modal-content panel default blue_border horizontal_border_1">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Agregar Stock: {{ $materiales->nombre}}</h3>
            </div>


            <div class="porlets-content" style="margin-bottom: -50px;">
          <form action="{{url('/almacenes/limpieza/stock', [$materiales->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">



              <div class="form-group">
              <label  class="col-sm-3 control-label">Agregar Stock<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="cantidades" id="cantidades" maxlength="9" type="text" value="1" min="1" max='9999999'" class="form-control" required placeholder="Ingrese la Cantidad" onkeypress=" return soloNumeros(event);" />
               </div>    
               </div>
                           <br> <br>

      <div class="form-group">
        <label class="col-sm-3 control-label">Fecha de Compra <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">

         <input type="date" name="fecha2" id="fecha2" value="" class="form-control mask" >
       </div>
     </div>


            <br> <br>
        <div class="form-group">
          <label class="col-sm-3 control-label">Empresa : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="recibio" id="recibio" value="recibio"  class="form-control select" required>  
              @foreach($empresas as $emp)
              <option value="{{$emp->nombre}}">
               {{$emp->nombre}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>
       <br> <br>

                <div class="form-group">
          <label class="col-sm-3 control-label">Entregado a : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="entregado_a" id="entregado_a" value=""  class="form-control select" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>
       <br> <br>


                       <div class="form-group">
          <label class="col-sm-3 control-label">Recibe en Almacén CEPROZAC : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="recibe_alm" id="recibe_alm" value=""  class="form-control select" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>
       <br> <br>
       <br> <br>

              <div class="form-group">
  <label class="col-sm-3 control-label">Observaciónes: <strog class="theme_color">*</strog></label>
  <div class="col-sm-6">

    <input name="observaciones" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" value="" placeholder="Ingrese Observaciónes de la Compra"/>
  </div>
</div>
            <br> <br>
       <div class="form-group">
        <label class="col-sm-3 control-label">Número de Factura: <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">
          <input name="factura" id="factura" value="" type="text"  maxlength="10" onchange="mayus(this);"  class="form-control" onkeypress=" return soloNumeros(event);"  value="" placeholder="Ingrese el Número de Factura"/>
        </div>
      </div>
            <br> <br>
      <div class="form-row">    
          <label class="col-sm-3 control-label">Precio Unitario <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <div class="input-group">
             <div class="input-group-addon">$</div>

             
             <input name="preciou" id ="preciou" maxlength="9" type="text" min="0" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required placeholder="Ingrese el Precio de este Producto" onkeypress=" return soloNumeros(event);"/>
           </div>
         </div>
       </div>

              <br> <br>
<br> <br>
        
   <div class="form-group"> 
     <label class="col-sm-3 control-label">% IVA  <strog class="theme_color">*</strog></label>
      <div class="col-sm-6">
    <input name="iva" id="iva" value="16" type="text" class="form-control" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IVA del Producto" />
  </div>    
  </div>

  <br> <br>

          <div class="form-group">
            <label class="col-sm-3 control-label">Tipo de Moneda: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="moneda"  id ="moneda" class="form-control select" data-live-search="true"  value="{{Input::old('moneda')}}">
                   
                @if(Input::old('moneda')=="Peso MXM")
                <option value='Peso MXN' selected>Peso MXN
                </option>
                <option value="Dolar USD">Dolar USD</option>
                @else
                <option value='Dolar USD' selected>Dolar USD
                </option>
                <option value="Peso MXN">Peso MXN</option>
                @endif
              </select>          
            </div>
            </div>

       
    </div>
            <br> <br>
 
            </div><!--/porlets-content--> 
          </div><!--/block-web--> 
          <br> <br>
          <div>
                   <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         <button type="submit" onclick="return save();" class="btn btn-primary">Agregar</button>
         </div>

        </div>
      </section>
    </div>

         </form>
 </div><!--/modal-content--> 
</div><!--/modal-dialog--> 
</div><!--/modal-fade--> 

<script>
  function save()
  {
    var w = document.getElementById('fecha2').value;
    var x = document.getElementById('preciou').value;
    var y = document.getElementById('factura').value;
    var z = document.getElementById('cantidades').value;
        var a = document.getElementById('iva').value;
    if (w !== "" && x !== "" && y !== "" && z !== "" && a !== ""  ){
      if (z < 1){
         swal("Alerta!", "La Cantidad de Entrada debe ser Mayor de 0!", "error");
        return false;
      }
return true;
    }else{
      swal("Alerta!", "Faltan campos Por llenar Favor de Verificar!", "error");
      return false;

    }

}
</script>