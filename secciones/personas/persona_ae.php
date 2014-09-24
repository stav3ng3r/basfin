<?php
$idPersona = recibir_dato('idPersona');
$valor = recibir_dato('valor');
setcookie('valor', $valor);
//-- recepcion de datos

if(!empty($idPersona)){
	$sql="
		select
			id_proyecto,
			identificador,
			persona,
			direccion,
			telefono,
			correo,
			nacimiento,
			observacion
		from
			sistema.personas
		where
			id_persona=$idPersona
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$idProyecto = $row['id_proyecto'];
	$identificador = $row['identificador'];
	$persona = $row['persona'];
	$direccion = $row['direccion'];
	$telefono = $row['telefono'];
	$correo = $row['correo'];
	$nacimiento = $row['nacimiento'];
	$observacion = $row['observacion'];
}else{
	$idProyecto = '';
	$identificador = '';
	$persona = '';
	$direccion = '';
	$telefono = '';
	$correo = '';
	$nacimiento = '';
	$observacion = '';
}
?>