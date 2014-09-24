<?php
$idRubroEdit = recibir_dato('idRubroEdit');
$idRubroCategoria = recibir_dato('idRubroCategoria');
$rubro = recibir_dato('rubro');
$descripcion = recibir_dato('descripcion');

$idProyecto = $_SESSION['id_proyecto'];

if($idRubroCategoria==''){$idRubroCategoria='null';}
if($idProyecto==''){$idProyecto='null';}

if(empty($idRubroEdit)){
	$sql="
		insert into sistema.rubros(
			id_rubro_categoria,
			id_proyecto,
			rubro,
			descripcion
		)values(
			$idRubroCategoria,
			$idProyecto,
			'$rubro',
			'$descripcion'
		)returning id_rubro
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$idRubro = $row['id_rubro']; 
}else{
	$sql="
		update
			sistema.rubros
		set
			id_rubro_categoria=$idRubroCategoria,
			id_proyecto=$idProyecto,
			rubro='$rubro',
			descripcion='$descripcion'
		where
			id_rubro=$idRubroEdit
	";
	$db->set_query($sql);
	$db->execute_query();
	$idRubro = $idRubroEdit;	
}

$resp['idRubro']=$idRubro;
?>