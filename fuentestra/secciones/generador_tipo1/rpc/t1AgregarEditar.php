<?php
$idT1Edit = recibir_dato('idT1Edit');
$text = recibir_dato('text'); //--x-
$integer = recibir_dato('integer'); //--x-
$bigint = recibir_dato('bigint'); //--x-
$decimal = recibir_dato('decimal'); //--x-
$date = recibir_dato('date'); //--x-
$select = recibir_dato('select'); //--x-
$textarea = recibir_dato('textarea'); //--x-
$radio = recibir_dato('radio'); //--x-
$checkbox = recibir_dato('checkbox'); //--x-
$seleccionar = recibir_dato('seleccionar'); //--x-
//--e->recibirDatosAgregarEditar

//--e->asignarNullDatosVaciosAgregarEditar

if(empty($idT1Edit)){
	$sql="
		insert into otros.generador_abm(
			text, --x-
			numero, --x-
			big_integer, --x-
			decimales, --x-
			date, --x-
			select_html, --x-
			textarea, --x-
			radio, --x-
			checkbox, --x-
			seleccionar --x-
			--e->camposInsertar
		)values(
			'$text', --x-
			$integer, --x-
			$bigint, --x-
			$decimal, --x-
			'$date', --x-
			'$select', --x-
			'$textarea', --x-
			'$radio', --x-
			$checkbox, --x-
			'$seleccionar' --x-
			--e->valoresInsertar
		)
	";
}else{
	$sql="
		update
			otros.generador_abm
		set
			text='$text', --x-
			numero=$integer, --x-
			big_integer=$bigint, --x-
			decimales='$decimal', --x-
			date='$date', --x-
			select_html='$select', --x-
			textarea='$textarea', --x-
			radio='$radio', --x-
			checkbox=$checkbox, --x-
			seleccionar='$seleccionar' --x-
			--e->valoresActualizar
		where
			id_generador_abm=$idT1Edit
	";	
}
$db->set_query($sql);
$db->execute_query();
?>