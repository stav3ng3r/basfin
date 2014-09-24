<?php
$idCaja = recibir_dato('idCaja');
//-- recepcion de datos

if(!empty($idCaja)){
	$sql="
		select
			denominacion		from
			sistema.cajas
		where
			id_caja=$idCaja
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$denominacion = $row['denominacion'];}else{
	$denominacion = '';}
?>