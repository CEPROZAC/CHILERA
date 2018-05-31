<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete2-{{$materiales->id}}">
  <div class="modal-dialog">
    <div class="modal-content panel default blue_border horizontal_border_1">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Agregar Stock</h3>
            </div>


            <div class="porlets-content" style="margin-bottom: -50px;">
          <form action="{{url('almacenes/agroquimicos/stock', [$materiales->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">



              <div class="form-group">
              <label  class="col-sm-3 control-label">Agregar Stock<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="cantidades" maxlength="9" type="number" value="1" min="1" max='9999999' step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese la Cantidad" onkeypress=" return soloNumeros(event);" />
               </div>    
               </div>  
                           <br> <br>

                <div class="form-group">
            <label class="col-sm-3 control-label"> Proveedor: <strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="provedor_id2" class="form-control" required>  
                @foreach($provedor as $provedores)
                <option value="{{$provedores->id}}">
                 {{$provedores->nombre}}
               </option>
               @endforeach              
             </select>
             <div class="help-block with-errors"></div>
           </div>
         </div><!--/form-group-->
            <br> <br>
      <div class="form-group">
        <label class="col-sm-3 control-label">Fecha de Compra de Material: <strog class="theme_color">*</strog></label>
        <div class="col-sm-6">

         <input type="date" name="fecha2" id="fecha2" value="" class="form-control mask" >
       </div>
     </div>

            <br> <br>

            <br> <br>
         <div class="form-group">
          <label class="col-sm-3 control-label">Comprador : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="recibio" id="recibio" value="recibio" class="form-control" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->nombre}} {{$emp->apellidos}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
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

             
             <input name="preciou" maxlength="9" type="number" value="{{Input::old('preciou')}}" min="0" max='9999999' step="100" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese el Precio de este Producto" onkeypress=" return soloNumeros(event);"/>
           </div>
         </div>
       </div>
       
    </div>
            <br> <br>
 
            </div><!--/porlets-content--> 
          </div><!--/block-web--> 
        </div>
      </section>
    </div>
    <div class="modal-footer" style="margin-top: -10px;">
      <div class="row col-md-5 col-md-offset-7" style="margin-top: -5px;">
         <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         <button type="submit" class="btn btn-primary">Agregar</button>
         </form>
     </div>
   </div>
 </div><!--/modal-content--> 
</div><!--/modal-dialog--> 
</div><!--/modal-fade--> 