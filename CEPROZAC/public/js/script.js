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
  letras = " 1,2,3,4,5,6,7,8,9,0";
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


// Devuelve un booleano si es un NSS válido
// (deben ser 11 dígitos sin otro caracter en el medio)
function nssValido(nss) {
  const re       = /^(\d{2})(\d{2})(\d{2})\d{5}$/,
  validado = nss.match(re);

    if (!validado)  // 11 dígitos y subdelegación válida?
      return false;

    const subDeleg = parseInt(validado[1],10),
    anno     = new Date().getFullYear() % 100;
    var   annoAlta = parseInt(validado[2],10),
    annoNac  = parseInt(validado[3],10);
    
    //Comparar años (excepto que no tenga año de nacimiento)
    if (subDeleg != 97) {
      if (annoAlta <= anno) annoAlta += 100;
      if (annoNac  <= anno) annoNac  += 100;
      if (annoNac  >  annoAlta)
          return false; // Err: se dio de alta antes de nacer!
      }

      return luhn(nss);
    }

// Algoritmo de Luhn
//  https://es.wikipedia.org/wiki/Algoritmo_de_Luhn
function luhn(nss) {
  var suma   = 0,
  par    = false,
  digito;

  for (var i = nss.length - 1; i >= 0; i--) {
    var digito = parseInt(nss.charAt(i),10);
    if (par)
      if ((digito *= 2) > 9)
        digito -= 9;

      par = !par;
      suma += digito;
    }
    return (suma % 10) == 0;
  }


//Handler para el evento cuando cambia el input
//Elimina cualquier caracter no numérico y comprueba validez
function validarInput(input) {
  var nss       = input.value.replace(/\D+/g,""),
  resultado = document.getElementById("resultado"),
  valido;

    if (nssValido(nss)) { // ⬅️ Acá se comprueba
      valido = "Válido";
      resultado.classList.add("ok");
    } else {
      valido   = "No válido";
      resultado.classList.remove("ok");
    }

    resultado.innerText = "NSS: " + nss + "\nFormato: " + valido;
  }



