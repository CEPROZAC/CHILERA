function mayus(e) {
  e.value = e.value.toUpperCase();
}

function soloLetras(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.";
  especiales = "8-37-39-46";

  tecla_especial = false
  for(var i in especiales){
    if(key == especiales[i]){
      tecla_especial = true;
      break;
    }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial){
    return false;
  }
}


function soloNumeros(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key);
  letras = " 1,2,3,4,5,6,7,8,9,0,.";
  especiales = "8-37-39-46";

  tecla_especial = false
  for(var i in especiales){
    if(key == especiales[i]){
      tecla_especial = true;
      break;
    }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial){
    return false;
  }
}


function curp2date() {
  var miCurp =document.getElementById('curp').value;
  var m = miCurp.match( /^\w{4}(\w{2})(\w{2})(\w{2})/
    );


  var anyo = parseInt(m[1],10)+1900;
  if( anyo < 1950 ) anyo += 100;
  var mes = parseInt(m[2], 10)-1;
  var dia = parseInt(m[3], 10);

  var fech = new Date( anyo, mes, dia );

  document.getElementById("fechaNacimiento").value = fech;

}


Date.prototype.toString = function() { 
  var anyo = this.getFullYear(); 
  var mes = this.getMonth()+1; 
  if( mes<=9 ) mes = "0"+mes; 
  var dia = this.getDate(); 
  if( dia<=9 ) dia = "0"+dia; 
  return dia+"/"+mes+"/"+anyo;  
}  


function myCreateFunction() {

  var select = document.getElementById("rol");
  var options=document.getElementsByTagName("option");
  var idRol= select.value;

  var x = select.options[select.selectedIndex].text;


  if(!validarRolesDuplicadosCrear(x)){
    document.getElementById("errorRoles").innerHTML = "";
    var fila="<tr><td style=\"display:none;\"><input name=\"idRol[]\" value=\""+idRol+"\">"
    +"</td><td colspan=\"2\">"+x+"</td>"
    +""+
    "<td>"+
    " <button type=\"button\"  onclick=\"myDeleteFunction(this)\" class=\"btn btn-danger btn-icon\"> Quitar<i class=\"fa fa-times\"></i> </button>"
    +"</td>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById("myTable").appendChild(btn);
    validarRolesCrear();
  } else {
    document.getElementById("errorRoles").innerHTML = "Rol que intentas ingresar ya pertenece a el empleado";
  }

}

function myDeleteFunction(t) {
  var td = t.parentNode;
  var tr = td.parentNode;
  var table = tr.parentNode;
  table.removeChild(tr);

}

function myDeleteFunction1(btn) {

  var route = "http://localhost:8000/eliminarRolEmpleado/"+btn.value+"";
  var token = $("#token").val();

  $.ajax({
    url: route,
    headers: {'X-CSRF-TOKEN': token},
    type: 'get',
    dataType: 'json',
    success: function(){
      $("#msj-success").fadeIn();
    }
  });

}






function Carga($id){

  var tablaDatos = $('#myTable');
  var route = "http://localhost:8000/rolesEspecificos/"+$id;

  $.get(route,function(res){
    $(res).each(function(key,value){
      tablaDatos.append("<tr><td colspan=\"2\">"+value.rol_Empleado+ "</td><td>"+""+
        "<button type=\"button\" id=\"btn\" onclick=\"myDeleteFunction1(this);myDeleteFunction(this);\" value="+ value.idERT+" class=\"btn btn-danger btn-icon\">"
        +"Quitar<i class=\"fa fa-times\"></i> </button><td></tr>");
    });
  });



}



function Carga1(){
  var tablaDatos = $('#myTable');
  var route = "http://localhost:8000/ultimo";

  $.get(route,function(res){
    $(res).each(function(key,value){
      tablaDatos.append("<tr><td colspan=\"2\">"+value.rol_Empleado+ "</td><td>"+""+
        "<button type=\"button\" id=\"btn\" onclick=\"myDeleteFunction1(this);myDeleteFunction(this);\" value="+ value.idERT+" class=\"btn btn-danger btn-icon\">"
        +"Quitar<i class=\"fa fa-times\"></i> </button><td></tr>");
      validarRoles();
    });
  });


}



function myCreateFunction1() {

 var select = document.getElementById("rol");
 var options=document.getElementsByTagName("option");
 var idRol= select.value;

 var x = select.options[select.selectedIndex].text;



 if(!validarRolesDuplicados(x)){
  document.getElementById("errorRoles").innerHTML = "";

  var dato1 = select.value;
  var dato2 = $("#idEmpleado").val();
  var route = "/empleadoRoles";
  var token = $("#token").val();

  $.ajax({
    url: route,
    headers: {'X-CSRF-TOKEN': token},
    type: 'POST',
    dataType: 'json',
    data:{idRol: dato1,idEmpleado: dato2},

    success:function(){
      $("#msj-success").fadeIn();
    }
  });
  Carga1();
}
else {

  document.getElementById("errorRoles").innerHTML = "El rol que intentas ingresar ya existe";
}

}




function validarFecha1(){
  var fecha1 =document.getElementById('fechaInicio').value;


  if (!moment(fecha1).isValid()) {
    document.getElementById("errorFechaInicio").innerHTML = "Fecha Invalida";
  } else {
    document.getElementById("errorFechaInicio").innerHTML = "";
  }

}



function validarFecha2(){

  var fecha2= document.getElementById('fechaFin').value;  

  if (!moment(fecha2).isValid()) {
    document.getElementById("errorFechaFin").innerHTML = "Fecha Invalida";
  } else {
   document.getElementById("errorFechaFin").innerHTML = "";
 }

}

