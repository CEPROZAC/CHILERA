
@inject('metodo','CEPROZAC\Http\Controllers\ContratosController')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CONTRATOS</title>


</head>
<body>
  <header class="clearfix">
    <center> <h4>{{$empresa->nombre}}<br>CONTRATO INDIVIDUAL DE TRABAJO POR TIEMPO DETERMINADO</h4></center>
  </header>
  <main>
    <p ALIGN="justify">EN LA CIUDAD DE VETAGRANDE ZAC. A 01 DE ABRIL DEL 2017, LOS QUE SUSCRIBIMOS EL PRESENTE A SABER <strong>{{$empresa->representanteLegal}}</strong>, COMO PATRON QUIEN EN CURSO DEL PRESENTE CONTRATO SE DENOMINARA <strong>"EL PATRON"</strong>, Y POR OTRA PARTE EL <strong> C. {{$empleado->nombre}} {{$empleado->apellidos}}</strong>, POR SU PROPIO DERECHO COMO<strong> "EL TRABAJADOR"</strong>, HACEMOS CONSTAR QUE HEMOS CONVENIDO CELEBRAR UN <strong>CONTRATO INDIVIDUAL DE TRABAJO POR TIEMPO DETERMINADO</strong>, AL TENOR DE LAS SIGUIENTES:</p>
    <center><h4>CLASULAS</h4></center>
    <p ALIGN="justify"><strong>PRIMERA.</strong> PARA LOS EFECTOS DEL ARTICULO 25 DE LA LEY FEDERAL DEL TRABAJO, <strong>"EL PATRON"</strong> DECLARA QUE SU REPRESENTADA, TIENE COMO ACTIVIDAD LA COMERCIALIZACION DE PRODCUTOS AGRICOLAS CON DOMICILIO FISCAL EN <strong>{{$empresa->domicilioFiscal}}. </strong> "EL TRABAJADOR" DECLARA LLAMARSE {{$empleado->nombre}} {{$empleado->apellidos}}, MEXICANO, CON FECHA DE NACIMIENTO EL DIA {{substr($empleado->fecha_Nacimiento,0,2)}} DE<!--{{$mes =substr($empleado->fecha_Nacimiento,3,2)}}--> {{ $metodo->calcularMes($mes)}} DE {{substr($empleado->fecha_Nacimiento,6,7)}}, CON DOMICILIO EN {{$empleado->domicilio}}.</p>
    <p ALIGN="justify"><strong>SEGUNDA. "EL TRABAJADOR"</strong> SE OBLIGA A PRESTAR SUS SERVICIOS PERSONALES A SUBORDINADO JURIDICAMENTE AL "EL PATRON" CONSISTENTE EN AUXILIAR MULTIPLE DE TIEMPO COMPLETO, ESTE TRABAJO DEBERA EJECUTARLO CON ESMERO Y EFICENCIA, QUEDA EXPRESAMENTE CONVENIDO QUE ACATARA EN EL DESEMPEÑO DE SU TRABAJO, TODAS LAS DISPOSICIONES DEL REGLAMENTO INTERIOR DE TRABAJO, TODAS LAS ORDENES, CIRCULARES Y DISPOSICIONES QUE DICTE EL PATRON, Y TODOS LOS ORDENAMIENTOS LEGALES QUE LE SEAN APLICABLES.</p>
    <p ALIGN="justify"><strong>TERCERA."EL TRABAJADOR"</strong>  DEBERA EJECUTAR SU TRABAJO EN LAS OFICINAS O TALLERES DEL PATRON Y EN CUALQUIER LUGAR DE ESTA CIUDAD, DONDE <strong>EL PATRON</strong> DESEMPEÑE SUS ACTIVIDADES.</p>

    <p ALIGN="justify"><strong>CUARTA.</strong> ESTE CONTRATO SE CELEBRA POR TIEMPO DETERMINADO DE {{floor($contrato->duracionContrato/30)}} MES(ES) {{$contrato->duracionContrato%30}} DIA(S) DE TIEMPO COMPLETO.</p>
    <p ALIGN="justify"><strong>QUINTA. "EL TRABAJADOR"</strong> PERCIBIRA POR LA PRESTACION E LOS SERVICIOS A QUE SE REFIERE ESTE CONTRATO, UN SALARIO DE <strong>{{$sueldoNeto=$empleado->sueldo_Fijo}} </strong><!--{{$sueldo=floor($empleado->sueldo_Fijo)}}--> ({{ $metodo->calcularPesos($sueldoNeto)}} M.N.) DIARIOS, AL CUAL SE APLICARA LA PARTE PROPORCIONAL CORRESPONDIENTE AL DESCANSO SEMANAL CONFORME A LO DISPUESTO EN EL ARTICULO 72 DE LA LEY FEDERAL DEL TRABAJO. EL SALARIO SE LE CUBRIRA LOS DIAS SABADO DE CADA SEMANA LABORAL VENCIDA, EN MONEDA DE CURSO LEGAL Y EN LAS OFICINAS DE <strong>EL PATRON</strong>, ESTANDO OBLIGADO "EL TRABAJADOR" A FIRMAR LAS CONSTANCIAS DE PAGO RESPECTIVAS, TENIENDO EN CUENTA LO DISPUESTO EN LOS ARTICULOS 108 Y 109 DE DICHA LEY. </p>
    <br><br><br>

    <p ALIGN="justify"><strong>SEXTA.</strong>LA DURACION DE LA JORNADA SERA DE SEIS DIAS CON UNO DE DESCANSO, <strong>{{$contrato->horas_Descanso}} HRS, CON {{$contrato->horas_Alimentacion}} HRS DE DESCANSO PARA TOMAR SUS RESPECTIVOS ALIMENTOS,</strong> CONFORME A LO DISPUESTO EN EL ARTICULO 64 DE LA LEY FEDERAL DEL TRABAJO, QUE LE SERA COMPUTADA COMO TIEMPO EFECTIVO LABORADO</p>

    <p ALIGN="justify"><strong>DECIMA TERCERA.</strong>LAS PARTES CONVIENEN EN QUE TODO LO NO PREVISTO EN EL PRESENTE CONTRATO SE REGIRA POR LO DISPUESTO EN LA LEY FEDERAL DEL TRABAJO, Y EN QUE SE PASA POR TODO EXPRESAMENTE A LA JURISDICCION Y COMPETENCIA DE LA JUNTA DE CONCILIACION Y ARBITRAJE EN LA CIUDA DE ZACATECA, ZAC.</p>

    <p ALIGN="justify">LEIDO QUE FUE EL PRESENTE CONTRATO POR LAS PARTES, E IMPUESTAS DE SU CONTENIDO Y FUERZA LEGAL, LO FIRMARON, QUEDANDO UN TANTO EN PODER DE CADA UNA DE LAS PARTES</p>

    <div>
      <div style="float:left;width: 70%;"> {{$empresa->representanteLegal}}</div>

      <div style="float:left;width: 70%;"> {{$empleado->nombre}} {{$empleado->apellidos}}</div>    

    </div>
    <div style="clear:both"></div>
    <br>
    <div>
      <div style="float:left;width: 70%;"><span>_______________________________</span></div>
      <div style="float:left;width: 70%;"><span>_______________________________</span><</div>    

    </div>
    <div style="clear:both"></div>
    <br><br>
    <br>
    <div>

      <div style="float:left;width: 70%;"> TESTIGO</div>

      <div style="float:left;width: 70%;"> TESTIGO</div>    

    </div>
    <div style="clear:both"></div>
    <br>
    <div>
      <div style="float:left;width: 70%;"><span>_______________________________</span></div>
      <div style="float:left;width: 70%;"><span>_______________________________</span><</div>    

    </div>



  </main>

</div>
</body>


</html>