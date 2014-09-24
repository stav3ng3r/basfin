<?php
$idT2=recibir_dato('idT2');

$sql="
	select
		case when fecha_confirmo is null then false else true end as confirmado,
		estado,
		* --x-
		--e->camposListaTablaT1
	from
		otros.generador_abm
	where
		id_generador_abm=$idT2
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
//--e->reemplazarValoresEnVista
$estado=$row['estado'];
$confirmado=$row['confirmado'];
$infoAuditoria=infoAuditoria('otros.generador_abm',$row['rowid']);
?>