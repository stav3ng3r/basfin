<?php
$idProyecto = recibir_dato('idProyecto');

$sql="
	select
		*
	from
		sistema.proyectos
	where
		id_proyecto=$idProyecto
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();

$proyecto=$row['proyecto'];
?>