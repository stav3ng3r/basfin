<?php
$idCaja=recibir_dato('idCaja');
$sql="delete from sistema.cajas where id_caja=$idCaja";
$db->set_query($sql);
$db->execute_query();
?>