<?php
// set post fields
$url = 'https://www.contratos.gov.co/'; //Example data service. For educative porpuse only.
$post = [
    'findEntidad' => 'LA GUAJIRA - CÁMARA DE COMERCIO DE LA GUAJIRA', // Enter the company or entity name in the correct format
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

$ch = curl_init($url . 'consultas/resultadosConsulta.do');
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
$url = "https://www.contratos.gov.co/consultas/detalleProceso.do?numConstancia="; //Details view updated
// Classical for loop to traverse the rows and communes 
// of the html table
for ($i = 1; $i < $total_rows; $i++) { // Warning: I'm not using the first data row at index 0, maybe you need to change 1 to 0 in this line
    $temp_row = []; // to store row values in an array temporarily
    $row = $tr->item($i)->getElementsByTagName('td');
    for ($j = 1; $j < $row->length; $j++) { // Warning: I'm not using the first data column at index 0, maybe you need to change 1 to 0 in this line
        $temp_row[] = $row->item($j)->textContent;
        $temp_row['link'] = $row->item(1)->childNodes->item(1)->attributes[0]->textContent; // Horrible, but it works
        $temp_row['link'] = str_replace("javascript: consultaProceso('", '', $temp_row['link']); // I need to clean the link href text
        $temp_row['link'] = $url . str_replace("')", '', $temp_row['link']); // And add the site url prefix
    }
    $data[] = $temp_row;
}

// Now I can send the data in JSON format, finally ;)
echo json_encode(array('data'=>$data)); 
die();
?>