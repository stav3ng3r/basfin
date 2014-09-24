<?php
$idActivacion=recibir_dato('idActivacion');
$sql="delete from sistema.activaciones where id_activacion=$idActivacion";
$db->set_query($sql);
$db->execute_query();
?>