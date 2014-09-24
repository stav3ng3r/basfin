<?php
$buscar = recibir_dato('term');
$idRubroCategoria = recibir_dato('idRubroCategoria');

$buscar = trim(strip_tags($buscar));

if(!empty($idRubroCategoria)) {
	$sql="
		select
			rubro_categoria as denominacion_denominar
		from
			sistema.rubros_categorias
		where
			id_rubro_categoria=$idRubroCategoria
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
			id_rubro_categoria,
			rubro_categoria
		from
			sistema.rubros_categorias
		where
			rubro_categoria ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$rubroCategoria[$i] = array(
			'id' => $row['id_rubro_categoria'],
			'valor' => $row['rubro_categoria']
		);
		
		$i++;
	}
	
	echo json_encode($rubroCategoria);
	exit;
}
?>