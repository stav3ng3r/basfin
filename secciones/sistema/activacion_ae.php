<?php
$idActivacion = recibir_dato('idActivacion');
//-- recepcion de datos

if(!empty($idActivacion)){
	$sql="
		select
			id_proyecto,
			date(fecha_activacion) as fecha_activacion,
			date(fecha_operacion) as fecha_operacion,
			to_char(fecha_activacion, 'HH24:MM') as hora_activacion,
			to_char(fecha_operacion, 'HH24:MM') as hora_operacion,			
			validez,
			observacion
		from
			sistema.activaciones a
		where
			id_activacion=$idActivacion
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$idProyecto = $row['id_proyecto'];
	$fechaActivacion = $row['fecha_activacion'];
	$horaActivacion = $row['hora_activacion'];
	$fechaOperacion = $row['fecha_operacion'];
	$horaOperacion = $row['hora_operacion'];
	$validez = $row['validez'];
	$observacion = $row['observacion'];
	$proyecto = rpcSeccion('sistema', 'sistActivacionesAgEd_proyecto', array('idProyecto' => $idProyecto));
}else{
	$idProyecto = '';
	$fechaActivacion = '';
	$horaActivacion = '';
	$fechaOperacion = '';
	$horaOperacion = '';
	$validez = '';
	$observacion = '';
	$proyecto = '';
}
?>