function validarFechas(){



  var fecha1 =document.getElementById('fechaInicio').value;
  var fecha2= document.getElementById('fechaFin').value;
  var FechaIngreso= document.getElementById('FechaIngreso').value;

  if (moment(fecha2).isBefore(moment(fecha1))    || moment(fecha2).isSame(moment(fecha1))  ){
    document.getElementById("errorFechas").innerHTML="La fecha  de  Inicio  es mayor o igual que la fecha de Fin";
    
  } else {
    document.getElementById("errorFechas").innerHTML="";

  }


  var fechaF =   moment(fecha1).format('YYYY-DD-MM');
  var fechaF2 =   moment(fecha2).format('YYYY-DD-MM');



  //alert(fecha22.diff(fecha11, 'days'));

   var diff =moment( fechaF2).diff(moment(fechaF), "days"); // Diff in days



   document.getElementById("duracionContrato").value = diff;


 }

 function validarFechaIngreso(){

  var fecha1 =document.getElementById('fechaInicio').value;
  var fecha2= document.getElementById('fechaFin').value;
  var FechaIngreso= document.getElementById('FechaIngreso').value;

  if (moment(fecha2).isBefore(moment(fecha1))    || moment(fecha2).isSame(moment(fecha1))  ){
    document.getElementById("errorFechas").innerHTML="La fecha  de  Inicio  es mayor o igual que la fecha de Fin";
    
  } else {
    document.getElementById("errorFechas").innerHTML="";
  }

}





function doSearch()
{
  var tableReg = document.getElementById('datos');
  var searchText = document.getElementById('searchTerm').value.toLowerCase();
  var cellsOfRow="";
  var found=false;
  var compareWith="";

      // Recorremos todas las filas con contenido de la tabla
      for (var i = 1; i < tableReg.rows.length; i++)
      {
        cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
        found = false;
        // Recorremos todas las celdas
        for (var j = 0; j < cellsOfRow.length && !found; j++)
        {
          compareWith = cellsOfRow[j].innerHTML.toLowerCase();
          // Buscamos el texto en el contenido de la celda
          if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1))
          {
            found = true;
          }
        }
        if(found)
        {
          tableReg.rows[i].style.display = '';
        } else {
          // si no ha encontrado ninguna coincidencia, esconde la
          // fila de la tabla
          tableReg.rows[i].style.display = 'none';
        }
      }
    }








    




    function  validarProvedor(){

     var nombre =document.getElementById('nombre').value;
     var apellidos =document.getElementById('apellidos').value;
     var ocultoNombre =document.getElementById('ocultoNombre').value;
     var ocultoApellidos = document.getElementById('ocultoApellidos').value;
     var oculto = ocultoNombre +ocultoApellidos;



     nombre = nombre.replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');



     
     apellidos = apellidos.replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');


     var route = "http://localhost:8000/validarProvedor/"+nombre + "/" +apellidos;
     $.get(route,function(res){
      if(res.length > 0  &&  res[0].estado =="Inactivo"){
       document.getElementById('submit').disabled=true;
       var idProvedor = res[0].id;
       document.getElementById("idProvedor").value= idProvedor;
       $("#modal-reactivar").modal();

     } 
     else if (res.length > 0  &&  res[0].estado =="Activo"  && (res[0].nombre +" " +res[0].apellidos) != oculto )  {



      document.getElementById("errorNombre").innerHTML = "El proveedor intenta registrar ya existe en el sistema";
      document.getElementById('submit').disabled=true;

    }
    else {

    //  alert("entre en else");
    document.getElementById("errorNombre").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

   }



   function  validarFormularioProvedor(){

    var nombre =document.getElementById('nombre').value;

    var route = "http://localhost:8000/validarProvedor/"+nombre;

    $.get(route,function(res){
      if(res.length > 0  &&  res[0].estado =="Inactivo"){
        var idProvedor = res[0].id;
        document.getElementById("idProvedor").value= idProvedor;
        $("#modal-reactivar").modal();
        
      } 
      else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].nombre != oculto )  {


        document.getElementById("errorNombre").innerHTML = "El proveedor intenta registrar ya existe en el sistema";
        document.getElementById('submit').disabled=false;
      }
      else {
        document.getElementById("errorNombre").innerHTML = "";

        return true;
      }
    });

  }

//Validacion empresas de  proveedores 

function  validarEmpresa(){

 var rfc =document.getElementById('RFC').value;
 var oculto =document.getElementById('oculto').value;

 var route = "http://localhost:8000/validarEmpresa/"+rfc;

 $.get(route,function(res){
  if(res.length > 0  &&  res[0].estado =="Inactivo"){
   document.getElementById('submit').disabled=true;
   var idEmpresa = res[0].id;
   document.getElementById("idEmpresa").value= idEmpresa;
   $("#modal-reactivar").modal();

 } 
 else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].rfc != oculto )  {

  document.getElementById("errorRFC").innerHTML = "La empresa que  intenta registrar ya existe en el sistema";
  document.getElementById('submit').disabled=true;

}
else {
  document.getElementById("errorRFC").innerHTML = "";
  document.getElementById('submit').disabled=false;

}
});

}
   //Aqui termina validacion de  empresas de proveedor

   ///////////////////
   //Aqui comienza la  validacion de bancos
   /////
   function  validarBanco(){

     var nombre =document.getElementById('nombre').value;
     var oculto =document.getElementById('oculto').value;

     var route = "http://localhost:8000/validarBanco/"+nombre;

     $.get(route,function(res){
      if(res.length > 0  &&  res[0].estado =="Inactivo"){
       document.getElementById('submit').disabled=true;
       var idBanco = res[0].id;
       document.getElementById("idBanco").value= idBanco;
       $("#modal-reactivar").modal();

     } 
     else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].nombre != oculto )  {

      document.getElementById("errorNombre").innerHTML = "El banco que  intenta registrar ya existe en el sistema";
      document.getElementById('submit').disabled=true;

    }
    else {
      document.getElementById("errorNombre").innerHTML = "";
      document.getElementById('submit').disabled=false;

    }
  });

   }


