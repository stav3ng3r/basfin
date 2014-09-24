<?php
$permisos = recibir_dato('permisos');
$idUsuario = recibir_dato('idUsuario');
$estado = recibir_dato('estado');
$idSistema = recibir_dato('idSistema');

$permisosNuevos = array();
$permisosActuales = array();

$sql="
	update
		usuarios
	set
		estado=$estado
	where
		id_usuario=$idUsuario
";
$db->set_query($sql);
$db->execute_query();

$permisosNuevos = explode(',', $permisos);

$sql="
	select
		permiso
	from
		usuario_permisos
	where
		id_usuario=$idUsuario and
		id_sistema=$idSistema;
";
$db->set_query($sql);
$db->execute_query();
while ($row = $db->get_array()) {
	$permisosActuales[] = $row['permiso']; 
}

for ($i=0; $i<count($permisosNuevos); $i++) {
	if (!in_array($permisosNuevos[$i], $permisosActuales)) {
		$sql2.="
			insert into usuario_permisos (
				id_usuario,
				permiso,
				id_sistema
			) values (
				$idUsuario,
				'{$permisosNuevos[$i]}',
				$idSistema
			);
		";		
	}
}

for ($i=0; $i<count($permisosActuales); $i++) {
	if (!in_array($permisosActuales[$i], $permisosNuevos)) {
		$sql2.="
			delete from
				usuario_permisos
			where
				id_usuario=$idUsuario and
				permiso='{$permisosActuales[$i]}' and
				id_sistema=$idSistema;
		";		
	}
}
//echo '<pre>'. $sql2 .'</pre>';
if (!empty($sql2)) { 
	$db->set_query($sql2);
	$db->execute_query();
}
?>