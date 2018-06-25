@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Almacén de Limpieza</h1>
    <h2 class="">Almacén de Limpieza</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('almacenes/limpieza')}}">Inicio</a></li>
      <li class="active">Almacén de Limpieza</a></li>
    </ol>
  </div>
</div>
<div class="container clear_both padding_fix">
  <div class="row">
    <div class="col-md-12">
      <div class="block-web">
        <div class="header">
          <div class="row" style="margin-top: 15px; margin-bottom: 12px;">
            <div class="col-sm-7">
              <div class="actions"> </div>
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Productos de Limpieza </strong></h2>
            </div>
            <div class="col-md-12">
              <div class="btn-group pull-right">
                <b>


                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="{{ route('almacenes.limpieza.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Material"> <i class="fa fa-plus"></i> Registrar Material </a>

                    <a class="btn btn-sm btn-warning tooltips" href="{{ route('almacen.limpieza.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                    <a class="btn btn-sm btn-danger" href="{{ route('almacen.salidas.limpieza.index')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i>Salidas de Almacén </a>

                    <a class="btn btn-sm btn btn-info" href="{{ route('almacen.entradas.limpieza.index')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-plus"></i>Entradas de Almacén </a>


                  </div>

                           <div class="text-success" id='result'>
          @if(Session::has('message'))
          {{Session::get('message')}}
          @endif
        </div>
                </b>
              </div>
            </div>
          </div>
        </div>

        <div class="porlets-content">
          <div class="table-responsive">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
                <tr>
                  <th>Id </th>
                  <th>Nombre </th>
                  <th>Proveedor </th>
                  <th>Codigo de Barras </th>
                  <th>Imagen </th>
                  <th>Descripción </th>
                  <th>Cantidad en Almacén</th>
                  <th>Stock Minimo</th>
                  <td><center><b>Editar</b></center></td>
                  <td><center><b>Borrar</b></center></td>                            
                </tr>
              </thead>
              <tbody>
                @foreach($material  as $materiales)
                <tr class="gradeA">
                  <td>{{$materiales->id}} </td>
                  <td>{{$materiales->nombre}} </td>
                  <td>{{$materiales->provedor}} </td>
                  <td><?php echo DNS1D::getBarcodeHTML("$materiales->codigo", "EAN13");?>
                    <div style="text-align:center;">
                      {{$materiales->codigo}}                
                    </div>
                    <a href="{{URL::action('AlmacenLimpiezaController@invoice',$materiales->id)}}" class="btn btn-primary btn-sm" target="_blank" role="button"><i class="fa fa-print"></i></a> 
                  </td>
                  <td>
                    <img src="{{asset('imagenes/AlmacenLimpieza/'.$materiales->imagen)}}" alt="{{$materiales->nombre}}" height="100px" width="100px" class="img-thumbnail">
                  </td>              
                  <td>{{$materiales->descripcion}} </td>
                  <td>{{$materiales->cantidad}} {{$materiales->medida}} <a class="btn btn-sm btn-success tooltips" data-target="#modal-delete2-{{$materiales->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"> <i class="fa fa-plus"></i></a> </td>
                    <?php
                  $x= $materiales->cantidad;
                  $y= $materiales->stock_minimo;
                  $estilo='style="background:green"';
                  if ($x < $y){
                       $z=1;
                       echo "<td style='color:#FF0000'>{$materiales->stock_minimo}</td>";

                  } else {
                         echo "<td>{$materiales->stock_minimo} </td>"; 
                  }
                  ?>


                  modal          <td>  <a href="{{URL::action('AlmacenLimpiezaController@edit',$materiales->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
                </td>
                <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$materiales->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
                </td>
              </td>
            </td>

          </tr>
          @include('almacen.limpieza.modal')
          @include('almacen.limpieza.modale')
          @endforeach
        </tbody>
        <tfoot>
          <tr>
           <th>Id </th>
           <th>Nombre </th>
           <th>Proveedor </th>
           <th>Codigo de Barras </th>
           <th>Imagen </th>
           <th>Descripción </th>
           <th>Cantidad en Almacén</th>
            <th>Stock Minimo</th>
           <td><center><b>Editar</b></center></td>
           <td><center><b>Borrar</b></center></td>      
         </tr>
       </tfoot>
     </table>
   </div><!--/table-responsive-->
 </div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>
<script>
  window.onload=function() {
   var z = 1
   var table = document.getElementById('dynamic-table');
   for (var r = 1, n = table.rows.length-1; r < n; r++) {
    for (var c = 1, m = table.rows[r].cells.length; c < m; c++) {
     if (z == 1){
            var nom = table.rows[r].cells[c].innerHTML;
      z ++;
    }
    else if(z == 2){
     z ++;
   }else if(z == 3){
     z ++;
   }else if(z == 4){
     z ++;
   } else if (z == 5){
     z ++;
   }else if (z == 6){
             var d =table.rows[r].cells[c].innerHTML;
                limite = "1",
            separador = " ",
            arregloDeSubCadenas = d.split(separador, limite);
            var g=arregloDeSubCadenas[0];
          var x = parseInt(g);

     z ++;

   }else if(z == 7){
     var o =table.rows[r].cells[c].innerHTML;
        var y = parseInt(o);
             if (x < y){
      alert("El Stock Minimo del Producto "+nom+" debe ser Minimo de "+y+ " Unidad(es), Favor de Agregar mas Stock" );
    }
     z ++;

   }else if(z == 8){

     z ++;

   }else {
    z = 1;}
  

}
}
}

</script>

@endsection
