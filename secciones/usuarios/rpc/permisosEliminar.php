<?php
$permiso=recibir_dato('permiso');

$sql="delete from permisos where permiso='$permiso'";
$db->set_query($sql);
$db->execute_query();
?>