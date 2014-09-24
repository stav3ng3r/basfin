<?php
$idUsuarioEdit = recibir_dato('idUsuarioEdit');
$idProyectoEdit = recibir_dato('idProyectoEdit');
$idUsuario = recibir_dato('idUsuario');
$idProyecto = recibir_dato('idProyecto');
$activo = recibir_dato('activo');

if($activo==''){$activo='null';}

if(empty($idUsuarioEdit) && empty($idProyectoEdit)){
	$sql="
		insert into sistema.usuarios_proyectos(
			id_usuario,
			id_proyecto,
			activo
		)values(
			$idUsuario,
			$idProyecto,
			$activo
		)
	";
}else{
	$sql="
		update
			sistema.usuarios_proyectos
		set
			id_usuario=$idUsuario,
			id_proyecto=$idProyecto,
			activo=$activo
		where
			id_usuario=$idUsuarioEdit and
			id_proyecto=$idProyectoEdit
	";	
}
$db->set_query($sql);
$db->execute_query();
?>