<?php
$idMovimiento=recibir_dato('idMovimiento');

$sql="delete from sistema.movimiento_detalles where id_movimiento=$idMovimiento";
$db->set_query($sql);
$db->execute_query();

$sql="delete from sistema.movimientos where id_movimiento=$idMovimiento";
$db->set_query($sql);
$db->execute_query();
?>