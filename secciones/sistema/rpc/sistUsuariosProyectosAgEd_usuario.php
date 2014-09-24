<?php
$buscar = recibir_dato('term');
$idUsuario = recibir_dato('idUsuario');

$buscar = trim(strip_tags($buscar));

if(!empty($idUsuario)) {
	$sql="
		select
			usuario as denominacion_denominar
		from
			usuarios
		where
			id_usuario=$idUsuario
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
			id_usuario,
			usuario
		from
			usuarios
		where
			usuario ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$usuarios[$i] = array(
			'id' => $row['id_usuario'],
			'valor' => $row['usuario']
		);
		
		$i++;
	}
	
	echo json_encode($usuarios);
	exit;
}
?>