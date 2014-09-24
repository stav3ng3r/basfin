<?php
$idPersonaEdit = recibir_dato('idPersonaEdit');
$idProyecto = recibir_dato('idProyecto');
$identificador = recibir_dato('identificador');
$persona = recibir_dato('persona');
$direccion = recibir_dato('direccion');
$telefono = recibir_dato('telefono');
$correo = recibir_dato('correo');
$nacimiento = recibir_dato('nacimiento');
$observacion = recibir_dato('observacion');

$idProyecto = $_SESSION['id_proyecto'];

$nacimiento = empty($nacimiento) ? 'null' : "'$nacimiento'";

if(empty($idPersonaEdit)){
	$sql="
		insert into sistema.personas(
			id_proyecto,
			identificador,
			persona,
			direccion,
			telefono,
			correo,
			nacimiento,
			observacion
		)values(
			$idProyecto,
			'$identificador',
			'$persona',
			'$direccion',
			'$telefono',
			'$correo',
			$nacimiento,
			'$observacion'
		) returning id_persona
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$idPersona = $row['id_persona'];	
}else{
	$sql="
		update
			sistema.personas
		set
			id_proyecto=$idProyecto,
			identificador='$identificador',
			persona='$persona',
			direccion='$direccion',
			telefono='$telefono',
			correo='$correo',
			nacimiento=$nacimiento,
			observacion='$observacion'
		where
			id_persona=$idPersonaEdit
	";	
	$db->set_query($sql);
	$db->execute_query();
	
	$idPersona = $idPersonaEdit;
}

$resp['idPersona'] = $idPersona;
?>