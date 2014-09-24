<?php
$idCategoriaEdit = recibir_dato('idCategoriaEdit');
$categoria = recibir_dato('categoria');

if($categoria==''){$categoria='null';}

if(empty($idCategoriaEdit)){
	$sql="
		insert into sistema.categorias(
			categoria
		)values(
			'$categoria'
		) returning id_categoria
	";
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
	
	$idCategoria = $row['id_categoria'];
}else{
	$sql="
		update
			sistema.categorias
		set
			categoria='$categoria'
		where
			id_categoria=$idCategoriaEdit
	";	
	$db->set_query($sql);
	$db->execute_query();
	
	$idCategoria = $idCategoriaEdit;
}
$resp['idCategoria'] = $idCategoria;
?>