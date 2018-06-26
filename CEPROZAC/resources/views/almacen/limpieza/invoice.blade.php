<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CBALIMPIEZA</title>
    <link rel="stylesheet" href="css/stylepdf.css" media="all" />
  </head>
  <body>
      <div style="border-width: 2px; border-style: dashed; border-color: black; "> 
    <header class="clearfix">
      <div id="logo">
        <img src="images/logoCeprozac.png"  width="100" height="100"/>
      </div>
      <h1>Impresión de Codigo de Barras</h1>
      <div id="project" >
        <div><span>EMPRESA: </span> CEPROZAC</div>
        <div><span>DOMICILIO: </span> KM. 18 CARR. STA. MONICA POZO DE GAMBOA</div> 
        <div><span>         </span> EL LAMPOTAL, VETAGRANDE ZACATECAS</div>
        <div><span>EMAIL: </span> <a href="ceprozac@yahoo.com">ceprozac@yahoo.com</a></div>
        <div><span>TEL: </span> (492)936-8080</div>
        <div><span>Categoria</span> Productos Almacén de Materiales de Limpieza</div>
      </div>
    </header>
    <main>
      <table>
        <thead >
          <tr>
            <th class="nombre">Nombre</th>
            <th class="codigo">Codigo de Barras</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($material as $item)
    <td class="nombre">{{ $item->nombre }}<br /></td>
     <td> <?php echo DNS1D::getBarcodeHTML("$item->codigo", "EAN13",2,40);?>
    <div style="text-align:center;">
    <font size=18 class="codigo	">{{$item->codigo}} 
     </font>
   </td>

        @endforeach

          </tr>
        </tbody>
      </table>
      </div>
    </main>
        <div><span>Regresar: </span> <a href="/almacenes/limpieza">Almacén Limpieza</a></div>
    <footer>
    </footer>
    </div>
  </body>
</html>