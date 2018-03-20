@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Materiales</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a style="color: #808080" href="{{url('/almacen/materiales')}}">Inicio</a></li>
      <li><a style="color: #808080" href="{{url('/almacen/materiales')}}">Almacén de Materiales</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;"><strong>Salida de Material</strong></h2>
            </div>
            <div class="col-md-4">
              <div class="btn-group pull-right">
                <div class="actions"> 
                </div>
              </div>
            </div>    
          </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="porlets-content">
          <form action="{{route('almacen.materiales.store')}}" method="post" class="form-horizontal row-border" parsley-validate novalidate  files="true" enctype="multipart/form-data" accept-charset="UTF-8">


            {{csrf_field()}}
            

<div class="container clear_both padding_fix">
      <div class="block-web">
<div class="row">
 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
           <div class="form-group">
           <label for="entrego">Entrego:</label>
            <select name="entrego" class="form-control selectpicker" data-live-search="true">  
              @foreach($empleado as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>
       </div>
       </div>
       </div>

<div class="container clear_both padding_fix">
      <div class="block-web">
       <div class="row">
          <div class="panel panel-primary">
            <div class="panel-body">
              <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group"> 
          <label for="material">Material </label>
            <select name="id_materialk" class="form-control selectpicker"  data-live-search="true"  required id="id_materialk" >  
              @foreach($material as $mat)
              <option value="{{$mat->cantidad}}_{{$mat->descripcion}}_{{$mat->codigo}}_{{$mat->id}}_{{$mat->nombre}}">
               {{$mat->nombre}} {{$mat->id}} {{$mat->cantidad}}
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div><!--/form-group-->

        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
         <div class="form-group"> 
                <label for="scantidad">Cantidad de Salida </label>
                <input name="scantidad" id="scantidad" type="number" value="1" max="{{$mat->cantidad}}" min="1" required="" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" maxlength="5"  />
               </div>    
               </div>  

         <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
         <div class="form-group"> 
                <label for="pcantidad">Cantidad en Almacén </label>
                <input name="pcantidad" id="pcantidad" type="number" disabled class="form-control" />
               </div>    
               </div>  

 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
         <div class="form-group"> 
                <label for="descripcion">Descripción </label>
                <input name="descripcion" id="descripcion" disabled class="form-control" />
               </div>    
               </div>  


             
       </div>
          <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group"> 
                  <button type="button" id="btn_add" agregar(); class="btn btn-primary">Agregar</button>
                </div>
              </div>

              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group"> 
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color:#A9D0F5">
                      <th>Opciones</th>
                      <th>Articulo</th>
                      <th>Cantidad</th>
                      <th>Entrego</th>
                      <th>Recibio</th>
                      <th>Fecha</th>
                    </thead>
                    <tfoot>
                      <th>Total</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th><h4 id="total">$/.0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                    </tfoot>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>

       </div>
       </div>

       </div>
       </div>


     


            <div class="form-group">
              <label class="col-sm-3 control-label">Destino: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="destino" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese el Destino de el Material"/>
              </div>
            </div>

           

        <div class="form-group">
          <label class="col-sm-3 control-label">Recibio : <strog class="theme_color">*</strog></label>
          <div class="col-sm-6">
            <select name="recibio" class="form-control" required>  
              @foreach($empleado as $emp)
              <option value="{{$emp->id}}">
               {{$emp->nombre}} {{$emp->apellidos}} 
             </option>
             @endforeach              
           </select>
           <div class="help-block with-errors"></div>
         </div>
       </div>

        <div class="form-group">
              <label class="col-sm-3 control-label">Tipo de Movimiento: <strog class="theme_color">*</strog></label>
              <div class="col-sm-6">

                <input name="tipo_movimiento" type="text"  maxlength="35" onchange="mayus(this);"  class="form-control" onkeypress=" return soloLetras(event);" required value="" placeholder="Ingrese el Tipo de Movimiento Realizado"/>
              </div>
            </div>



       






     <div class="form-group">
      <div class="col-sm-offset-7 col-sm-5">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/empleados" class="btn btn-default"> Cancelar</a>
      </div>
    </div><!--/form-group-->
  </form>
</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->
</html> 

<script>
var select = document.getElementById('id_materialk');
select.addEventListener('change',
  function(){
    var selectedOption = this.options[select.selectedIndex];
    console.log(selectedOption.value + ': ' + selectedOption.text);
    var cantidadtotal = selectedOption.value;
    limite = "5",
    separador = "_",
    arregloDeSubCadenas = cantidadtotal.split(separador, limite);
    stock=arregloDeSubCadenas[0];
    descripcion=arregloDeSubCadenas[1];

    console.log(arregloDeSubCadenas); 
    document.getElementById("pcantidad").value=stock;
    document.getElementById("descripcion").value=descripcion;
       document.getElementById("scantidad").value = "1";
    document.getElementById("scantidad").max=stock;

  });


function agregar(){
        var select=document.getElementById('id_materialk');
        select.addEventListener('change',
           function(){
    var selectedOption = this.options[select.selectedIndex];
    console.log(selectedOption.value + ': ' + selectedOption.text);
    var cantidadtotal = selectedOption.value;
         limite = "5",
    separador = "_",
    arregloDeSubCadenas = cantidadtotal.split(separador, limite);

      cantidad=arregloDeSubCadenas[0];
      descripcion=arregloDeSubCadenas[1];
      codigo=arregloDeSubCadenas[2];
      id=arregloDeSubCadenas[3];
      nombre=arregloDeSubCadenas[4];
 });
      if(id!="" && cantidad!="" && cantidad>0 && descripcion!="" && nombre!="")
        {
          if(cantidad>=1)
          {
            subtotal[cont]=(cantidad*precio_venta-descuento);
             total=total+subtotal[cont];
          var  fila='<tr class="selected" id="fila' +cont+'"><td><button type="button" class="btn  btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+ id+'">'+articulo+'</td><td><input name="cantidad[]" type="number" value="'+ cantidad+'"></td><td><input name="precio_venta[]" type="number" value="'+ precio_venta+'" enable></td><td><input name="descuento[]" type="number" value="'+ descripcion+'"></td><td>'+subtotal[cont]+'</td></tr>';
                    cont++;
                    limpiar();

                    $("#total").html("$"+total);
                    alert(total);
                     $("#total_venta").val(total);

                    evaluar();
                    $("#detalles").append(fila);
          }
          else
          {
            alert("La  cantidad  a vender supera el stock")
          }
          
                }
                    else
                    {
                       alert("Error al ingresar el detalle  de la, revise los  datos del  articulo");
                    }

        
    }


    


</script>
 

@endsection

