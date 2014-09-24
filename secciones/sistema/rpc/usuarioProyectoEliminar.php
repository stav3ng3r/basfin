<?php
$idUsuario=recibir_dato('idUsuario');
$idProyecto=recibir_dato('idProyecto');
$sql="delete from sistema.usuarios_proyectos where id_usuario=$idUsuario and id_proyecto=$idProyecto";
$db->set_query($sql);
$db->execute_query();
?>