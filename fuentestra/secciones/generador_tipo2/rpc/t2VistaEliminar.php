<?php
$idT2Vista=recibir_dato('idT2Vista');
$sql="delete from otros.generador_detalles where id_generador_detalle=$idT2Vista";
$db->set_query($sql);
$db->execute_query();
?>