/////////////////////////////
//Comienza la  validacion de Transportes
/////////////////
//Validacion de Placas
////////////////

function  validarPlacas(){

  var placa =document.getElementById('placas').value;
  var ocultoPlaca =document.getElementById('ocultoPlaca').value;
  var route = "http://localhost:8000/validarPlacas/"+placa;



  $.get(route,function(res){
    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idVehiculo = res[0].id;
     document.getElementById("idVehiculo").value= idVehiculo;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].placas != ocultoPlaca )  {


    document.getElementById("errorPlaca").innerHTML = "El vehiculo que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {
    console.log(res.length);
    document.getElementById("errorPlaca").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}
////////////////////////
///Validacion de Numero de  Serie
///////////////////////

function  validarNumeroSerie(){

  var serie =document.getElementById('no_serie').value;
  var ocultoSerie =document.getElementById('ocultoSerie').value;
  var route = "http://localhost:8000/validarPlacas/"+serie;



  $.get(route,function(res){

    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idVehiculo = res[0].id;
     document.getElementById("idVehiculo").value= idVehiculo;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].no_Serie != ocultoSerie )  {


    document.getElementById("errorSerie").innerHTML = "El vehiculo que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {

    document.getElementById("errorSerie").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}

////////////////////////////////////////////////////
//Validar Empresa CEPROZAC
/////////////////
function  validarEmpresaCEPROZAC(){

  var rfc =document.getElementById('rfc').value;
  var ocultoRFC =document.getElementById('ocultoRFC').value;
  var route = "http://localhost:8000/validarEmpresasCEPROZAC/"+rfc;

  console.log(ocultoRFC);

  $.get(route,function(res){

    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idEmpresa = res[0].id;
     document.getElementById("idEmpresa").value= idEmpresa;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].rfc != ocultoRFC )  {


    document.getElementById("errorRFC").innerHTML = "La empresa que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {

    document.getElementById("errorRFC").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}
/////////////////////////
//Validacion de Cuentas Bancarias de Empresas de Provedores
////////////////////////
///Validar numero de cuenta
function  validarNumeroCuentaEmProvedor(){

  var num_cuenta =document.getElementById('num_cuenta').value;

  var ocultoNumCuenta =document.getElementById('ocultoNumCuenta').value;
  var route = "http://localhost:8000/validarNumCuenta_Cve_Interbancaria/"+num_cuenta;



  $.get(route,function(res){

    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idCuenta = res[0].id;
     document.getElementById("idCuenta").value= idCuenta;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].num_cuenta != ocultoNumCuenta )  {


    document.getElementById("errorNumCuenta").innerHTML = "El numero de cuenta que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {

    document.getElementById("errorNumCuenta").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}

////////////////////////////
///Validar Clave Interbancaria

function  validarNumeroCveInterbancariaEmProvedor(){

  var cve_Interbancaria =document.getElementById('cve_Interbancaria').value;
  var ocultoCve_Interbancaria =document.getElementById('ocultoCve_Interbancaria').value;
  var route = "http://localhost:8000/validarNumCuenta_Cve_Interbancaria/"+cve_Interbancaria;



  $.get(route,function(res){
    console.log(res);

    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idCuenta = res[0].id;
     document.getElementById("idCuenta").value= idCuenta;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].cve_interbancaria != ocultoCve_Interbancaria )  {


    document.getElementById("errorCveInterbancaria").innerHTML = "La clave interbancaria que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {

    document.getElementById("errorCveInterbancaria").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}


////////////////////////////////////////////////////////
//Validacion de cuentas de CEPROZAC
////////////////////////////////////////

function  validarNumeroCuentaEmCEPROZAC(){

  var num_cuenta =document.getElementById('num_cuenta').value;
  var ocultoNumCuenta =document.getElementById('ocultoNumCuenta').value;
  var route = "http://localhost:8000/validarNumCuenta_Cve_InterbancariaCEPROZAC/"+num_cuenta;
  console.log(route);

  $.get(route,function(res){

    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idCuenta = res[0].id;
     document.getElementById("idCuenta").value= idCuenta;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].num_cuenta != ocultoNumCuenta )  {


    document.getElementById("errorNumCuenta").innerHTML = "El numero de cuenta que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {

    document.getElementById("errorNumCuenta").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}

////////////////////////////
///Validar Clave Interbancaria

function  validarNumeroCveInterbancariaEmCEPROZAC(){

  var cve_Interbancaria =document.getElementById('cve_Interbancaria').value;
  var ocultoCve_Interbancaria =document.getElementById('ocultoCve_Interbancaria').value;
  var route = "http://localhost:8000/validarNumCuenta_Cve_InterbancariaCEPROZAC/"+cve_Interbancaria;



  $.get(route,function(res){


    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idCuenta = res[0].id;
     document.getElementById("idCuenta").value= idCuenta;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].cve_interbancaria != ocultoCve_Interbancaria )  {


    document.getElementById("errorCveInterbancaria").innerHTML = "La clave interbancaria que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {

    document.getElementById("errorCveInterbancaria").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}





////////////////////////////////////////////
///Validar  Empleado Normal
////////////////////////////////////////


function  validarCURP(){

  var curp =document.getElementById('curp').value;
  var curpOculta =document.getElementById('curpOculta').value;
  var route = "http://localhost:8000/validarCURP/"+curp;

  $.get(route,function(res){


    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idEmpleado= res[0].id;


     document.getElementById("idEmpleadoModal").value= idEmpleado;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].curp != curpOculta )  {

     var tipo = res[0].tipo;
     if(tipo ==  "NORMAL"){
       document.getElementById("errorCURP").innerHTML = "El empleado que  intenta registrar ya existe en el sistema  y es un empleado de tipo  \"CONFIANZA\"";

     } else {
      document.getElementById("errorCURP").innerHTML = "El empleado que  intenta registrar ya existe en el sistema  y es un empleado de tipo  \"CONTRATADO\"";
    }
    document.getElementById('submit').disabled=true;
  }
  else {

    document.getElementById("errorCURP").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});


} 

//////////////////////////////////////////////////////////////////
//Validar  empelado por numero de seguro social
/////////////////////////////////


function  validarSSN(){

  var numero_Seguro_Social =document.getElementById('numero_Seguro_Social').value;
  var ssnOculta =document.getElementById('SSNOculto').value;
  var route = "http://localhost:8000/validarCURP/"+numero_Seguro_Social;

  $.get(route,function(res){


    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idEmpleado= res[0].id;


     document.getElementById("idEmpleadoModal").value= idEmpleado;

     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].curp != ssnOculta )  {

     var tipo = res[0].tipo;
     if(tipo ==  "NORMAL"){
       document.getElementById("errorSSN").innerHTML = "El empleado que  intenta registrar ya existe en el sistema  y es un empleado de tipo  \"CONFIANZA\"";

     } else {
      document.getElementById("errorSSN").innerHTML = "El empleado que  intenta registrar ya existe en el sistema  y es un empleado de tipo  \"CONTRATADO\"";
    }
    document.getElementById('submit').disabled=true;
  }
  else {

    document.getElementById("errorCURP").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});


} 

/////////////////////////////////////////////////

/////validar cliente///////

function  validarcliente(){

  var rfc =document.getElementById('rfc').value;
  var oculto =document.getElementById('oculto').value;
  var route = "http://localhost:8000/validarcliente/"+rfc;

  $.get(route,function(res){
    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idCliente = res[0].id;
     document.getElementById("idCliente").value= idCliente;
     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].rfc != oculto )  {

    document.getElementById("errorRFC").innerHTML = "El Cliente  que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {
    document.getElementById("errorRFC").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}


/////////////////////////////// validar provedor de materiales

function  validarprovmat(){

  var rfc =document.getElementById('rfc').value;
  var oculto =document.getElementById('oculto').value;
  var route = "http://localhost:8000/validarprovedormat/"+rfc;

  $.get(route,function(res){
    if(res.length > 0  &&  res[0].estado =="Inactivo"){
     document.getElementById('submit').disabled=true;
     var idProvedor = res[0].id;
     document.getElementById("idProvedor").value= idProvedor;
     $("#modal-reactivar").modal();

   } 
   else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].rfc != oculto )  {

    document.getElementById("errorRFC").innerHTML = "El Provedor  que  intenta registrar ya existe en el sistema";
    document.getElementById('submit').disabled=true;

  }
  else {
    document.getElementById("errorRFC").innerHTML = "";
    document.getElementById('submit').disabled=false;

  }
});

}

 

   /////////////////////////////// validar materiales/refacciones

   function  validarmateriales(){

    var codigo =document.getElementById('segundo').value;
    var oculto =document.getElementById('oculto').value;
    var route = "http://localhost:8000/validarmateriales/"+codigo;

    $.get(route,function(res){
      if(res.length > 0  &&  res[0].estado =="Inactivo"){
       document.getElementById('submit').disabled=true;
       var idMat = res[0].id;
       document.getElementById("idMat").value= idMat;
       $("#modal-reactivar").modal();

     } 
     else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].codigo != oculto )  {

      document.getElementById("errorCodigo").innerHTML = "El Codigo de Barras que  intenta registrar ya existe en el sistema";
      document.getElementById('submit').disabled=true;

    }
    else {
      document.getElementById("errorCodigo").innerHTML = "";
      document.getElementById('submit').disabled=false;

    }
  });

  }

  



      document.getElementById("div").onload = oQuickReplyswap();

      function oQuickReplyswap() {
        var id=document.getElementById("idEmpleado").value;
        Carga(id);

      }


      function validarRoles(){

        var filas = $("#myTable").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste

        if (filas.length <=1 ){
         document.getElementById('submit').disabled=true;
         document.getElementById("errorRoles").innerHTML = "No hay roles registrados a este empleado";
       } else {

         document.getElementById('submit').disabled=false;
         document.getElementById("errorRoles").innerHTML = "";
       }




     }


     function validarRolesDuplicados(rol){


       var filas = $("#myTable").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
       var resultado = false;
       for(i=1; i<filas.length; i++)
       { 
       var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
       //valor = $($(celdas[1]).children("input")[0]).val();
       rol_Agregar = $(celdas[0]).text();

       if(rol_Agregar== rol){
        resultado =true;
        break;
      }else {
        resultado =false;
      }
    }

    return resultado;
  }


  function validarRolesCrear(){

        var filas = $("#myTable").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste

        if (filas.length <=1 ){
         document.getElementById('submit').disabled=true;
         document.getElementById("errorRoles").innerHTML = "No hay roles registrados a este empleado";
       } else {

         document.getElementById('submit').disabled=false;
         document.getElementById("errorRoles").innerHTML = "";
       }

     }



     function validarRolesDuplicadosCrear(rol){

       var filas = $("#myTable").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
       var resultado = false;
       
       for(i=1; i<filas.length; i++)
       { 
         var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
          //valor = $($(celdas[1]).children("input")[0]).val();
          rol_Agregar = $(celdas[1]).text();

          if(rol_Agregar== rol){
           resultado =true;
           break;
         }else {
          resultado =false;
        }
      }

      return resultado;

    }




    function calcularCalidad(){
     var select = document.getElementById("selectCalidad");
     var options=document.getElementsByTagName("option");
     var idRol= select.value;

     var x = select.options[select.selectedIndex].text;



     document.getElementById("calidad").value = x;

   }


   function quitarEspacios(e) {
    e.value = e.value.replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');
  }




  function agregarTipoProvedor() {



    var select = document.getElementById("tipo_provedor");
    var options=document.getElementsByTagName("option");
    var idProvedor= select.value;

    var x = select.options[select.selectedIndex].text;


    if(!validarProvedorDuplicadosCrear(x)){
      document.getElementById("errorTipo").innerHTML = "";
      var fila="<tr><td style=\"display:none;\"><input name=\"idProvedor[]\" value=\""+idProvedor+"\">"
      +"</td><td colspan=\"2\">"+x+"</td>"
      +""+
      "<td>"+
      " <button type=\"button\"  onclick=\"myDeleteFunction(this)\" class=\"btn btn-danger btn-icon\"> Quitar<i class=\"fa fa-times\"></i> </button>"
      +"</td>";
      var btn = document.createElement("TR");
      btn.innerHTML=fila;
      document.getElementById("myTable").appendChild(btn);
      validarTIpoCrear();
    } else {
      document.getElementById("errorTipo").innerHTML = "El tipo de proveedor  que intentas ingresar ya pertenece al proveedor";
    }

  }


  function validarProvedorDuplicadosCrear(tipoProvedor){



       var filas = $("#myTable").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste

       var resultado = false;

       for(i=1; i<filas.length; i++)
       { 
       var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
       //valor = $($(celdas[1]).children("input")[0]).val();
       tipo_Agregar = $(celdas[1]).text();
       
       if(tipo_Agregar== tipoProvedor){
        resultado =true;
        break;
      }else {
        resultado =false;
      }
    }

    return resultado;
  }


  function validarTIpoCrear(){

        var filas = $("#myTable").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste

        if (filas.length <=1 ){
         document.getElementById('submit').disabled=true;
         document.getElementById("errorTipo").innerHTML = "No se  a registrado un tipo a Proveedor";
       } else {

         document.getElementById('submit').disabled=false;
         document.getElementById("errorTipo").innerHTML = "";
       }

     }





     function agregarTipoProvedor1() {



      var select = document.getElementById("tipo_provedor");
      var options=document.getElementsByTagName("option");
      var idProvedor= select.value;

      var x = select.options[select.selectedIndex].text;


      if(!validarProvedorDuplicadosCrear(x)){
        document.getElementById("errorTipo").innerHTML = "";
        var fila="<tr><td style=\"display:none;\"><input name=\"idProvedor[]\" value=\""+idProvedor+"\">"
        +"</td><td colspan=\"2\">"+x+"</td>"
        +""+
        "<td>"+
        " <button type=\"button\"  onclick=\"eliminarTipo(this);myDeleteFunction(this)\" class=\"btn btn-danger btn-icon\"> Quitar<i class=\"fa fa-times\"></i> </button>"
        +"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("myTable").appendChild(btn);
        validarTIpoCrear();
      } else {
        document.getElementById("errorTipo").innerHTML = "El tipo de proveedor  que intentas ingresar ya pertenece al proveedor";
      }

    }




    function eliminarTipo(btn) {

      var route = "http://localhost:8000/eliminarTipoProvedor/"+btn.value+"";
      var token = $("#token").val();

      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'get',
        dataType: 'json',
        success: function(){
          $("#msj-success").fadeIn();
        }
      });
    }







