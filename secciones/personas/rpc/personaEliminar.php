<?php
$idPersona=recibir_dato('idPersona');
$sql="delete from sistema.personas where id_persona=$idPersona";
$db->set_query($sql);
$db->execute_query();
?>