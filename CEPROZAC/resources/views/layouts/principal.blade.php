<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>CEPROZAC</title>

  
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="icon" type="image/png" href="images/LOGOCEPROZAC.png" />
    {!!Html::style('css/font-awesome.css')!!}
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/animate.css')!!}
    {!!Html::style('css/admin.css')!!}
    {!!Html::style('css/MisEstilos.css')!!}
    {!!Html::style('plugins/advanced-datatable/css/demo_table.css')!!}
    {!!Html::style('plugins/advanced-datatable/css/demo_page.css')!!}
    {!!Html::style('plugins/toggle-switch/toggles.css')!!}
    <!--link href="css/select2.css" rel="stylesheet"-->
    {!!Html::style('plugins/bootstrap-editable/bootstrap-editable.css')!!}
    {!!Html::style('plugins/dropzone/dropzone.css')!!}
    {!!Html::style('plugins/data-tables/DT_bootstrap.css')!!}
    {!!Html::style('plugins/data-tables/DT_bootstrap.css')!!}
    {!!Html::style('plugins/advanced-datatable/css/demo_table.css')!!}
    {!!Html::style('plugins/advanced-datatable/css/demo_page.css')!!}
    {!!Html::style('plugins/bootstrap-fileupload/bootstrap-fileupload.min.css')!!}
    {!!Html::style('plugins/file-uploader/css/jquery.fileupload.css')!!}
    {!!Html::style('plugins/file-uploader/css/jquery.fileupload-ui.css')!!}
    {!!Html::style('plugins/bootstrap-datepicker/css/datepicker.css')!!}
    {!!Html::style('plugins/bootstrap-timepicker/compiled/timepicker.css')!!}
    {!!Html::style('plugins/bootstrap-colorpicker/css/colorpicker.css')!!}
    {!!Html::style('plugins/select2/dist/css/select2.css')!!}

    <!--Estilos Para radio buton y switch -->
    {!!Html::style('plugins/toggle-switch/toggles.css')!!}
    {!!Html::style('plugins/checkbox/icheck.css')!!}
    {!!Html::style('plugins/checkbox/minimal/blue.css')!!}
    {!!Html::style('plugins/checkbox/minimal/green.css')!!}
    {!!Html::style('plugins/checkbox/minimal/grey.css')!!}
    {!!Html::style('plugins/checkbox/minimal/orange.css')!!}
    {!!Html::style('plugins/checkbox/minimal/pink.css')!!}
    {!!Html::style('plugins/checkbox/minimal/purple.css')!!}
    {!!Html::style('plugins/bootstrap-fileupload/bootstrap-fileupload.min.css')!!}

    <!--Wizard  -->
    {!!Html::style('plugins/wizard/css/smart_wizard.css')!!}
    <!-- Optional SmartWizard theme -->
    {!!Html::style('plugins/wizard/css/smart_wizard_theme_dots.css')!!}
    <!-- Optional SmartWizard theme -->
    {!!Html::style('plugins/wizard/css/smart_wizard_theme_circles.css')!!}
    {!!Html::style('plugins/wizard/css/smart_wizard_theme_arrows.css')!!}
    {!!Html::style('plugins/wizard/css/smart_wizard_theme_dots.css')!!}

  </head>
  <style type="text/css">
    .disabled {
      pointer-events:none; /*This makes it not clickable*/
      opacity:0.6;         /*This grays it out to look disabled*/
    }
    .lblheader{
      color:#2196F3;
    }

    a {
      color: #FFF;
      text-decoration: none;
    }
  </style>
  <body class="blue_thm  fixed_header left_nav_fixed">
    <div class="wrapper">
      <!--\\\\\\\ wrapper Start \\\\\\-->
      <div class="header_bar">
        <!--\\\\\\\ header Start \\\\\\-->
        <div class="brand">
          <!--\\\\\\\ brand Start \\\\\\-->
          <div class="logo" style="display:block"><span class="light_theme">CEPROZAC</span> </div>
          <div class="small_logo" style="display:none"><img src="images/s-logo.png" width="50" height="47" alt="s-logo" /> <img src="images/r-logo.png" width="122" height="20" alt="r-logo" /></div>
        </div>
        <!--\\\\\\\ brand end \\\\\\-->
        <div class="header_top_bar">
          <!--\\\\\\\ header top bar start \\\\\\-->
          <a href="javascript:void(0);" class="menutoggle"> <i class="fa fa-bars"></i> </a>
          <div class="top_left">

          </div>

          <div class="top_right_bar">

            <div class="user_admin dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"><img src="images/user.png" /><span class="user_adminname">John Doe</span> <b class="caret"></b> </a>
              <ul class="dropdown-menu">
                <div class="top_pointer"></div>
                <li> <a href="profile.html"><i class="fa fa-user"></i> Profile</a> </li>
                <li> <a href="help.html"><i class="fa fa-question-circle"></i> Help</a> </li>
                <li> <a href="settings.html"><i class="fa fa-cog"></i> Setting </a></li>
                <li> <a href="{{url('/')}}""><i class="fa fa-power-off"></i> Logout</a> </li>
              </ul>
            </div>



          </div>
        </div>
        <!--\\\\\\\ header top bar end \\\\\\-->
      </div>
      <!--\\\\\\\ header end \\\\\\-->
      <div class="inner">
        <!--\\\\\\\ inner start \\\\\\--><div class="left_nav">

        <!--\\\\\\\left_nav start \\\\\\-->

        <div class="left_nav_slidebar">
          <ul >
            <li class="left_nav_active theme_border"><a href="javascript:void(0);"><i class="fa fa-home"></i> Provedores<span class="left_nav_pointer"></span> <span class="plus"><i class="fa fa-plus"></i></span> </a>


              <ul  >
                <li> <a href="{{url('provedores')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b >Proveedores</b> </a> </li>
                <li> <a href="{{url('empresas')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b >Empresas</b> </a> </li>
                <li> <a href="{{url('bancos')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b >Bancos</b> </a> </li>
                <li> <a href="{{url('materiales/provedores')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b >Materiales</b> </a> </li>


              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-edit"></i> Clientes <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
                <li> <a href="{{url('clientes')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Clientes</b> </a> </li>

              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-tasks"></i> Productos <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
                <li> <a href="{{url('productos')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Productos</b> </a> </li>
                <li> <a href="{{url('calidad')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Calidad</b> </a> </li>
                <li> <a href="{{url('empaques')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Empaques</b> </a> </li>
              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-users"></i> Recursos Humanos <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
                <li> <a href="{{url('empleados')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Empleados</b> </a> </li>
                <li> <a href="{{url('rol')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Roles Empleados</b> </a> </li>
                <li> <a href="{{url('contratos')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Contratos</b> </a> </li>
              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-truck icon"></i> Transporte <span class="plus"><i class="fa fa-plus"></i></span> </a>
              <ul>
                <li> <a href="{{url('transportes')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Vehículos</b> </a> </li>
                <li> <a href="{{url('mantenimiento')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Mantenimientos</b> </a> </li>
                

              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-shopping-cart"></i> Empresas <span class="plus"><i class="fa fa-plus"></i></span> </a>
              <ul>
                <li> <a href="{{url('empresasCEPROZAC')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Empresas</b> </a> </li>
              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-tasks"></i> Almacénes <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
                <li> <a href="{{url('almacenes/agroquimicos')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Agroquímicos</b> </a> </li>
                 <li> <a href="{{url('almacenes/limpieza')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Limpieza</b> </a> </li>
                <li> <a href="{{url('almacen/materiales')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Materiales</b> </a> </li>
                

                
               
                  <li> <a href="{{url('almacenes/empaque')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Empaque</b> </a> </li>
                <li> <a href="{{url('almacen/general')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Generales</b> </a> </li>

                <li> <a href="{{url('almacenes')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Almacenes</b> </a> </li>


              </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-tasks"></i> Basculas <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
                <li> <a href="{{url('basculas')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Basculas</b> </a> </li>
                <li> <a href="{{url('precioBasculas')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Precio Pesaje</b> </a> </li>
                <li> <a href="{{url('serviciosBascula')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Servicio de Bascula</b> </a> </li>

              </ul>
            </li>


            <li> <a href="javascript:void(0);"> <i class="fa fa-tasks"></i> Bitacoras <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
                <li> <a href="{{url('basculas')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Basculas</b> </a> </li>

              </ul>
            </li>

            <li> <a href="javascript:void(0);"> <i class="fa fa-shopping-cart"></i> Compras <span class="plus"><i class="fa fa-plus"></i></span> </a>
              <ul>
                <li> <a href="{{url('compras/recepcion/')}}"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Materia Prima</b> </a> </li>
              </ul>
            </li>


          </ul>
        </div>
      </div>
      <!--\\\\\\\left_nav end \\\\\\-->
      <div class="contentpanel">

        @yield('contenido')

        <div class="row col-md-6 col-md-offset-3"  style="height: 1000px;" >

        </div>

        <!--\\\\\\\ container  end \\\\\\-->
      </div>



      <!--\\\\\\\ content panel end \\\\\\-->
    </div>
    <!--\\\\\\\ inner end\\\\\\-->
  </div>

  {!!Html::script('js/jquery-2.1.0.js')!!}
  {!!Html::script('js/script.js')!!}
  {!!Html::script('js/moment.min.js')!!}
  {!!Html::script('js/jquery-2.1.0.js')!!}
  {!!Html::script('js/bootstrap.min.js')!!}
  {!!Html::script('js/common-script.js')!!}
  {!!Html::script('js/jquery.slimscroll.min.js')!!}
  {!!Html::script('plugins/toggle-switch/toggles.min.js')!!} 
  {!!Html::script('plugins/checkbox/zepto.js')!!}
  {!!Html::script('plugins/checkbox/icheck.js')!!}
  {!!Html::script('js/icheck-init.js')!!}
  {!!Html::script('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')!!} 
  {!!Html::script('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')!!} 
  {!!Html::script('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')!!} 
  {!!Html::script('plugins/bootstrap-timepicker/js/bootstrap-timepicker.js')!!} 
  {!!Html::script('js/form-components.js')!!} 
  {!!Html::script('plugins/input-mask/jquery.inputmask.min.js')!!} 
  {!!Html::script('plugins/input-mask/demo-mask.js')!!} 
  {!!Html::script('plugins/bootstrap-fileupload/bootstrap-fileupload.min.js')!!} 
  {!!Html::script('plugins/dropzone/dropzone.min.js')!!} 
  {!!Html::script('plugins/ckeditor/ckeditor.js')!!}
  {!!Html::script('js/jPushMenu.js')!!} 
  {!!Html::script('plugins/validation/parsley.min.js')!!}
  {!!Html::script('plugins/data-tables/jquery.dataTables.js')!!}
  {!!Html::script('plugins/data-tables/DT_bootstrap.js')!!}
  {!!Html::script('plugins/data-tables/dynamic_table_init.js')!!}
  {!!Html::script('plugins/edit-table/edit-table.js')!!}
  {!!Html::script('plugins/file-uploader/js/vendor/jquery.ui.widget.js')!!}
  {!!Html::script('plugins/file-uploader/js/jquery.iframe-transport.js')!!}
  {!!Html::script('plugins/file-uploader/js/jquery.fileupload.js')!!}
  {!!Html::script('plugins/validation/parsley.min.js')!!}
  {!!Html::script('plugins/select2/dist/js/select2.full.min.js')!!}
  <!-- Include SmartWizard JavaScript source -->
  {!!Html::script('plugins/wizard/js/jquery.smartWizard.js')!!}
  <!-- Include jQuery Validator plugin -->
  {!!Html::script('https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js')!!}


  {!!Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js')!!}
  <script type="text/javascript">
   $(document).on('ready', function()  {

          //Initialize Select2 Elements
          $('.select2').select2()

        })
      </script>

    </body>

    </html>