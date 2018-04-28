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


function myCreateFunction1() {

  var select = document.getElementById("rol");
  var options=document.getElementsByTagName("option");
  var idRol= select.value;
  var nombreRol= options[select.value-1].innerHTML;


  var fila="<tr><td style=\"display:none;\"><input id=\"idRol\"  name=\"idRol\" value=\""+idRol+"\"></td><td colspan=\"2\">"+nombreRol+"</td>"+""+"<td>"+
  " <button type=\"button\" id=\"btn\"  value=\"{{$rol->id}}\"  onclick=\"myDeleteFunction1(this)\" class=\"btn btn-danger btn-icon\"> Quitar<i class=\"fa fa-times\"></i> </button>"
  +"</td>";
  var btn = document.createElement("TR");
  btn.innerHTML=fila;
  document.getElementById("myTable").appendChild(btn);

  var dato1 = $("#idRol").val();
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
}


$(document).ready(function(){
        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('Finish')
        .addClass('btn btn-info')
        .on('click', function(){
          if( !$(this).hasClass('disabled')){
            var elmForm = $("#myForm");
            if(elmForm){
              elmForm.validator('validate');
              var elmErr = elmForm.find('.has-error');
              if(elmErr && elmErr.length > 0){
                alert('Oops we still have error in the form');
                return false;
              }else{
                alert('Great! we are ready to submit form');
                elmForm.submit();
                return false;
              }
            }
          }
        });
        var btnCancel = $('<button style="margin-left:-200px;"></button>').text('Cancel')
        .addClass('btn btn-danger')
        .on('click', function(){
          $('#smartwizard').smartWizard("reset");
          $('#myForm').find("input, textarea").val("");
        });


        // Smart Wizard
        $('#smartwizard').smartWizard({
          selected: 0,
          theme: 'arrows',
          transitionEffect:'fade',
          toolbarSettings: {toolbarPosition: 'bottom'},
          anchorSettings: {
            markDoneStep: true, // add done css
            markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
            removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
          }
        });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
          var elmForm = $("#form-step-" + stepNumber);
          // stepDirection === 'forward' :- this condition allows to do the form validation
          // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
          if(stepDirection === 'forward' && elmForm){
            elmForm.validator('validate');
            var elmErr = elmForm.children('.has-error');
            if(elmErr && elmErr.length > 0){
              // Form validation failed
              return false;
            }
          }
          return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
          // Enable finish button only on last step
          if(stepNumber == 3){
            $('.btn-finish').removeClass('disabled');
          }else{
            $('.btn-finish').addClass('disabled');
          }
        });

      });


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