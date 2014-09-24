<?
$idTorneo=recibir_dato('idTorneo');

$sql="
	select
		torneo
	from
		torneo.torneos
	where
		id_sistema=".$tra['id_sistema']." and 
		id_torneo=$idTorneo
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$resp['html']=str_replace('{torneo}',$row['torneo'],$resp['html']);
$resp['html']=str_replace('{idTorneoEditandoPuntos}',$idTorneo,$resp['html']);
$resp['html']=str_replace('{refrescarEn}',recibir_dato('refrescarEn'),$resp['html']);
?>