<?php
$idRubroCategoria = recibir_dato('idRubroCategoria');

$valor = recibir_dato('valor');
setcookie('valor', $valor);
//-- recepcion de datos

if(!empty($idRubroCategoria)){
	$sql="
		select
			rubro_categoria,
			descripcion
		from
			sistema.rubros_categorias
		where
			id_rubro_categoria=$idRubroCategoria
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$rubroCategoria = $row['rubro_categoria'];
	$descripcion = $row['descripcion'];
}else{
	$rubroCategoria = '';
	$descripcion = '';
}
?>