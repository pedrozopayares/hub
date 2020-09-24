<?php
// set post fields
$post = [
    'findEntidad' => 'LA GUAJIRA - CÁMARA DE COMERCIO DE LA GUAJIRA', // Company name in the correct format
    'registrosXPagina' => '500', // How many fields you want to see in the results table
    'entidad' => '244001018', // Company code or ID in their system
    /* 'estado' => '', // There are many others options, but you don´t need to know about it now.
    'departamento' => '',
    'municipio' => '',
    'tipoProceso' => '',
    'objeto' => '',
    'cuantia' => '',
    'fechaInicial' => '',
    'fechaFinal' => '',
    'numeroProceso' => '',
    'paginaActual' => '',
    'totalResultados' => '',
    'paginaObjetivo' => '',
    'opnegxdep' => '',
    'desdeFomulario' => '' */
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
echo $response;

?>