<?php
$idT1 = recibir_dato('idT1');
//-- recepcion de datos

if(!empty($idT1)){
	$sql="
		select
			* --x-
			--e->camposInputsTablaT1
		from
			otros.generador_abm
		where
			id_generador_abm=$idT1
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
	//--e->asignacionValoresActuales
}else{
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
	//--e->asignacionValoresPorDefecto
}
?>