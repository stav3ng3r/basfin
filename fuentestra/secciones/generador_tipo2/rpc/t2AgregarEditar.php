<?php
$idT2 = recibir_dato('idT2Edit');
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

if(empty($idT2)){
	$sql="select nextval('otros.generador_abm_id_generador_abm_seq')";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$idT2 = $row['nextval'];
	
	$sql="
		insert into otros.generador_abm(
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
			--e->camposInsertar
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
			id_generador_abm=$idT2
	";	
}
$db->set_query($sql);
$db->execute_query();

$resp['id']=$idT2;
?>