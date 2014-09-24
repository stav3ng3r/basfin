<?php
$idProyecto = recibir_dato('idProyecto');
$idUsuario = recibir_dato('idUsuario');

$sql="
	update
		sistema.usuarios_proyectos
	set
		activo=false
	where
		id_usuario=$idUsuario;
";
$db->set_query($sql);
$db->execute_query();		

$sql="
	insert into sistema.usuarios_proyectos (
		id_usuario,
		id_proyecto,
		activo
	) values (
		$idUsuario,
		$idProyecto,
		true
	);
";
$db->set_query($sql);
$db->execute_query();
?>