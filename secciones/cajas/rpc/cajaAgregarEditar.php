<?php
$idCajaEdit = recibir_dato('idCajaEdit');
$denominacion = recibir_dato('denominacion');

$idProyecto = $_SESSION['id_proyecto'];

if (!empty($idProyecto)) {
	if(empty($idCajaEdit)){
		$sql="
			insert into sistema.cajas(
				id_proyecto,
				denominacion
			)values(
				$idProyecto,
				'$denominacion'
			)
		";
	}else{
		$sql="
			update
				sistema.cajas
			set
				id_proyecto=$idProyecto and
				denominacion='$denominacion'
			where
				id_caja=$idCajaEdit
		";	
	}
	$db->set_query($sql);
	$db->execute_query();
} else {
	$resp['mensaje'] = 'Por favor, seleccione un proyecto para realizar alguna tarea';	
}
?>