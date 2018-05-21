@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Contratos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/contratos')}}">Inicio</a></li>
      <li class="active">Contratos</a></li> 
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
              <h2 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>Contratos </strong></h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>

                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="contratos/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Empleado"> <i class="fa fa-plus"></i> Registrar </a>

                    <a class="btn btn-sm btn-warning tooltips" href="{{route('contratos.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                  </div>
                  <p></p>
                  {!! Form::open(array('url'=>'contratos','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
                  <input id="searchTerm" type="text"  name="searchText" value="{{$searchText}}" role="search" />
                  {{Form::close()}}

                </b>
              </div>
            </div>
          </div>
        </div>



        <div class="porlets-content">
         <div class="table-responsive">
           <table class="table  table-bordered table-condensed table-hover" id="datos" >
            <thead>
              <tr >
                <th  >Nombre Completo</th>
                <th style="display:none;" >Fecha_Ingreso</th>

                <th style="display:none;">Fecha_Alta</th>
                <th style="display:none;">NSS</th>
                <th style="display:none;">Fecha_Nacimiento</th>
                <th >CURP</th>
                <th >Correo</th>
                <th >Telefono</th>
                <th style="display:none;">sexo</th>
                <th style="display:none;">sueldo</th>
                <th style="display:none;">Duracion</th>
                <th >Ver</th>
                <th >Descargar</th>


                <td><center><b>Editar</b></center></td>
                <td><center><b>Borrar</b></center></td>
              </tr>
            </thead>
            <tbody>

             @foreach($contratos  as $contrato)


             @if($contrato->sueldo_Fijo < 100 )

             <tr class="gradeX" >


               <td >{{$contrato->nombre}} {{$contrato->apellidos}} </td>

               <td style="display:none;" >{{$contrato->fecha_Ingreso}}</td>
               <td style="display:none;" >{{$contrato->fecha_Alta_Seguro}}</td>
               <td style="display:none;">{{$contrato->numero_Seguro_Social}}</td>
               <td style="display:none;">{{$contrato->fecha_Nacimiento}}</td>
               <td >{{$contrato->curp}}</td>
               <td  >{{$contrato->email}}</td>
               <td >{{$contrato->telefono}}</td>

               <td style="display:none;" >{{$contrato->sueldo_Fijo}}</td>
               <td style="display:none;"   >{{$contrato->sexo}}</td>
               <td style="display:none;">{{floor($contrato->duracionContrato/30)}} {{$contrato->duracionContrato%30}}</td>
               <td >

                 <center>
                   <a href="{{URL::action('ContratosController@verInformacion',$contrato->idContrato)}}" class="btn btn-info btn-sm" role="button"><i class="fa fa-eye" onclick="calcular();"></i></a>
                 </center>
               </td>

               <td >

                 <center>
                   <a href="{{URL::action('ContratosController@pdf',$contrato->idContrato)}}" class="btn btn-warning btn-sm" role="button"><i class="fa fa-download"></i></a>
                 </center>
               </td>

               <td>  <a href="{{URL::action('ContratosController@edit',$contrato->idContrato)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>
               </td> 
             </td>
             <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$contrato->idContrato}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
             </td>
           </tr>
           @else
           <tr class="gradeX example" >


             <td >{{$contrato->nombre}} {{$contrato->apellidos}} </td>

             <td style="display:none;" >{{$contrato->fecha_Ingreso}}</td>
             <td style="display:none;" >{{$contrato->fecha_Alta_Seguro}}</td>
             <td style="display:none;">{{$contrato->numero_Seguro_Social}}</td>
             <td style="display:none;">{{$contrato->fecha_Nacimiento}}</td>
             <td >{{$contrato->curp}}</td>
             <td  >{{$contrato->email}}</td>
             <td >{{$contrato->telefono}}</td>

             <td style="display:none;" >{{$contrato->sueldo_Fijo}}</td>
             <td style="display:none;"   >{{$contrato->sexo}}</td>
             <td style="display:none;">{{floor($contrato->duracionContrato/30)}} {{$contrato->duracionContrato%30}}</td>
             <td >

               <center>
                 <a href="{{URL::action('ContratosController@verInformacion',$contrato->idContrato)}}" class="btn btn-info btn-sm" role="button"><i class="fa fa-eye" onclick="calcular();"></i></a>
               </center>
             </td>

             <td >

               <center>
                 <a href="{{URL::action('ContratosController@pdf',$contrato->idContrato)}}" class="btn btn-warning btn-sm" role="button"><i class="fa fa-download"></i></a>
               </center>
             </td>

             <td>  <a href="{{URL::action('ContratosController@edit',$contrato->idContrato)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>
             </td> 
           </td>
           <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$contrato->idContrato}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
           </td>
         </tr>
         @endif
         @include('Recursos_Humanos.contratos.modal')
         @endforeach
       </tbody>
       <tfoot>
        <tr>

          <th >Nombre Completo</th>
          <th style="display:none;">fecha_Ingreso</th>
          <th style="display:none;">Fecha Alta</th>
          <th style="display:none;">NSS</th>
          <th style="display:none;">Fecha Nacimiento </th>
          <th >CURP </th>
          <th > email </th>
          <th >Telefono </th>
          <th style="display:none;">sexo </th>
          <th style="display:none;">suedlo fijo </th>
          <th style="display:none;" >Duracion</th>
          <th >Ver</th>
          <th >Descargar</th>
          <td><center><b>Editar</b></center></td>
          <td><center><b>Borrar</b></center></td> 

        </tr>
      </tfoot>
    </table>
    
  </div><!--/table-responsive-->
  <center>
    {!!$contratos->render()!!}
  </center>

</div><!--/porlets-content-->
</div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->
</div>



@endsection
