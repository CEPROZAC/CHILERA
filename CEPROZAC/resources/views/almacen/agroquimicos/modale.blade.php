<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete2-{{$materiales->idAgroquimico}}">
  <div class="modal-dialog">
    <div class="modal-content panel default blue_border horizontal_border_1">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Agregar Stock: {{ $materiales->nombre}}</h3>
            </div>


            <div class="porlets-content" style="margin-bottom: -50px;">



              <form action="{{url('almacenes/agroquimicos/stock', [$materiales->idAgroquimico])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate  enctype="multipart/form-data" accept-charset="UTF-8">
                  {{csrf_field()}}

                  <input type="hidden" name="_method" value="PUT">

                  <input type="hidden" value="{{$materiales->idAgroquimico}}">
                  <div class="form-group">
                    <label  class="col-sm-3 control-label">Agregar Stock<strog class="theme_color">*</strog></label>
                    <div class="col-sm-8">
                      <input name="cantidad"  maxlength="9" type="text" value="1" min="1" max='9999999'" class="form-control" required placeholder="Ingrese la Cantidad" onkeypress=" return soloNumeros(event);" />
                    </div>    
                  </div>
                  <br> <br>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Proveedores : <strog class="theme_color">*</strog></label>
                    <div class="col-sm-8">
                      <select name="provedor"    class="form-control select" required>  
                        @foreach($provedores as $provedor)
                        <option value="{{$provedor->id}}">
                         {{$provedor->nombre}} 
                       </option>
                       @endforeach              
                     </select>
                     <div class="help-block with-errors"></div>
                   </div>
                 </div>
                 <br> <br>

                 <div class="form-group">
                  <label class="col-sm-3 control-label">Fecha de Compra<strog class="theme_color">*</strog></label>
                  <div class="col-sm-8">

                    <input type="date" name="fecha2{{$materiales->idAgroquimico}}"  class="form-control mask" required>
                  </div>
                </div>

                <br> <br>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Empresa : <strog class="theme_color">*</strog></label>
                  <div class="col-sm-8">
                    <select name="recibio{{$materiales->idAgroquimico}}" value="recibio"  class="form-control select" required>  
                      @foreach($empresas as $emp)
                      <option value="{{$emp->id}}">
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
                <div class="col-sm-8">
                  <select name="entregado_a{{$materiales->idAgroquimico}}"  value=""  class="form-control select" required>  
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
              <label class="col-sm-3 control-label">Recibe: <strog class="theme_color">*</strog></label>
              <div class="col-sm-8">
                <select name="recibe_alm{{$materiales->idAgroquimico}}"   class="form-control select" required>  
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
            <label class="col-sm-3 control-label">Observaciónes:</label>
            <div class="col-sm-8">

              <input name="observaciones{{$materiales->idAgroquimico}}" type="text"  maxlength="200" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);"  placeholder="Ingrese Observaciónes de la Compra"/>
            </div>
          </div>
          <br> <br>
          <div class="form-group">
            <label class="col-sm-3 control-label">N° Factura: <strog class="theme_color">*</strog></label>
            <div class="col-sm-8">
              <input name="factura{{$materiales->idAgroquimico}}"  type="text"  maxlength="10" onchange="mayus(this);"  class="form-control"   placeholder="Ingrese el Número de Factura" required />
              <div class="text-danger" id='error_rfc'>{{$errors->formulario->first('factura')}}</div>
            </div>
          </div>
          <br> <br>
          <div class="form-row">    
            <label class="col-sm-3 control-label">Precio Unitario <strog class="theme_color">*</strog></label>
            <div class="col-sm-8">
              <div class="input-group">
               <div class="input-group-addon">$</div>
               <input name="precioUnitario" maxlength="9" type="number"  min="0" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Precio de este Producto" onkeypress=" return soloNumeros(event);"/>
             </div>
           </div>
         </div>
         <br> <br>

         <br> <br>

         <div class="form-group"> 
           <label class="col-sm-3 control-label">% IVA  <strog class="theme_color">*</strog></label>
           <div class="col-sm-8">
             <input name="iva" value="0" type="text" class="form-control" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IVA del Producto" />
           </div>    
         </div>
         <br> <br>
         <div class="form-group"> 
           <label class="col-sm-3 control-label">% IEPS </label>
           <div class="col-sm-8">
             <input name="ieps"  value="0" type="text" class="form-control" onkeypress=" return soloNumeros(event);" placeholder="Ingrese el % IEPS del Producto" />
           </div>    
         </div>  

         <br> <br>

         <div class="form-group">
          <label class="col-sm-3 control-label">Tipo de Moneda: <strog class="theme_color">*</strog></label>
          <div class="col-sm-8">
            <select name="moneda{{$materiales->idAgroquimico}}"  class="form-control select" data-live-search="true"  value="{{Input::old('moneda')}}">

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
  <div class="form-group">
    <label class="col-sm-3 control-label"></label>
    <div class="col-sm-8">
     <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
     <button type="submit"  class="btn btn-primary">Agregar</button>
   </div>
 </div>
 <br> <br>
</div>

</div>
</section>
</div>

</form>
</div><!--/modal-content--> 
</div><!--/modal-dialog--> 
</div><!--/modal-fade--> 


<script>

</script>