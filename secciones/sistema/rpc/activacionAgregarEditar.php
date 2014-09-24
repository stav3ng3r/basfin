<?php
$idActivacionEdit = recibir_dato('idActivacionEdit');
$idProyecto = recibir_dato('idProyecto');
$fechaActivacion = recibir_dato('fechaActivacion');
$horaActivacion = recibir_dato('horaActivacion');
$fechaOperacion = recibir_dato('fechaOperacion');
$horaOperacion = recibir_dato('horaOperacion');
$validez = recibir_dato('validez');
$observacion = recibir_dato('observacion');

//$fechaActivacion = $fechaActivacion=='' ? 'null' : "'$fechaActivacion'";
//$fechaOperacion = $fechaOperacion=='' ? 'null' : "'$fechaOperacion'";
$validez = $validez=='' ? 'null' : "'$validez'";

if(empty($idActivacionEdit)){
	$sql="
		insert into sistema.activaciones(
			id_proyecto,
			fecha_activacion,
			fecha_operacion,
			--validez,
			observacion
		)values(
			$idProyecto,
			'$fechaActivacion $horaActivacion',
			'$fechaOperacion $horaOperacion',
			--$validez,
			'$observacion'
		)
	";
}else{
	$sql="
		update
			sistema.activaciones
		set
			id_proyecto=$idProyecto,
			fecha_activacion='$fechaActivacion $horaActivacion',
			fecha_operacion='$fechaOperacion $horaOperacion',
			--validez=$validez,
			observacion='$observacion'
		where
			id_activacion=$idActivacionEdit
	";	
}
$db->set_query($sql);
$db->execute_query();
?>