function fnFormatDetails ( oTable, nTr )
{
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    sOut += '<tr><td><strong>Nombre:</strong></td><td>'+aData[1]+' </td></tr>';
    sOut += '<tr><td><strong>CURP:</strong></td><td>'+aData[6]+' </td></tr>';
    sOut += '<tr><td><strong>Fecha Nacimiento:</strong></td><td>'+aData[5]+' </td></tr>';
    sOut += '<tr><td><strong>Sexo:</strong></td><td>'+aData[9]+' </td></tr>';
    sOut += '<tr><td><strong>Fecha de Ingreso a la empresa:</strong></td><td>'+aData[2]+' </td></tr>';
    sOut += '<tr><td><strong>Fecha de alta en Seguro Social:</strong></td><td>'+aData[3]+' </td></tr>';
    sOut += '<tr><td><strong>Numero de Seguro Social:</strong></td><td>'+aData[4]+' </td></tr>';
    sOut += '<tr><td><strong>Correo:</strong></td><td>'+aData[7]+' </td></tr>';
    sOut += '<tr><td><strong>Telefono:</strong></td><td>'+aData[8]+' </td></tr>';
    sOut += '<tr><td><strong>Rol:</strong></td><td>'+aData[11]+' </td></tr>';
    sOut += '<tr><td><strong>Sueldo:</strong></td><td>'+aData[10]+' </td></tr>';
    sOut += '</table>';

    return sOut;
}

$(document).ready(function() {

    $('#dynamic-table').dataTable( {
        "aaSorting": [[ 4, "desc" ]]
    } );

    /*
     * Insert a 'details' column to the table
     */
     var nCloneTh = document.createElement( 'th' );
     var nCloneTd = document.createElement( 'td' );
     nCloneTd.innerHTML = '<img src="plugins/advanced-datatable/images/details_open.png">';
     nCloneTd.className = "center";

     $('#hidden-table-info thead tr').each( function () {
        this.insertBefore( nCloneTh, this.childNodes[0] );
    } );

     $('#hidden-table-info tbody tr').each( function () {
        this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
    } );

    /*
     * Initialse DataTables, with no sorting on the 'details' column
     */
     var oTable = $('#hidden-table-info').dataTable( {
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0 ] }
        ],
        "aaSorting": [[1, 'asc']]
    });

    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
     $('#hidden-table-info tbody td img').click(function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTable.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src = "plugins/advanced-datatable/images/details_open.png";
            oTable.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "plugins/advanced-datatable/images/details_close.png";
            oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
        }
    } );
 } );



function fnFormatDetails1 ( oTable, nTr )
{
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

    sOut += '<tr><td>Codigo:</td><td>'+aData[1]+' </td></tr>';
    sOut += '<tr><td>Nombre:</td><td>'+aData[2]+' </td></tr>';
    sOut += '<tr><td>Descripcion:</td><td>'+aData[3]+' </td></tr>';
    sOut += '<tr><td>Calidad:</td><td>'+aData[4]+' </td></tr>';
    sOut += '<tr><td>Unidad de medida:</td><td>'+aData[5]+' </td></tr>';
    sOut += '<tr><td>Formato de Empaque:</td><td>'+aData[6]+' </td></tr>';
    sOut += '<tr><td>Porcentaje de Humedad:</td><td>'+aData[7]+' </td></tr>';
    sOut += '<tr><td>Proveedor:</td><td>'+aData[8]+' </td></tr>';

    sOut += '</table>';

    return sOut;
}

$(document).ready(function() {

    $('#dynamic-table1').dataTable( {
        "aaSorting": [[ 4, "desc" ]]
    } );

    /*
     * Insert a 'details' column to the table
     */
     var nCloneTh = document.createElement( 'th' );
     var nCloneTd = document.createElement( 'td' );
     nCloneTd.innerHTML = '<img src="plugins/advanced-datatable/images/details_open.png">';
     nCloneTd.className = "center";

     $('#hidden-table-info1 thead tr').each( function () {
        this.insertBefore( nCloneTh, this.childNodes[0] );
    } );

     $('#hidden-table-info1 tbody tr').each( function () {
        this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
    } );

    /*
     * Initialse DataTables, with no sorting on the 'details' column
     */
     var oTable = $('#hidden-table-info1').dataTable( {
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0 ] }
        ],
        "aaSorting": [[1, 'asc']]
    });

    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
     $('#hidden-table-info1 tbody td img').click(function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTable.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src = "plugins/advanced-datatable/images/details_open.png";
            oTable.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "plugins/advanced-datatable/images/details_close.png";
            oTable.fnOpen( nTr, fnFormatDetails1(oTable, nTr), 'details' );
        }
    } );
 } );