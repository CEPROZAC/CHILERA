@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
	<div class="pull-left page_title theme_color">
		<h1>Almacenes Generales </h1>
		<h2 class="">Almacene General </h2>
	</div>
	<div class="pull-right">
		<ol class="breadcrumb">
			<li ><a style="color: #808080" href="{{url('/almacen/general')}}">Inicio</a></li>
			<li class="active">Almacen General: {{ $almacen2->nombre}} </a></li>
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
							<h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Almacen General: {{ $almacen2->nombre}} </strong></h2>
						</div>
						<div class="col-md-12">
							<div class="btn-group pull-right">
								<b>


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
									<th>N° Espacio </th>
									<th>Capacidad </th>
									<th>Lote Actual</th>
									<th>Espacio Ocupado</th>
									<th>Espacio Libre </th>
									<th>Producto </th>
									<th>Provedor </th>
									<th>Observaciónes </th>
									<th>Estado Actual </th>
									<td><center><b>Editar</b></center></td>
									<td><center><b>Borrar</b></center></td>                          
								</tr>
							</thead>
							<tbody>
								@foreach($almacen  as $almacenes)
								<tr class="gradeX">

									<td>{{$almacenes->num_espacio}} </td>
									
									<td>{{$almacenes->capacidad}} {{$almacenes->medida}} </td>   
									<td>{{$almacenes->nombre_lote}} </td>         
									<td>{{$almacenes->total_ocupado}} {{$almacenes->medida}}</td>
									<td>{{$almacenes->total_libre}} {{$almacenes->medida}}</td>
									<td>{{$almacenes->nomprod}} </td>
									<td>{{$almacenes->nombreprov}} </td>
									<td>{{$almacenes->descripcion}} </td>
									<td>{{$almacenes->estado}} </td>

									<td>  <a href="{{URL::action('AlmacenGeneralController@edit',$almacenes->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a> 
									</td>
									<td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$almacenes->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
									</td>

								</td>
							</td>

						</tr>
						@include('almacen.general.modal')
						@endforeach
					</tbody>
					<tfoot>
						<tr>                              

							<th>N° Espacio </th>
							<th>Capacidad </th>
							<th>Lote Actual</th>
							<th>Espacio Ocupado</th>
							<th>Espacio Libre </th>
							<th>Producto </th>
							<th>Provedor </th>
							<th>Observaciónes </th>
							<th>Estado Actual </th>
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


@endsection
