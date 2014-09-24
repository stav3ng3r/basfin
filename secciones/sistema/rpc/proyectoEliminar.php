<?php
$idProyecto=recibir_dato('idProyecto');
$sql="delete from sistema.proyectos where id_proyecto=$idProyecto";
$db->set_query($sql);
$db->execute_query();
?>