<?php
$idRubro = recibir_dato('idRubro');

$valor = recibir_dato('valor');
setcookie('valor', $valor);
//-- recepcion de datos

if(!empty($idRubro)){
	$sql="
		select
			id_rubro_categoria,
			rubro,
			descripcion
		from
			sistema.rubros
		where
			id_rubro=$idRubro
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$idRubroCategoria = $row['id_rubro_categoria'];
	$rubro = $row['rubro'];
	$descripcion = $row['descripcion'];
	
	if (!empty($idRubroCategoria)) {
		$rubroCategoria = rpcSeccion('rubros', 'rubrRubrosAgEd_rubroCategoria', array('idRubroCategoria' => $idRubroCategoria));
	}
}else{
	$idRubroCategoria = '';
	$rubro = '';
	$descripcion = '';
	$rubroCategoria = '';
}
?>