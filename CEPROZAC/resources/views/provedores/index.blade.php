@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Proveedores</h1>
    <h2 class="">Proveedores</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/provedores')}}">Inicio</a></li>
      <li class="active"> Proveedores</a></li>
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
              <h2 class="content-header" style="margin-top: -5px;">&nbsp;&nbsp;<strong>Proveedores</strong></h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>

                  <div class="btn-group" style="margin-right: 10px;">
                    <a class="btn btn-sm btn-success tooltips" href="provedores/create" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nuevo Proveedor"> <i class="fa fa-plus"></i> Registrar </a>

                     <a class="btn btn-sm btn-warning tooltips" href="{{ route('provedores.excel')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-download"></i> Descargar </a>

                  </div>
                  
                  </a>
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
                  <th>Nombre </th>
                  <th>Telefono </th>
                  <th>Direccion </th>
                  <th>Email </th>
                  <th>Empresa Factura </th>
                  <td><center><b>Editar</b></center></td>
                  <td><center><b>Borrar</b></center></td>
                </tr>
              </thead>
              <tbody>
                @foreach($provedor  as $provedores)
                <tr class="gradeA">
                  <td>{{$provedores->nombre}} </td>
                  <td>{{$provedores->telefono}} </td>
                  <td>{{$provedores->direccion}}</td>
                  <td>{{$provedores->email}}</td>
                  <td>{{$provedores->nombreEmpresa}}</td>
                  <td> 
                    <a href="{{URL::action('ProvedorController@edit',$provedores->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>  
                  </td>
                  <td> <a class="btn btn-danger btn-sm" data-target="#modal-delete-{{$provedores->id}}" data-toggle="modal" style="margin-right: 10px;"  role="button"><i class="fa fa-eraser"></i></a>
                  </td>
                </td>
              </tr>
              @include('provedores.modal')
              @endforeach
            </tbody>
            <tfoot>
              <tr>
               <th>Nombre </th>
               <th>Telefono </th>
               <th>Direccion </th>
               <th>Email </th>
               <th>Empresa Factura </th>
               <td><center><b>Editar</b></center></td>
               <td><center><b>Borrar</b></center></td>
             </tr>
           </tfoot>
         </table>
       </div><!--/table-responsive-->


                <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                  <thead>
                    <tr>
                      <th>Rendering engine</th>
                      <th>Browser</th>
                      <th class="hidden-phone">Platform(s)</th>
                      <th class="hidden-phone">Engine version</th>
                      <th class="hidden-phone">CSS grade</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeX">
                      <td>Trident</td>
                      <td>Internet
                        Explorer 4.0</td>
                      <td class="hidden-phone">Win 95+</td>
                      <td class="center hidden-phone">4</td>
                      <td class="center hidden-phone">X</td>
                    </tr>
                    <tr class="gradeC">
                      <td>Trident</td>
                      <td>Internet
                        Explorer 5.0</td>
                      <td class="hidden-phone">Win 95+</td>
                      <td class="center hidden-phone">5</td>
                      <td class="center hidden-phone">C</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Trident</td>
                      <td>Internet
                        Explorer 5.5</td>
                      <td class="hidden-phone">Win 95+</td>
                      <td class="center hidden-phone">5.5</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Trident</td>
                      <td>Internet
                        Explorer 6</td>
                      <td class="hidden-phone">Win 98+</td>
                      <td class="center hidden-phone">6</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Trident</td>
                      <td>Internet Explorer 7</td>
                      <td class="hidden-phone">Win XP SP2+</td>
                      <td class="center hidden-phone">7</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Trident</td>
                      <td>AOL browser (AOL desktop)</td>
                      <td class="hidden-phone">Win XP</td>
                      <td class="center hidden-phone">6</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Firefox 1.0</td>
                      <td class="hidden-phone">Win 98+ / OSX.2+</td>
                      <td class="center hidden-phone">1.7</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Firefox 1.5</td>
                      <td class="hidden-phone">Win 98+ / OSX.2+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Firefox 2.0</td>
                      <td class="hidden-phone">Win 98+ / OSX.2+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Firefox 3.0</td>
                      <td class="hidden-phone">Win 2k+ / OSX.3+</td>
                      <td class="center hidden-phone">1.9</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Camino 1.0</td>
                      <td class="hidden-phone">OSX.2+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Camino 1.5</td>
                      <td class="hidden-phone">OSX.3+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Netscape 7.2</td>
                      <td class="hidden-phone">Win 95+ / Mac OS 8.6-9.2</td>
                      <td class="center hidden-phone">1.7</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Netscape Browser 8</td>
                      <td class="hidden-phone">Win 98SE+</td>
                      <td class="center hidden-phone">1.7</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Netscape Navigator 9</td>
                      <td class="hidden-phone">Win 98+ / OSX.2+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.0</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.1</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1.1</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.2</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1.2</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.3</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1.3</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.4</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1.4</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.5</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1.5</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.6</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">1.6</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.7</td>
                      <td class="hidden-phone">Win 98+ / OSX.1+</td>
                      <td class="center hidden-phone">1.7</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Mozilla 1.8</td>
                      <td class="hidden-phone">Win 98+ / OSX.1+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Seamonkey 1.1</td>
                      <td class="hidden-phone">Win 98+ / OSX.2+</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Gecko</td>
                      <td>Epiphany 2.20</td>
                      <td class="hidden-phone">Gnome</td>
                      <td class="center hidden-phone">1.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>Safari 1.2</td>
                      <td class="hidden-phone">OSX.3</td>
                      <td class="center hidden-phone">125.5</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>Safari 1.3</td>
                      <td class="hidden-phone">OSX.3</td>
                      <td class="center hidden-phone">312.8</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>Safari 2.0</td>
                      <td class="hidden-phone">OSX.4+</td>
                      <td class="center hidden-phone">419.3</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>Safari 3.0</td>
                      <td class="hidden-phone">OSX.4+</td>
                      <td class="center hidden-phone">522.1</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>OmniWeb 5.5</td>
                      <td class="hidden-phone">OSX.4+</td>
                      <td class="center hidden-phone">420</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>iPod Touch / iPhone</td>
                      <td class="hidden-phone">iPod</td>
                      <td class="center hidden-phone">420.1</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Webkit</td>
                      <td>S60</td>
                      <td class="hidden-phone">S60</td>
                      <td class="center hidden-phone">413</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 7.0</td>
                      <td class="hidden-phone">Win 95+ / OSX.1+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 7.5</td>
                      <td class="hidden-phone">Win 95+ / OSX.2+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 8.0</td>
                      <td class="hidden-phone">Win 95+ / OSX.2+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 8.5</td>
                      <td class="hidden-phone">Win 95+ / OSX.2+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 9.0</td>
                      <td class="hidden-phone">Win 95+ / OSX.3+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 9.2</td>
                      <td class="hidden-phone">Win 88+ / OSX.3+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera 9.5</td>
                      <td class="hidden-phone">Win 88+ / OSX.3+</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Opera for Wii</td>
                      <td class="hidden-phone">Wii</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Nokia N800</td>
                      <td class="hidden-phone">N800</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Presto</td>
                      <td>Nintendo DS browser</td>
                      <td class="hidden-phone">Nintendo DS</td>
                      <td class="center hidden-phone">8.5</td>
                      <td class="center hidden-phone">C/A<sup>1</sup></td>
                    </tr>
                    <tr class="gradeC">
                      <td>KHTML</td>
                      <td>Konqureror 3.1</td>
                      <td class="hidden-phone">KDE 3.1</td>
                      <td class="center hidden-phone">3.1</td>
                      <td class="center hidden-phone">C</td>
                    </tr>
                    <tr class="gradeA">
                      <td>KHTML</td>
                      <td>Konqureror 3.3</td>
                      <td class="hidden-phone">KDE 3.3</td>
                      <td class="center hidden-phone">3.3</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeA">
                      <td>KHTML</td>
                      <td>Konqureror 3.5</td>
                      <td class="hidden-phone">KDE 3.5</td>
                      <td class="center hidden-phone">3.5</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeX">
                      <td>Tasman</td>
                      <td>Internet Explorer 4.5</td>
                      <td class="hidden-phone">Mac OS 8-9</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">X</td>
                    </tr>
                    <tr class="gradeC">
                      <td>Tasman</td>
                      <td>Internet Explorer 5.1</td>
                      <td class="hidden-phone">Mac OS 7.6-9</td>
                      <td class="center hidden-phone">1</td>
                      <td class="center hidden-phone">C</td>
                    </tr>
                    <tr class="gradeC">
                      <td>Tasman</td>
                      <td>Internet Explorer 5.2</td>
                      <td class="hidden-phone">Mac OS 8-X</td>
                      <td class="center hidden-phone">1</td>
                      <td class="center hidden-phone">C</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Misc</td>
                      <td>NetFront 3.1</td>
                      <td>Embedded devices</td>
                      <td class="center">-</td>
                      <td class="center">C</td>
                    </tr>
                    <tr class="gradeA">
                      <td>Misc</td>
                      <td>NetFront 3.4</td>
                      <td class="hidden-phone">Embedded devices</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">A</td>
                    </tr>
                    <tr class="gradeX">
                      <td>Misc</td>
                      <td>Dillo 0.8</td>
                      <td class="hidden-phone">Embedded devices</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">X</td>
                    </tr>
                    <tr class="gradeX">
                      <td>Misc</td>
                      <td>Links</td>
                      <td class="hidden-phone">Text only</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">X</td>
                    </tr>
                    <tr class="gradeX">
                      <td>Misc</td>
                      <td>Lynx</td>
                      <td class="hidden-phone">Text only</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">X</td>
                    </tr>
                    <tr class="gradeC">
                      <td>Misc</td>
                      <td>IE Mobile</td>
                      <td class="hidden-phone">Windows Mobile 6</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">C</td>
                    </tr>
                    <tr class="gradeC">
                      <td>Misc</td>
                      <td>PSP browser</td>
                      <td class="hidden-phone">PSP</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">C</td>
                    </tr>
                    <tr class="gradeU">
                      <td>Other browsers</td>
                      <td>All others</td>
                      <td class="hidden-phone">-</td>
                      <td class="center hidden-phone">-</td>
                      <td class="center hidden-phone">U</td>
                    </tr>
                  </tbody>
                </table>
              </div><!--/table-responsive-->
     </div><!--/porlets-content-->
   </div><!--/block-web-->
 </div><!--/col-md-12-->
</div><!--/row-->
</div>
@stop