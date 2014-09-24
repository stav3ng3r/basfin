<?php
$idUsuarioProyecto = recibir_dato('idUsuarioProyecto');
//-- recepcion de datos

if(!empty($idUsuarioProyecto)){
	$sql="
		select
			id_usuario,
			id_proyecto,
			activo
		from
			sistema.usuarios_proyectos
		where
			id_usuario=$idUsuarioProyecto
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$idUsuario = $row['id_usuario'];
	$idProyecto = $row['id_proyecto'];
	$activo = $row['activo'];
	
	$usuario = rpcSeccion('sistema', 'sistUsuariosProyectosAgEd_usuario', array('idUsuario' => $idUsuario));
	$proyecto = rpcSeccion('sistema', 'sistUsuariosProyectosAgEd_proyecto', array('idProyecto' => $idProyecto));	
}else{
	$idUsuario = '';
	$idProyecto = '';
	$activo = '';
}
?>