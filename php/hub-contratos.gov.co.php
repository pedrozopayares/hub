<?php
// set post fields
$post = [
    'findEntidad' => 'LA GUAJIRA - CÁMARA DE COMERCIO DE LA GUAJIRA', // Company name in the correct format
    'entidad' => '244001018', // Company code or ID in their system
    // There are many others options, but you don´t need to know about it now.
    'estado' => '', 
    'departamento' => '',
    'municipio' => 0,
    'tipoProceso' => '',
    'objeto' => '',
    'cuantia' => 0,
    'fechaInicial' => '',
    'fechaFinal' => '',
    'numeroProceso' => '',
    'paginaActual' => '',
    'totalResultados' => '',
    'registrosXPagina' => '50000', // How many fields you want to see in the results table. I want all!!!
    'paginaObjetivo' => 1,
    'opnegxdep' => '',
    'desdeFomulario' => true,
    'ctl00$ContentPlaceHolder1$hidIdOrgV' => -1,
    'ctl00$ContentPlaceHolder1$hidIdEmpresaVenta' => -1,
    'ctl00$ContentPlaceHolder1$hidIdEmpresaC' => 0,
    'ctl00$ContentPlaceHolder1$hidIdOrgC' => -1,
    'ctl00$ContentPlaceHolder1$hidNombreDemandante' => -1,
    'ctl00$ContentPlaceHolder1$hidIDRubro' => -1,
    'ctl00$ContentPlaceHolder1$hidRedir' => '',
    'ctl00$ContentPlaceHolder1$hidRangoMaximoFecha' => '',
    'ctl00$ContentPlaceHolder1$hidIDProducto' => -1,
    'ctl00$ContentPlaceHolder1$hidIDProductoNoIngresado' => -1,
    'ctl00$ContentPlaceHolder1$hidNombreProducto' => -1,
    'ctl00$ContentPlaceHolder1$hidNombreProveedor' => -1
];

$ch = curl_init('https://www.contratos.gov.co/consultas/resultadosConsulta.do');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
// execute!
$response = curl_exec($ch);
// close the connection, release resources used
curl_close($ch);

// Create a DomDocument Object to extract info from external site response 
// Then you can send response in a JSON format to your app
$dom = new DOMDocument; 
libxml_use_internal_errors(true); //Avoid warnings break de script when de HTML is not 100% valid
$dom->loadHTML($response);
$tr = $dom->getElementsByTagName('tr');
$total_rows = $tr->length;
$data = []; //final array

// Classical for loop to traverse the rows and communes 
// of the html table
for ($i = 5; $i < $total_rows; $i++) {
    $temp_row = []; // to store row values in an array temporarily
    $row = $tr->item($i)->getElementsByTagName('td');
    for ($j = 1; $j < $row->length; $j++) {
        $temp_row[] = $row->item($j)->textContent;
        $temp_row['link'] = $row->item(1)->childNodes->item(1)->attributes[0]->textContent; // Horrible, but it works
    }
    $data[] = $temp_row;
}

print_r ($temp_row);

//Extract columns names from first row of the table
/*for ($i=0; $i<$total_columns;$i++) {
    $columns_names[] = $tr->item(300)[$i]->textContent;
}*/
//echo json_encode($dom->saveHtml($tr[0]));

?>