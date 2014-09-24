<?php
$archivo = recibir_dato('archivo');

$imagen = str_replace('/','@', $archivo);
$imagen = str_replace('secciones@', '', $imagen);
$nombre = explode('/',$archivo);

$resp['html'] = str_replace('{imagen}', $imagen, $resp['html']);
$resp['html'] = str_replace('{archivo}', $archivo, $resp['html']);
$resp['html'] = str_replace('{nombre}', str_replace(' ','-',str_replace('.','_',array_pop($nombre))), $resp['html']);
?>