///Entradas Almacen Agroquimicos



function obtnerMedida(){
  var select = document.getElementById("idMaterial");
  var options=document.getElementsByTagName("option");
  var idMaterial= select.value;
  var route = "http://localhost:8000/propiedadesUnidadMedidaJson/"+idMaterial ;
  $.get(route,function(res){
    document.getElementById("contenedor").value=res[0].nombreUnidadMedida+" DE "+res[0].cantidadUnidadMedida+" "+
    res[0].UnidadMedida;
  });
}

function limpiarIEPS(){
 document.getElementById("ieps").value="";
}

function limpiarPrecioUnitario(){
  document.getElementById("precioUnitario").value="";
}






function obtenerUnidadMedida() {

  var select = document.getElementById("idMaterial");
  var options=document.getElementsByTagName("option");
  var idMaterial= select.value;

  var x = select.options[select.selectedIndex].text;
  var unidadesDeMedida = x.split(" ");


 if(  unidadesDeMedida.includes("MILILITROS")){  //MILILITROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='Mililitros';  
  $("#Medida").show();


}  else if( unidadesDeMedida.includes("MILIMETROS")){  //MILIMETROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='Milimetros';  
  $("#Medida").show();

}  else if( unidadesDeMedida.includes("GRAMOS")){  //GRAMOS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='Gramos';  
  $("#Medida").show();

} else if( unidadesDeMedida.includes("CENTIMETROS")) {  //CENTIMETROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='Centimetros';  
  $("#Medida").show();


} else if( unidadesDeMedida.includes("LITROS")){  //LITROS

 $("#unidadDeMedida").show();
 $("#unidadMinima").show();


 document.getElementById('unidadCentral').innerHTML='Litros';  
 document.getElementById('unidadDeMedida').innerHTML='Mililitros';  

 $("#unidadCentral").show();
 $("#Medida").show();
} else if( unidadesDeMedida.includes("METROS")){  //METROS
 $("#unidadDeMedida").show();
 $("#unidadMinima").show();
 document.getElementById('unidadCentral').innerHTML='Metros';  
 document.getElementById('unidadDeMedida').innerHTML='Centimetros';  


 $("#Medida").show();

}  else if( unidadesDeMedida.includes("KILOGRAMOS")) {  //KILOGRAMOS


 $("#unidadDeMedida").show();
 $("#unidadMinima").show();

 document.getElementById('unidadCentral').innerHTML='Kilogramos';  
 document.getElementById('unidadDeMedida').innerHTML='Gramos';  

 $("#unidadCentral").show();
 $("#Medida").show();

} else if ( unidadesDeMedida.includes("UNIDADES")) {  //UNIDADES

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='Unidades';  
  $("#Medida").show();

} 

}


