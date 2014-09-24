<?
$origenLlamada=recibir_dato('origenLlamada');
if($origenLlamada=='listadoRelArchivos'){
	$seleccionar='<a href="javascript:irAceptarSeleccion();" title="Aceptar seleccion"><img src="../../imagenes/bot/16x16/accept.png" /></a>';
}else{
	$seleccionar='';
}
$resp['html']=str_replace('{origenLlamada}',$origenLlamada,$resp['html']);
$resp['html']=str_replace('{seleccionar}',$seleccionar,$resp['html']);
?>