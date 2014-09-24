<?php
$idT2Vista = recibir_dato('idT2Vista');

if(!empty($idT2Vista)){
	$sql="
		select
			*
		from
			otros.generador_detalles
		where
			id_generador_detalle=$idT2Vista
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$text = $row['text']; //--x-
	$integer = $row['numero']; //--x-
	$bigint = $row['big_integer']; //--x-
	$decimal = $row['decimales']; //--x-
	$date = $row['date']; //--x-
	$select = $row['select_html']; //--x-
	$textarea = $row['textarea']; //--x-
	$radio = $row['radio']; //--x-
	$checkbox = $row['checkbox']; //--x-
	$seleccionarInput = $row['seleccionar']; //--x-
	//--e->asignacionValoresActuales:2
}else{
	$idT2Vista = ''; //--x-
	$text = ''; //--x-
	$integer = ''; //--x-
	$bigint = ''; //--x-
	$decimal = ''; //--x-
	$date = ''; //--x-
	$select = ''; //--x-
	$textarea = ''; //--x-
	$radio = ''; //--x-
	$checkbox = 'f'; //--x-
	$seleccionarInput = ''; //--x-
	//--e->asignacionValoresPorDefecto:2
}
?>