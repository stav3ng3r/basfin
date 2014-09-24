<?php
$tabla = recibir_dato('tabla');
$rowid = recibir_dato('rowid');
$accion = recibir_dato('accion');

$resp['html'] = str_replace('{tabla}',$tabla,$resp['html']);
$resp['html'] = str_replace('{rowid}',$rowid,$resp['html']);
$resp['html'] = str_replace('{accion}',$accion,$resp['html']);
?>