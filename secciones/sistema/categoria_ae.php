<?php
$idCategoria = recibir_dato('idCategoria');

$valor = recibir_dato('valor');
setcookie('valor', $valor);
//-- recepcion de datos

if(!empty($idCategoria)){
	$sql="
		select
			categoria
		from
			sistema.categorias
		where
			id_categoria=$idCategoria
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$categoria = $row['categoria'];
}else{
	$categoria = '';
}
?>