<?php
$idRubroCategoriaEdit = recibir_dato('idRubroCategoriaEdit');
$rubroCategoria = recibir_dato('rubroCategoria');
$descripcion = recibir_dato('descripcion');

$idProyecto = $_SESSION['id_proyecto'];

if($idProyecto==''){$idProyecto='null';}

if(empty($idRubroCategoriaEdit)){
	$sql="
		insert into sistema.rubros_categorias(
			rubro_categoria,
			descripcion,
			id_proyecto
		)values(
			'$rubroCategoria',
			'$descripcion',
			$idProyecto
		) returning id_rubro_categoria
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$idRubroCategoria = $row['id_rubro_categoria'];
}else{
	$sql="
		update
			sistema.rubros_categorias
		set
			rubro_categoria='$rubroCategoria',
			descripcion='$descripcion',
			id_proyecto=$idProyecto
		where
			id_rubro_categoria=$idRubroCategoriaEdit
	";
	$db->set_query($sql);
	$db->execute_query();
	
	$idRubroCategoria = $idRubroCategoriaEdit;	
}

$resp['idRubroCategoria'] = $idRubroCategoria;
?>