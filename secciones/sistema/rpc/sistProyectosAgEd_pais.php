<?php
$buscar = recibir_dato('term');
$idPais = recibir_dato('idPais');

$buscar = trim(strip_tags($buscar));

if(!empty($idPais)) {
	$sql="
		select
			pais as denominacion_denominar
		from
			sistema.paises
		where
			id_pais=$idPais
	";
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		$resp['html']=$row['denominacion_denominar'];
	}else{
		$resp['html']='no existe';
	}
} else {
	$sql="
		select
			id_pais,
			pais
		from
			sistema.paises
		where
			pais ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$paises[$i] = array(
			'id' => $row['id_pais'],
			'valor' => $row['pais']
		);
		
		$i++;
	}
	
	echo json_encode($paises);
	exit;
}
?>