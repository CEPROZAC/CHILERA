<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Recepción_Compra</title>
    <link rel="stylesheet" href="css/styleetiqueta.css" media="all" />
  </head>
  <body>
      <div style="border-width: 2px; border-style: dashed; border-color: black; "> 
    <header class="clearfix">
      <div id="logo">
        <img src="images/logoCeprozac.png"  width="100" height="100"/>
      </div>
    </header>
      <table>
        <thead >
          <tr>
            <th class="nombre">Nombre de la Materia Prima</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($material as $item)
            <td>
     <h1>{{ $item->nombre }}</h1> </td>



          </tr>
        </tbody>
      </table>

      <table>
        <thead >
          <tr>
            <th class="fecha">Fecha de Compra</th>
            <th class="num">N° de Compra</th>
          </tr>
        </thead>
        <tbody>
          <tr>

 <td class="fecha"><div style="text-align:center;">{{ $item->fecha_compra }}<br /></td>
  <td class="num"><div style="text-align:center;">{{ $item->id }}<br /></td>
        @endforeach

          </tr>
        </tbody>
      </table>


      <table> 
      <thead> 
      <tr>
      <td> <?php echo DNS1D::getBarcodeHTML("$item->id", "EAN13",2,30);?>
    <div style="text-align:center;">
    <font size=12 class="codigo ">{{$item->id}} 
     </font>
     </div>
   </td>
   </tr>
   </thead>
   </table>


      </div>
    </div>
  </body>

    <body>
      <div style="border-width: 2px; border-style: dashed; border-color: black; "> 
    <header class="clearfix">
      <div id="logo">
        <img src="images/logoCeprozac.png"  width="100" height="100"/>
      </div>
    </header>
      <table>
        <thead >
          <tr>
            <th class="nombre">Nombre de la Materia Prima</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($material as $item)
            <td>
     <h1>{{ $item->nombre }}</h1> </td>


          </tr>
        </tbody>
      </table>
      <table>
        <thead >
          <tr>
            <th class="fecha">Fecha de Compra</th>
            <th class="num">N° de Compra</th>
          </tr>
        </thead>
        <tbody>
          <tr>

 <td class="fecha"><div style="text-align:center;">{{ $item->fecha_compra }}<br /></td>
  <td class="num"><div style="text-align:center;">{{ $item->id }}<br /></td>
        @endforeach

          </tr>
        </tbody>
      </table>
            <table> 
      <thead> 
      <tr>
      <td> <?php echo DNS1D::getBarcodeHTML("$item->id", "EAN13",2,30);?>
    <div style="text-align:center;">
    <font size=12 class="codigo ">{{$item->id}} 
     </font>
     </div>
   </td>
   </tr>
   </thead>
   </table>


      
      </div>
    </div>
  </body>

    <body>
      <div style="border-width: 2px; border-style: dashed; border-color: black; "> 
    <header class="clearfix">
      <div id="logo">
        <img src="images/logoCeprozac.png"  width="100" height="100"/>
      </div>
    </header>
      <table>
        <thead >
          <tr>
            <th class="nombre">Nombre de la Materia Prima</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($material as $item)
            <td>
     <h1>{{ $item->nombre }}</h1> </td>


          </tr>
        </tbody>
      </table>
      <table>
        <thead >
          <tr>
            <th class="fecha">Fecha de Compra</th>
            <th class="num">N° de Compra</th>
          </tr>
        </thead>
        <tbody>
          <tr>

 <td class="fecha"><div style="text-align:center;">{{ $item->fecha_compra }}<br /></td>
  <td class="num"><div style="text-align:center;">{{ $item->id }}<br /></td>
        @endforeach

          </tr>
        </tbody>
      </table>
            <table> 
      <thead> 
      <tr>
      <td> <?php echo DNS1D::getBarcodeHTML("$item->id", "EAN13",2,30);?>
    <div style="text-align:center;">
    <font size=12 class="codigo ">{{$item->id}} 
     </font>
     </div>
   </td>
   </tr>
   </thead>
   </table>


      
      </div>
    </div>
  </body>

    <body>
      <div style="border-width: 2px; border-style: dashed; border-color: black; "> 
    <header class="clearfix">
      <div id="logo">
        <img src="images/logoCeprozac.png"  width="100" height="100"/>
      </div>
    </header>
      <table>
        <thead >
          <tr>
            <th class="nombre">Nombre de la Materia Prima</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($material as $item)
            <td>
     <h1>{{ $item->nombre }}</h1> </td>


          </tr>
        </tbody>
      </table>
      <table>
        <thead >
          <tr>
            <th class="fecha">Fecha de Compra</th>
            <th class="num">N° de Compra</th>
          </tr>
        </thead>
        <tbody>
          <tr>

 <td class="fecha"><div style="text-align:center;">{{ $item->fecha_compra }}<br /></td>
  <td class="num"><div style="text-align:center;">{{ $item->id }}<br /></td>
        @endforeach

          </tr>
        </tbody>
      </table>
            <table> 
      <thead> 
      <tr>
      <td> <?php echo DNS1D::getBarcodeHTML("$item->id", "EAN13",2,30);?>
    <div style="text-align:center;">
    <font size=12 class="codigo ">{{$item->id}} 
     </font>
     </div>
   </td>
   </tr>
   </thead>
   </table>


      
      </div>
    </div>
  </body>

    <body>
      <div style="border-width: 2px; border-style: dashed; border-color: black; "> 
    <header class="clearfix">
      <div id="logo">
        <img src="images/logoCeprozac.png"  width="100" height="100"/>
      </div>
    </header>
      <table>
        <thead >
          <tr>
            <th class="nombre">Nombre de la Materia Prima</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($material as $item)
            <td>
     <h1>{{ $item->nombre }}</h1> </td>


          </tr>
        </tbody>
      </table>
      <table>
        <thead >
          <tr>
            <th class="fecha">Fecha de Compra</th>
            <th class="num">N° de Compra</th>
          </tr>
        </thead>
        <tbody>
          <tr>

 <td class="fecha"><div style="text-align:center;">{{ $item->fecha_compra }}<br /></td>
  <td class="num"><div style="text-align:center;">{{ $item->id }}<br /></td>
        @endforeach

          </tr>
        </tbody>
      </table>
            <table> 
      <thead> 
      <tr>
      <td> <?php echo DNS1D::getBarcodeHTML("$item->id", "EAN13",2,30);?>
    <div style="text-align:center;">
    <font size=12 class="codigo ">{{$item->id}} 
     </font>
     </div>
   </td>
   </tr>
   </thead>
   </table>


      
      </div>
    </div>
  </body>
</html>