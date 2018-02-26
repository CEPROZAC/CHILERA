<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Almacén de Materiales</title>
    <link rel="stylesheet" type="fonts" href="css/pdf.css">
  </head>
  <body>
    <?php echo DNS1D::getBarcodeHTML("$material->id", "EAN13");?>
  </body>
</html>