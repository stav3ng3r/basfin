<?php
$idProyecto = recibir_dato('idProyecto');
$_SESSION['id_proyecto'] = $idProyecto;

$sql="
	update
		sistema.usuarios_proyectos
	set
		activo=false
	where
		id_usuario={$tra['id_usuario']};
		
	update
		sistema.usuarios_proyectos
	set
		activo=true
	where
		id_usuario={$tra['id_usuario']} and
		id_proyecto=$idProyecto;		
";
$db->set_query($sql);
$db->execute_query();
?>