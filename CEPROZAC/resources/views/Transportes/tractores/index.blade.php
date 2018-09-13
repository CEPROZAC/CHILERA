@inject('metodo','CEPROZAC\Http\Controllers\TransporteController')
@extends('Transportes.transportes.layoutTransportes')
@section('tablaContenido')
@inject('metodo','CEPROZAC\Http\Controllers\TransporteController')
@extends('Transportes.transportes.layoutTransportes')
@section('tablaContenido')
<table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info3">
  <thead>
    <tr>
      <th >Nombre Unidad </th>
      <th>Descripcion </th>
      <th>Mantenimientos</th>
      <th><center><b>Editar</b></center></th>
      <th><center><b>Borrar</b></center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($vehiculos  as $vehiculo)
    <tr class="gradeA">
      <td>{{$vehiculo->nombre}} </td>
      <td>{{$vehiculo->descripcion}} </td>
      <td><center><a class="btn btn-info btn-sm" href="{{URL::action('TransporteController@verTransportes',$vehiculo->id)}}" role="button"><i class="fa fa-sign-in"></i></a></center></td>
      <td> 
        <a href="{{URL::action('TransporteController@edit',$vehiculo->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>  
      </td>
      <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$vehiculo->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
      </td>

    </tr>

    @include('Transportes.transportes.modal')
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Nombre Unidad </th>
      <th>Descripcion </th> 
      <th><center><b>Mantenimientos</b></center></th>
      <th><center><b>Editar</b></center></th>
      <th><center><b>Borrar</b></center></th>
    </tr>
  </tfoot>
</table>
@endsection



@endsection


