<?php
$buscar = recibir_dato('term');
$idPersona = recibir_dato('idPersona');

$buscar = trim(strip_tags($buscar));

if(!empty($idPersona)) {
	$sql="
		select
			identificador,
			persona as denominacion_denominar
		from
			sistema.personas
		where
			id_persona=$idPersona
	";
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		$identificador = !empty($row['identificador']) ? ' (' . $row['identificador'] . ')' : '';
		$resp['html']=$row['denominacion_denominar'] . $identificador;
	}else{
		$resp['html']='no existe';
	}
} else {
	$sql="
		select
			identificador,
			id_persona,
			persona
		from
			sistema.personas
		where
			persona ilike '%$buscar%' or
			identificador ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$identificador = !empty($row['identificador']) ? ' (' . $row['identificador'] . ')' : '';
		
		$personas[$i] = array(
			'id' => $row['id_persona'],
			'valor' => $row['persona'] . $identificador
		);
		
		$i++;
	}
	
	echo json_encode($personas);
	exit;
}
?>