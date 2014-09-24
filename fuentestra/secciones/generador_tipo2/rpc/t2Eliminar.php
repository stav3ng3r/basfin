<?php
$idT2=recibir_dato('idT2');
$sql="delete from otros.generador_abm where id_generador_abm=$idT2";
$db->set_query($sql);
$db->execute_query();
?>