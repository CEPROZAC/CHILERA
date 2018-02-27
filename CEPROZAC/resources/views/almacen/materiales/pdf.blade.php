<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Almacén de Materiales</title>
    <link rel="stylesheet" type="fonts" href="css/pdf.css">
  </head>
  <div class="porlets-content">
          <div class="table-responsive">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
              <tr>
                   <th>Nombre </th>
                    <th>Codigo de Barras </th>
                                    </tr>
              </thead>
              
<body>	
  @foreach($material  as $materiales)
  <tr class="gradeA">
  <td>{{$materiales->nombre}} </td>
   <td> <?php echo DNS1D::getBarcodeHTML("$materiales->id", "EAN13",5,55);?></td>
     @endforeach

      </tr>
</body>
</table>
</div>
</div>
<input type='button' onclick='window.print();' value='Imprimir' /></form>
</html>

