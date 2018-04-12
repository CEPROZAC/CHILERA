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
  var nombreRol= options[select.value-1].innerHTML;


  var fila="<tr><td style=\"display:none;\"><input name=\"idRol[]\" value=\""+idRol+"\"></td><td colspan=\"2\">"+nombreRol+"</td>"+""+"<td>"+
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
