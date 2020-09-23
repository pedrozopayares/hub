<?php
// set post fields
$post = [
    'findEntidad' => 'Nombre de la entidad',
    'registrosXPagina' => 500,
];

$ch = curl_init('https://www.contratos.gov.co/consultas/resultadoListadoProcesos.jsp');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
echo $response;

?>