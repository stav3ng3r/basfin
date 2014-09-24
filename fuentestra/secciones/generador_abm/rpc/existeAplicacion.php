<?php
$seccion = recibir_dato('seccionAplicacion');
$aplicacionT1 = recibir_dato('aplicacionT1');
$aplicacionT2 = recibir_dato('aplicacionT2');

if(is_dir('secciones/' . $seccion) && $seccion!=''){
	$resp['existeAplicacionT1'] = file_exists('secciones/' . $seccion .'/'. $aplicacionT1.'_lista.html');
	if($aplicacionT2!=''){
		$resp['existeAplicacionT2'] = file_exists('secciones/' . $seccion .'/'. $aplicacionT2.'_lista.html');
	}
}elseif(!is_dir('secciones/' . $seccion)){
	$resp['existeAplicacionT1'] = false;
	$resp['existeAplicacionT2'] = false;
}
?>