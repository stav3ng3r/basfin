<?php
$buscar = recibir_dato('term');
$idPais = recibir_dato('pais');
$idCiudad = recibir_dato('idCiudad');

$buscar = trim(strip_tags($buscar));

if(!empty($idCiudad)) {
	$sql="
		select
			ciudad as denominacion_denominar
		from
			sistema.ciudades
		where
			id_ciudad=$idCiudad
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
			id_ciudad,
			ciudad
		from
			sistema.ciudades
		where
			ciudad ilike '%$buscar%' and
			id_pais=$idPais
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$ciudades[$i] = array(
			'id' => $row['id_ciudad'],
			'valor' => $row['ciudad']
		);
		
		$i++;
	}
	
	echo json_encode($ciudades);
	exit;
}
?>