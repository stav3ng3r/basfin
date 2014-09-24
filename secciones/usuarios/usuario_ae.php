<?php
$idUsuario = recibir_dato('idUsuario');
//-- recepcion de datos

if(!empty($idUsuario)){
	$sql="
		select
			*
		from
			usuarios
		where
			id_usuario=$idUsuario
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$usuario = $row['usuario'];
	$nombre = $row['nombre'];
	$email = $row['correo'];
}else{
	$usuario = '';
	$nombre = '';
	$email = '';
}
?>