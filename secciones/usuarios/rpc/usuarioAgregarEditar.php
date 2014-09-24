<?php
$idUsuarioEdit = recibir_dato('idUsuarioEdit');
$usuario = recibir_dato('usuario');
$nombre = recibir_dato('nombre');
$email = recibir_dato('email');
$clave = recibir_dato('clave');
$aclave = recibir_dato('aclave');

function clave($clave) {
	return md5('&%.$#@'.$clave.'.:@%@-');
}

if(empty($idUsuarioEdit)){
	$sql="
		insert into usuarios (
			usuario,
			nombre,
			clave,
			correo
		) values (
			'$usuario',
			'$nombre',
			'".clave($clave)."',
			'$email'
		) returning id_usuario
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$idUsuario = $row['id_usuario'];	
}else{
	$sql="select clave from usuarios where usuario='tra'";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$claveMaestra=$row['clave'];
	
	$sql="select clave from usuarios where id_usuario={$tra['id_usuario']}";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$claveUsuarioActual=$row['clave'];
	
	$sql="select clave from usuarios where id_usuario=$idUsuarioEdit";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$claveUsuarioEditar=$row['clave'];

	if (($claveUsuarioEditar!=clave($aclave)) && ($claveMaestra!=clave($aclave)) && ($claveUsuarioActual!=clave($aclave))) {
		$resp['mensaje']='La clave actual ingresada es incorrecta';
	} else {
		$clave = empty($clave) ? 'clave' : "'". clave($clave) ."'";
		
		$sql="
			update
				usuarios
			set
				nombre='$nombre',
				correo='$email',		
				clave=$clave,
				id_usuario_modif={$tra['id_usuario']},
				fecha_usuario_modif=now()
			where
				id_usuario=$idUsuarioEdit
		";
		$db->set_query($sql);
		$db->execute_query();	
	}
	
	$idUsuario = $idUsuarioEdit;
}

$resp['idUsuario'] = $idUsuario;
?>