function  validarFactura(){
  var numeroFactura =document.getElementById('numeroFactura').value;
  var oculto =document.getElementById('numeroFacturaOculto').value;
  var route = "http://localhost:8000/validarNumeroFactura/"+numeroFactura;
  $.get(route,function(res){
    if(res.length > 0  &&  res[0].estado =="Inactivo"){
      var idProvedor = res[0].idFactura;
      document.getElementById("factura").value= idFactura;
      $("#modal-reactivar").modal();

    } 
    else if (res.length > 0  &&  res[0].estado =="Activo"  && res[0].nombre != oculto )  {
      document.getElementById("errorNumeroFactura").innerHTML = "La Factura que intenta registrar ya existe en el sistema";
      document.getElementById('submit').disabled=true;
    }
    else {
      document.getElementById("errorNumeroFactura").innerHTML = "";
      document.getElementById('submit').disabled=false;
    }
  });

}


function validarProductosDuplicados(producto){


       var filas = $("#detalles").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
       var resultado = false;
       for(i=1; i<filas.length; i++)
       { 
       var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
       //valor = $($(celdas[1]).children("input")[0]).val();
       producto_Agregar = $(celdas[1]).text();

       if(producto_Agregar== producto){
         swal("Alerta!", "Elemento ya agregado a la lista!", "error");
         resultado =true;
         break;
       }else {

        resultado =false;
        
      }
    }
    return resultado;
  }

  function limpiarErrorIEPS(){
   var ieps= document.getElementById("ieps").value;
   if(ieps!=""){
     document.getElementById("errorIEPS").innerHTML= "";
   }
 }

 function limpiarErrorPrecioUnitario(){
   var precioUnitario=document.getElementById("precioUnitario").value;
   if(precioUnitario != ""){
    document.getElementById("errorprecio").innerHTML= "";
  }

}
function limpiarErrorProducto(){
 var precioUnitario=document.getElementById("idMaterial").value;
 if(precioUnitario != ""){
  document.getElementById("errorProducto").innerHTML= "";
}

}

