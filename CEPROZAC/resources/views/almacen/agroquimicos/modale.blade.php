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
          <form action="{{url('/almacenes/agroquimicos/stock', [$materiales->id])}}" method="post" class="form-horizontal row-border" parsley-validate novalidate files="true" enctype="multipart/form-data" accept-charset="UTF-8">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT">

              <div class="form-group">
              <label  class="col-sm-3 control-label">Agregar Stock<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <input name="cantidades" maxlength="9" type="number" value="1" min="1" max='9999999' step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required value="" placeholder="Ingrese la Cantidad" onkeypress=" return soloNumeros(event);" />
               </div>    
               </div>  
 
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