<?php
$buscar = recibir_dato('term');
$idProyecto = recibir_dato('idProyecto');

$buscar = trim(strip_tags($buscar));

if(!empty($idProyecto)) {
	$sql="
		select
			proyecto as denominacion_denominar
		from
			sistema.proyectos
		where
			id_proyecto=$idProyecto
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
			id_proyecto,
			proyecto
		from
			sistema.proyectos
		where
			proyecto ilike '%$buscar%'
	";
	$db->set_query($sql);
	$db->execute_query();
	$i=0;
	while($row = $db->get_array()){
		$proyectos[$i] = array(
			'id' => $row['id_proyecto'],
			'valor' => $row['proyecto']
		);
		
		$i++;
	}
	
	echo json_encode($proyectos);
	exit;
}
?>