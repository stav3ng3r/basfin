<?php
$buscar = recibir_dato('term');
$idRubro = recibir_dato('idRubro');

$buscar = trim(strip_tags($buscar));

if(!empty($idRubro)) {
	$sql="
		select
			rubro as denominacion_denominar
		from
			sistema.rubros
		where
			id_rubro=$idRubro
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
			id_rubro,
			rubro
		from
			sistema.rubros
		where
			rubro ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$rubros[$i] = array(
			'id' => $row['id_rubro'],
			'valor' => $row['rubro']
		);
		
		$i++;
	}
	
	echo json_encode($rubros);
	exit;
}
?>