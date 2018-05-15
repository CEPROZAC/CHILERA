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



  var fila="<tr><td style=\"display:none;\"><input name=\"idRol[]\" value=\""+idRol+"\"></td><td colspan=\"2\">"+x+"</td>"+""+"<td>"+
  " <button type=\"button\"  onclick=\"myDeleteFunction(this)\" class=\"btn btn-danger btn-icon\"> Quitar<i class=\"fa fa-times\"></i> </button>"
  +"</td>";
  var btn = document.createElement("TR");
  btn.innerHTML=fila;
  document.getElementById("myTable").appendChild(btn);


}

function myDeleteFunction(t) {
  var td = t.parentNode;
  var tr = td.parentNode;
  var table = tr.parentNode;
  table.removeChild(tr);

}

function myDeleteFunction1(btn) {


  var route = "http://localhost:8000/empleadoRoles/"+btn.value+"";
  var token = $("#token").val();

  $.ajax({
    url: route,
    headers: {'X-CSRF-TOKEN': token},
    type: 'DELETE',
    dataType: 'json',
    success: function(){
      $("#msj-success").fadeIn();
    }
  });



}


document.getElementById("div").onload = oQuickReplyswap();
function oQuickReplyswap() {

  var id=document.getElementById("idEmpleado").value;
  Carga(id);
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
    });
  });
}



function myCreateFunction1() {

 var select = document.getElementById("rol");
 var options=document.getElementsByTagName("option");
 var idRol= select.value;

 var x = select.options[select.selectedIndex].text;



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




function calcularTiempo(){
  var fecha1 =document.getElementById('fechaInicio').value;
  var fecha2= document.getElementById('fechaFin').value;
  var ano1 = fecha1.substring(0, 2);
  var mes1 = fecha1.substring(3, 5);
  var dia1 = fecha1.substring(6, 10);
  fech1 =ano1+"-"+mes1+"-"+dia1;
  var ano2 = fecha2.substring(0, 2);
  var mes2 = fecha2.substring(3, 5);
  var dia2 = fecha2.substring(6, 10);


  fech2 =ano2+"-"+mes2+"-"+dia2;
  fecha1m=moment(fech1);
  fecha2m=moment(fech2);

      var diff = fecha2m.diff(fecha1m, 'd'); // Diff in days
      document.getElementById("duracionContrato").value = diff;
      tiempo=  document.getElementById("duracionContrato").value;
      

      if(tiempo=="NaN"  || diff <0) {
        alert ("Por favor  verifica que la fecha de Inicio y Fecha fin sean Correctas");
      } else  {
        document.getElementById("duracionContrato").value = diff;
      }

    }