<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-renovar-{{$contrato->idEmpleado}}">
  <div class="modal-dialog">
    <div class="modal-content panel default blue_border horizontal_border_1">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Renovar Contrato</h3>
            </div>
            <div class="porlets-content" style="margin-bottom: -50px;">

              <div class="form-group">
                <label class="col-sm-3 control-label">Fecha Inicio: <strog class="theme_color">*</strog></label>
                <div class="col-sm-6">

                  <input name="fechaInicio"  id="fechaInicio"   type="text" required class="form-control mask" data-inputmask="'alias': 'date'">
                </div>
              </div>
              <br><br>

              <div class="form-group">
                <label class="col-sm-3 control-label">Fecha Fin: <strog class="theme_color">*</strog></label>
                <div class="col-sm-6">

                  <input name="fechaFin" id="fechaFin"    type="text" onblur="calcularTiempo();" required class="form-control mask" data-inputmask="'alias': 'date'">
                </div>
              </div>



            </div><!--/porlets-content--> 
          </div><!--/block-web--> 
        </div>
      </section>
    </div>
    <div class="modal-footer" style="margin-top: -10px;">
      <div class="row col-md-5 col-md-offset-7" style="margin-top: -5px;">

       <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
       <button type="submit" class="btn btn-primary">Aceptar</button>
     </form>
   </div>
 </div><!--/modal-content--> 
</div><!--/modal-dialog--> 
</div><!--/modal-fade--> 



