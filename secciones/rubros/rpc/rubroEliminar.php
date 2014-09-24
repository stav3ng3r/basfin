<?php
$idRubro=recibir_dato('idRubro');
$sql="delete from sistema.rubros where id_rubro=$idRubro";
$db->set_query($sql);
$db->execute_query();
?>