<?php
$idT1=recibir_dato('idT1');
$sql="delete from otros.generador_abm where id_generador_abm=$idT1";
$db->set_query($sql);
$db->execute_query();
?>