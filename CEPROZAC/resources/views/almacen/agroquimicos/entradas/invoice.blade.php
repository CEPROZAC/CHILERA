@inject('metodo','CEPROZAC\Http\Controllers\EntradasAgroquimicosController')
@extends('layouts.principal')
@section('contenido')
<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Entradas Agroquimicos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li ><a style="color: #808080" href="{{url('/almacen/salidas/agroquimicos')}}">Inicio</a></li>
      <li class="active">Reporte de Entrada de Almacén de Agroquimicos</a></li>
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
              <h4 class="content-header " style="margin-top: -5px;">&nbsp;&nbsp;<strong>INFORMACION DE FACTURA N°: {{$entrada->factura}} </strong></h4>
            </div>
            <div class="btn-group pull-right">
              <b>

                <div class="btn-group" style="margin-right: 10px;">
                  <a class="btn btn-sm btn-success tooltips" href="{{ route('almacen.entradas.agroquimicos.create')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Salida"> <i class="fa fa-plus"></i> Registrar Entrada de Almacén</a>

                  <a class="btn btn-sm btn-danger tooltips" href="/almacen/entradas/agroquimicos" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cancelar"> <i class="fa fa-times"></i> Salir</a>

                  <a class="btn btn-sm btn btn-info" href="{{URL::action('EntradasAgroquimicosController@pdfentradaAgroquimicos',$entrada->factura)}}" target="_blank" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Entrada"> <i class="fa fa-print"></i>Imprimir Reporte</a>

                </div>  
              </b>
            </div>

          </div>
        </div>
        <div class="porlets-content container clear_both padding_fix">
          <div class="invoice">

            <div class="invoice_body">
              <div  class="pull-left">
                <address>
                  <strong>Twitter, Inc.</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  <abbr title="Phone">P:</abbr> (123) 456-7890
                </address>
              </div>
              <div class="pull-right">
                <h1>invoice</h1>
              </div>
              <div class="clearfix"></div>
              <br/>
              <br/>
              <br/>
              <br/>
              <br/>
              <br/>
              <div class="row">
                <div class="col-sm-9">
                  <address>
                    <strong>Twitter, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                  </address>
                </div>
                <div class="col-sm-3">
                  <div> <strong>INVOICE NO :</strong> <span class="pull-right"> #AA-454-4113-00 </span> </div>
                  <br/>
                  <div class=""> <strong>INVOICE DATE :</strong> <span class="pull-right"><i class="fa fa-calendar"></i>16/4/2014</span><br/>
                  </div>
                  <br/>
                  <div class="well  red">
                    <div class="pull-left"> Total Due : </div>
                    <div class="pull-right"> 84,000 USD </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">QTY</th>
                    <th>ITEM</th>
                    <th>DESCRIPTION</th>
                    <th>PRICE</th>
                    <th>SUBTOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="tr_border">
                    <td class="text-center"><strong>1</strong></td>
                    <td><a href="javascript:void(0);">Invoice 1</a></td>
                    <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                    <td>$720.00</td>
                    <td>$720.00</td>
                  </tr>
                  <tr class="border">
                    <td class="text-center"><strong>1</strong></td>
                    <td><a href="javascript:void(0);">Invoice 2</a></td>
                    <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                    <td>$549.00</td>
                    <td>$549.00</td>
                  </tr>
                  <tr>
                    <td class="text-center"><strong>1</strong></td>
                    <td><a href="javascript:void(0);">Invoice 3</a></td>
                    <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                    <td>$327.00</td>
                    <td>$327.00</td>
                  </tr>
                  <tr>
                    <td colspan="4">Total</td>
                    <td><strong>$1,596.00</strong></td>
                  </tr>

                </tbody>
              </table>

            </div>

          </div>



        </div><!--/porlets-content-->
      </div><!--/block-web-->
    </div><!--/col-md-12-->
  </div><!--/row-->
</div>


@endsection