function validar(){
 var select = document.getElementById("idMaterial");
 var options=document.getElementsByTagName("option");
 var idMaterial= select.value;
 var x = select.options[select.selectedIndex].text;
 var iva = document.getElementById("iva").value;
 var ieps = document.getElementById("ieps").value;
 var precioUnitario = document.getElementById("precioUnitario").value;

 if(x=="SELECIONA UN PRODUCTO" || ieps=="" || precioUnitario ==""){
  swal("Alerta!", "Por favor completa todos los campos, Para Poder Guardar!", "error");("campos vacios");

  if(x=="SELECIONA UN PRODUCTO"){
    document.getElementById("errorProducto").innerHTML= "Elige un producto para agregar a la lista.";
  }
  if(ieps==""){
    document.getElementById("errorIEPS").innerHTML= "El IEPS debe ser mayor igual a cero.";
    
  }
  if(precioUnitario =="")
  {
    document.getElementById("errorprecio").innerHTML= "El precio Unitario debe ser mayor igual a cero.";
  } 

  return 1;
} else {

  return 0;
}


}





function obtenerStockActual(){

  var select = document.getElementById("idMaterial");
  var options=document.getElementsByTagName("option");
  var idMaterial= select.value;
  var route = "http://localhost:8000/obtenerStockAgroquimicos/"+idMaterial;
  $.get(route,function(res){


  });

}



function validarUnidadesMedida(){
  var select = document.getElementById("idUnidadMedida");
  var options=document.getElementsByTagName("option");
  var idMaterial= select.value;
  var x = select.options[select.selectedIndex].text;

  var nombreContenedor = document.getElementById("contenedor").value;
  var cantidad = document.getElementById("cantidad").value;
  var unidadMedidaGuardar=nombreContenedor+" "+cantidad+" "+x;
  var route = "http://localhost:8000/listarUnidadesMedidaJson";
  var oculto =document.getElementById("oculto").value;

  if(unidadMedidaGuardar != oculto){

    $.get(route,function(res){
      $(res).each(function(key,value){
        unidadesMedida= value.nombre+ " "+value.cantidad+ " "+value.nombreUnidadMedida;

        if(unidadesMedida == unidadMedidaGuardar ){
          document.getElementById('submit').disabled=true;
          document.getElementById("alerta").innerHTML = "<div class=\"alert alert-danger\" id=\'result\'>La unidad de medida que intentas registrar ya existe en el sistema</div>";
          return false;
        } else {

          document.getElementById("alerta").innerHTML = "";
          document.getElementById('submit').disabled=false;
        }
      });
    });
  } 
}




