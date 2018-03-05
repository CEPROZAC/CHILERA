@extends('layouts.principal')
@section('contenido')

    <h1>Inicio</h1>


    <div class="text-success" id='result'>
    @if(Session::has('message'))
        {{Session::get('message')}}
    @endif
</div>
 
<form method="post" action="{{url('clientes/validarmiformulario')}}" id='form'>


           
             <div class="form-group">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" class="form-control" value="{{Input::old('nombre')}}" />
        <div class="text-danger" id='error_nombre'>{{$errors->formulario->first('nombre')}}</div>
    </div>



  <div class="form-group">
        <label for="email">Email: </label>
        <input type="text" name="email" class="form-control" value="{{Input::old('email')}}" />
        <div class="text-danger" id='error_email'>{{$errors->formulario->first('email')}}</div>
    </div>


           <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
             {{csrf_field()}}
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{url('/clientes')}}" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
        </form>

    <script>
 $(function(){
     $("#form").submit(function(e){
         
         var fields = $(this).serialize();
         $.post("{{url('clientes/validarmiformulario')}}", fields, function(data){
             
             if(data.valid !== undefined){
                 $("#result").html("Enhorabuena formulario enviado correctamente");
                 $("#form")[0].reset();
                 $("#error_nombre").html('');
                 $("#error_email").html('');
             }
             else{
                 $("#error_nombre").html('');
                 $("#error_email").html('');
                 if (data.nombre !== undefined){
                    $("#error_nombre").html(data.nombre); 
                 }
                 if (data.email !== undefined){
                     $("#error_email").html(data.email);
                 }
             }
             
         });
         
         return false;
     });
 });
</script>

@stop
