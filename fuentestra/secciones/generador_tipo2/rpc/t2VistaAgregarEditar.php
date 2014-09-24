<?php
$idT2 = recibir_dato('idT2');
$idT2VistaEdit = recibir_dato('idT2VistaEdit');
$text = recibir_dato('text'); //--x-
$integer = recibir_dato('integer'); //--x-
$bigint = recibir_dato('bigint'); //--x-
$decimal = recibir_dato('decimal'); //--x-
$date = recibir_dato('date'); //--x-
$select = recibir_dato('select'); //--x-
$textarea = recibir_dato('textarea'); //--x-
$radio = recibir_dato('radio'); //--x-
$checkbox = recibir_dato('checkbox'); //--x-
$idT2Vista = recibir_dato('idT2Vista'); //--x-
$seleccionar = recibir_dato('seleccionar'); //--x-
//--e->recibirDatosAgregarEditar:2

//--e->asignarNullDatosVaciosAgregarEditar:2

if(empty($idT2VistaEdit)){
	$sql="
		insert into otros.generador_detalles(
			id_generador_abm,
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
			--e->camposInsertar:2
		)values(
			$idT2,
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
			--e->valoresInsertar:2
		)
	";
}else{
	$sql="
		update
			otros.generador_detalles
		set
			id_generador_detalle=$idT2, --x-
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
			--e->valoresActualizar:2
		where
			id_generador_detalle=$idT2VistaEdit
	";	
}
$db->set_query($sql);
$db->execute_query();
?>