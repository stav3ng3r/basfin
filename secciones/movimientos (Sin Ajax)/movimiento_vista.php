<?php
$idMovimiento=recibir_dato('idMovimiento');

$sql="
	select
		*
	from
		sistema.movimientos
	where
		id_movimiento=$idMovimiento
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$idMovimiento=$row['id_movimiento'];
$tipo=$row['tipo'];
$fecha=$row['fecha'];
$persona=$row['id_persona'];

//$estado=$row['estado'];
//$confirmado=$row['confirmado'];
$infoAuditoria=infoAuditoria('sistema.paises',$row['rowid']);
?>