function obtenerSelect() {


  var select = document.getElementById("medida");
  var options=document.getElementsByTagName("option");
  var idProvedor= select.value;

  var x = select.options[select.selectedIndex].text;
  
  var unidadesDeMedida = x.split(" ");
  
  document.getElementById("contenedor").value= x;

 if(  unidadesDeMedida.includes("MILILITROS")){  //MILILITROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='MILILITROS';  
  $("#Medida").show();


} else if( unidadesDeMedida.includes("MILIMETROS")){  //MILIMETROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='MILIMETROS';  
  $("#Medida").show();

} else if( unidadesDeMedida.includes("GRAMOS")){  //GRAMOS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='GRAMOS';  
  $("#Medida").show();

} else if( unidadesDeMedida.includes("CENTIMETROS")) {  //CENTIMETROS

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='CENTIMETROS';  
  $("#Medida").show();


} else if( unidadesDeMedida.includes("LITROS")){  //LITROS

 $("#unidadDeMedida").show();
 $("#unidadMinima").show();


 document.getElementById('unidadCentral').innerHTML='Litros';  
 document.getElementById('unidadDeMedida').innerHTML='Mililitros';  

 $("#unidadCentral").show();
 $("#Medida").show();
} else if( unidadesDeMedida.includes("METROS")){  //METROS
 $("#unidadDeMedida").show();
 $("#unidadMinima").show();
 document.getElementById('unidadCentral').innerHTML='Metros';  
 document.getElementById('unidadDeMedida').innerHTML='Centimetros';  


 $("#Medida").show();

}  else if( unidadesDeMedida.includes("KILOGRAMOS")) {  //KILOGRAMOS

 $("#unidadDeMedida").show();
 $("#unidadMinima").show();

 document.getElementById('unidadCentral').innerHTML='Kilogramos';  
 document.getElementById('unidadDeMedida').innerHTML='GRAMOS';  

 $("#unidadCentral").show();
 $("#Medida").show();

} else if ( unidadesDeMedida.includes("UNIDADES")) {  //UNIDADES

  $("#unidadDeMedida").hide();
  $("#unidadMinima").hide();
  document.getElementById('unidadCentral').innerHTML='UNIDADES';  
  $("#Medida").show();

} 

}

function habilitar(value)
{
  if(value=="1")
  {
// habilitamos
document.getElementById("segundo").disabled=false;
document.getElementById("segundo").value = "";
document.getElementById("segundo").focus(); 
}else if(value=="2"){
// deshabilitamos
document.getElementById("segundo").disabled=false;
document.getElementById("segundo").readonly="readonly";
document.getElementById("segundo").readonly=true;
var aleatorio = Math.floor(Math.random()*999999999999);
document.getElementById("segundo").value=aleatorio;
}else if (value=="3"){
  document.getElementById("segundo").disabled=true;
  document.getElementById("segundo").value = "";
}
}




  function calcularCantidad(){

    var select = document.getElementById("idMaterial");
    var options=document.getElementsByTagName("option");
    var idMaterial= select.value;


    var idUnidadMedida;

    var unidadesCompletas =parseInt(document.getElementById('unidadesCompletas').value);
    var unidadCentral = parseInt(document.getElementById('Medida').value);
    var unidadesMedida = parseInt(document.getElementById('unidadMinima').value);
    var nombreUnidadMedida;

    var capacidad=0;
    var totalUnidadesCompletas;

    var total= 0;

    var route = "http://localhost:8000/obtenerPropiedadesAgroquimicos/"+idMaterial;
    $.get(route,function(res){

     idUnidadMedida= res.idUnidadMedida;



     var routePropiedadesUnidadMedida = "http://localhost:8000/propiedadesUnidadMedidaCantidadJson/"+idUnidadMedida;
     $.get(routePropiedadesUnidadMedida,function(resPropiedadesUnindadMedida){

      nombreUnidadMedida = resPropiedadesUnindadMedida.nombreUnidadMedida;
      capacidad = resPropiedadesUnindadMedida.cantidad; 

      totalUnidadesCompletas = unidadesCompletas * capacidad; 

      total = calcularEquivalencia(nombreUnidadMedida,totalUnidadesCompletas,unidadCentral,unidadesMedida); 


      document.getElementById("cantidadTotal").value=total;

      document.getElementById("capacidadUnidadMedida").value=resPropiedadesUnindadMedida.cantidad;


    });

   });


  }


  function calcularEquivalencia(unidadDeMedida,unidadesCompletas,unidadCentral,unidadesMedida){


    if(unidadDeMedida == "LITROS"){
      total=unidadesCompletas*1000+ unidadCentral * 1000 +unidadesMedida  ;
      return total;
    }

    else if (unidadDeMedida =="KILOGRAMOS") {

      total=unidadesCompletas*1000+ unidadCentral * 1000 +unidadesMedida  ;
      return total;
    }

    else if (unidadDeMedida=="METROS") {
      total=unidadesCompletas*100+ unidadCentral * 100 +unidadesMedida  ;
      return total;
    }
    else if(unidadDeMedida=="UNIDADES"){
      total = unidadesCompletas + unidadCentral;
      return total;
    } else if(unidadDeMedida=="GRAMOS"){
      total = unidadesCompletas + unidadCentral;
      return total;
    } else if(unidadDeMedida=="MILILITROS"){
      total = unidadesCompletas + unidadCentral;
      return total;
    }  else if(unidadDeMedida=="MILIMETROS"){
      total = unidadesCompletas + unidadCentral;
      return total;
    }

    else if(unidadDeMedida=="CENTIMETROS"){
      total = unidadesCompletas + unidadCentral;
      return total;
    } 

  }




  function teclas(event) {
   caracter =(document.all) ? event.keyCode : event.which;
   
   if (caracter == 13  ) {
    var codigoBarras = document.getElementById('codigo').value;
    var route = "http://localhost:8000/propiedadesArticulo_x_Codigo_Barras/"+codigoBarras ;
    $.get(route,function(res){

      if(res.length>0){
       document.getElementById("idMaterial").selectedIndex=  res[0].idAgroquimico;
       document.getElementById("contenedor").value= res[0].nombreUnidadMedida + " DE " + res[0].cantidadUnidadMedida + " "+
       res[0].unidad_medida;
       obtenerUnidadMedida();
       calcularCantidad();
     } else {
       swal("Producto No Encontrado!", "Verifique el Codigo de Barras!", "error");
     }

   }); 
    return false;
  }
}



