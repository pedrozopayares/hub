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

// do anything you want with your response
$dom = new DOMDocument; 
echo $response;

?>