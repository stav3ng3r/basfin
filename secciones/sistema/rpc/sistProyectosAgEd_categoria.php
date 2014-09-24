<?php
$buscar = recibir_dato('term');
$idCategoria = recibir_dato('idCategoria');

$buscar = trim(strip_tags($buscar));

if(!empty($idCategoria)) {
	$sql="
		select
			categoria as denominacion_denominar
		from
			sistema.categorias
		where
			id_categoria=$idCategoria
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
			id_categoria,
			categoria
		from
			sistema.categorias
		where
			categoria ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$categorias[$i] = array(
			'id' => $row['id_categoria'],
			'valor' => $row['categoria']
		);
		
		$i++;
	}
	
	echo json_encode($categorias);
	exit;
}
?>