function listadoDeCantidades(){
  var labelUnidadCentral=document.getElementById("unidadCentral").innerHTML;
  var labelUnidadDeMedida= document.getElementById("unidadDeMedida").innerHTML;
  var cantidadUnidadCentral = document.getElementById("Medida").value;
  var cantidadUnidadMedida = document.getElementById("unidadMinima").value;
  var unidadesCompletas = document.getElementById("unidadesCompletas").value;
  var medida= document.getElementById("contenedor").value;


  if(labelUnidadCentral == "Kilogramos"  || labelUnidadCentral == "Litros" || labelUnidadCentral == "Metros"){
    var  listadoDeCantidades = "<li>"+unidadesCompletas +" "+medida+"</li>";
    listadoDeCantidades+="<li>"+cantidadUnidadCentral+" "+labelUnidadCentral.toUpperCase();+"</li>";
    listadoDeCantidades += "<li>"+cantidadUnidadMedida+" "+labelUnidadDeMedida.toUpperCase();+"</li>";
    return listadoDeCantidades;

  } else {
    var  listadoDeCantidades = "<li>"+unidadesCompletas +" "+medida+"</li>";
    listadoDeCantidades+="<li>"+cantidadUnidadCentral+" "+labelUnidadCentral.toUpperCase();+"</li>";
    return listadoDeCantidades; 
  }
}





function calcularPrecioMinimo(precioUnitario,cantidadContendedor,unidadDeMedida){

  if(unidadDeMedida == "Litros"){
    precio=precioUnitario/(cantidadContendedor*1000);
    return precio;
  }
  else if (unidadDeMedida =="Kilogramos") {
    precio=precioUnitario/(cantidadContendedor*1000);
    return precio;
  }
  else if (unidadDeMedida=="Metros") {
    precio=precioUnitario/(cantidadContendedor*100);
    return precio;
  }
  else if(unidadDeMedida=="Unidades"){
    precio=precioUnitario/(cantidadContendedor);
    return precio;
  } else if(unidadDeMedida=="Gramos"){
    precio=precioUnitario/cantidadContendedor;
    return precio;
  } else if(unidadDeMedida=="Mililitros"){
    precio=precioUnitario/cantidadContendedor;
    return precio;
  } else if(unidadDeMedida=="Milimetros"){
    precio=precioUnitario/cantidadContendedor;
    return precio;
  }  else if(unidadDeMedida=="Centimetros"){
    precio=precioUnitario/cantidadContendedor;
    return precio;
  } 



}


function limpiar(){
  document.getElementById("iva").value="0";
  document.getElementById("ieps").value="0";
  document.getElementById("precioUnitario").value="0.00";

  document.getElementById("unidadesCompletas").value="0";
  document.getElementById("Medida").value="0";
  document.getElementById("unidadMinima").value="0";
  document.getElementById("idMaterial").selectedIndex="0";
}


function limpiarUnidadesCompletas(){
  document.getElementById("unidadesCompletas").value="";
}

function limpiarUnidadMedida(){
  document.getElementById("Medida").value="";
}

function limpiarUnidadMinima(){
  document.getElementById("unidadMinima").value="";
}

///FIn entradas almacen Agroquimicos



////Inventario Agroquimicos


function validarAgroquimicoUnico(){
  var select = document.getElementById("medida");
  var options=document.getElementsByTagName("option");
  var idRol= select.value;
  var x = select.options[select.selectedIndex].text;
  var nombreAgroquimico = document.getElementById("nombreAgroquimico").value;
  var nombreAgroquimico_UnidadMedida= nombreAgroquimico + " " +x;
  var route = "http://localhost:8000/validarAgroquimicoUnico";
  var oculto =document.getElementById("oculto").value;
  if(nombreAgroquimico != oculto){
    $.get(route,function(res){
      $(res).each(function(key,value){
        agroquimico= value.nombre+ " "+value.nombreUnidadMedida+" "+value.cantidadUnidadMedida+ " "+ value.unidad_medida;
        if(nombreAgroquimico_UnidadMedida == agroquimico ){
          document.getElementById('submit').disabled=true;
          document.getElementById("alerta").innerHTML = "<div class=\"alert alert-danger\" id=\'result\'><strong>El agroquímico" +
          " que intentas registrar ya existe en el sistema.</strong></div>";
          return false;
        } else {
          document.getElementById("alerta").innerHTML = "";
          document.getElementById('submit').disabled=false;
        }
      });
    });
  } 
}

/////////////////////////////
////// Inventarios Almacenes Limpieza
//////////////////////

//////////////////////
/////Inventarios  Amacen  Empaque
/////////////////////////////

  function validarMaterialEmpaqueUnico(){
    var select = document.getElementById("medida");
    var options=document.getElementsByTagName("option");
    var idRol= select.value;
    var x = select.options[select.selectedIndex].text;
    var select = document.getElementById("formaEmpaque");
    var options=document.getElementsByTagName("option");
    var  idEmpaque = select.value;
    var nombreMaterialEmpaque = select.options[select.selectedIndex].text;
    var nombreMaterialEmpaque_UnidadMedida =  nombreMaterialEmpaque +" " +x;
    var route = "http://localhost:8000/validarMaterialEmpaqueUnico";
    var oculto =document.getElementById("oculto").value;
    if(nombreMaterialEmpaque != oculto){
      $.get(route,function(res){
        $(res).each(function(key,value){
          nombreMaterialEmpaqueBD = value.formaEmpaque+ " "+value.nombreUnidadMedida+" "
          +value.cantidadUnidadMedida+ " "+ value.unidad_medida;
          if(nombreMaterialEmpaque_UnidadMedida == nombreMaterialEmpaqueBD){
            document.getElementById('submit').disabled=true;
            document.getElementById("alerta").innerHTML =
            "<div class=\"alert alert-danger\" id=\'result\'><strong>El material de empaque "
            + "que intentas registrar ya "+ 
            "existe en el sistema.</strong></div>";
            return false;
          } else {
            document.getElementById("alerta").innerHTML = "";
            document.getElementById('submit').disabled=false;
          }
        });
      });
    } 
  }

//////////////////////////////////