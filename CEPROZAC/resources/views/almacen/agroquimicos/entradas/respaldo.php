



function calcularCantidadAlmacen(idMaterial){


 var route = "http://localhost:8000/obtenerPropiedadesAgroquimicos/"+idMaterial;
 $.get(route,function(res){

   idUnidadMedida= res.idUnidadMedia;

   var routePropiedadesUnidadMedida = "http://localhost:8000/propiedadesUnidadMedidaCantidadJson/"+idUnidadMedida;
   $.get(routePropiedadesUnidadMedida,function(resPropiedadesUnindadMedida){

    cantidadAlmacen = res[0].cantidad;
    diferenciadorUnidadMedida = res[0].unidad_medida;
    capacidadUnidadMedida = res[0].cantidadUnidadMedida;

    if(diferenciadorUnidadMedida == "KILOGRAMOS")
    {

      cantidadUnidadesCompletas= Math.floor(cantidadAlmacen /1000 / capacidadUnidadMedida);

      return cantidadUnidadesCompletas;
    }
    else if(diferenciadorUnidadMedida == "LITROS")  
    {
      cantidadUnidadesCompletas= Math.floor(cantidadAlmacen /1000 / capacidadUnidadMedida);
      return cantidadUnidadesCompletas;

    } 
    else if(diferenciadorUnidadMedida =="UNIDADES")
    {
     return cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
   }

   else if(diferenciadorUnidadMedida =="METROS") {
    return  cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /100/capacidadUnidadMedida); 
  }

  else if(diferenciadorUnidadMedida =="GRAMOS") {
    return  cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
  }

  else if(diferenciadorUnidadMedida =="CENTIMETROS") {
    return  cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
  }

  else if(diferenciadorUnidadMedida =="MILILITROS") {
    return  cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
  }

});

 });

}





function calcularCantidadUnidadCentral(idMaterial){


 var route = "http://localhost:8000/obtenerPropiedadesAgroquimicos/"+idMaterial;
 $.get(route,function(res){

   idUnidadMedida= res.idUnidadMedia;

   var routePropiedadesUnidadMedida = "http://localhost:8000/propiedadesUnidadMedidaCantidadJson/"+idUnidadMedida;
   $.get(routePropiedadesUnidadMedida,function(resPropiedadesUnindadMedida){


     if(diferenciadorUnidadMedida == "KILOGRAMOS")
     {

      cantidadUnidadesCompletas= ((Math.floor(cantidadAlmacen /1000 / capacidadUnidadMedida))*capacidadUnidadMedida)*1000;

      cantidadUnidadCentral =floor( (cantidadAlmacen - cantidadUnidadesCompletas)/1000);

      return cantidadUnidadCentral;
    }
    else if(diferenciadorUnidadMedida =="LITROS")  
    {

      cantidadUnidadesCompletas= ((Math.floor(cantidadAlmacen /1000 / capacidadUnidadMedida))*capacidadUnidadMedida)*1000;
      cantidadUnidadCentral =floor( (cantidadAlmacen - cantidadUnidadesCompletas)/1000);

      return cantidadUnidadCentral;
    } 
    else if(diferenciadorUnidadMedida =="UNIDADES")
    {
     return cantidadUnidadesCompletas=0; 
   }

   else if(diferenciadorUnidadMedida =="METROS") {

    cantidadUnidadesCompletas= ((Math.floor(cantidadAlmacen /100 / capacidadUnidadMedida))*capacidadUnidadMedida)*100;
    cantidadUnidadCentral =Math.floor( (cantidadAlmacen - cantidadUnidadesCompletas)/100);
    return  cantidadUnidadCentral;
  }

});
 });


}
function calcularCantidadUnidadInferior(idMaterial){


 var route = "http://localhost:8000/obtenerPropiedadesAgroquimicos/"+idMaterial;
 $.get(route,function(res){

   idUnidadMedida= res.idUnidadMedia;

   var routePropiedadesUnidadMedida = "http://localhost:8000/propiedadesUnidadMedidaCantidadJson/"+idUnidadMedida;
   $.get(routePropiedadesUnidadMedida,function(resPropiedadesUnindadMedida){



     if(diferenciadorUnidadMedida == "KILOGRAMOS")
     {

       cantidadUnidadesCompletas= ((Math.floor(cantidadAlmacen /1000 / capacidadUnidadMedida))*capacidadUnidadMedida)*1000;
       cantidadUnidadCentral =Math.floor( (cantidadAlmacen - cantidadUnidadesCompletas)/1000) *1000;
       cantidadUnidadInferior =cantidadAlmacen -(cantidadUnidadesCompletas+cantidadUnidadCentral);

       return cantidadUnidadInferior;
     }
     else if(diferenciadorUnidadMedida =="LITROS")  
     {

       cantidadUnidadesCompletas= ((Math.floor(cantidadAlmacen /1000 / capacidadUnidadMedida))*capacidadUnidadMedida)*1000;
       cantidadUnidadCentral =Math.floor( (cantidadAlmacen - cantidadUnidadesCompletas)/1000) *1000;
       cantidadUnidadInferior =cantidadAlmacen -(cantidadUnidadesCompletas+cantidadUnidadCentral);
       return cantidadUnidadInferior;
     } 
     else if(diferenciadorUnidadMedida =="UNIDADES")
     {
      cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
      return cantidadUnidadesCompletas=cantidadAlmacen -(cantidadUnidadesCompletas*capacidadUnidadMedida); 
    } else if(diferenciadorUnidadMedida =="METROS") {

      cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
      return cantidadUnidadesCompletas=cantidadAlmacen -(cantidadUnidadesCompletas*capacidadUnidadMedida); 

    } else if(diferenciadorUnidadMedida =="GRAMOS") {

     cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
     return cantidadUnidadesCompletas=cantidadAlmacen -(cantidadUnidadesCompletas*capacidadUnidadMedida); 

   } else if(diferenciadorUnidadMedida =="MILILITROS") {


    cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
    return cantidadUnidadesCompletas=cantidadAlmacen -(cantidadUnidadesCompletas*capacidadUnidadMedida); 

  } else if(diferenciadorUnidadMedida =="CENTIMETROS") {

   cantidadUnidadesCompletas=Math.floor(cantidadAlmacen /capacidadUnidadMedida); 
   return cantidadUnidadesCompletas=cantidadAlmacen -(cantidadUnidadesCompletas*capacidadUnidadMedida); 
 }

});

 });

}
