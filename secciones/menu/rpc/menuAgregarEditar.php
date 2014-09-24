<?php
$item = recibir_dato('item');
$cabIdItem = recibir_dato('cabIdItem');
$orden = recibir_dato('orden');
$tipo = recibir_dato('tipo');
$itemSeccion = recibir_dato('itemSeccion');
$itemAplicacion = recibir_dato('itemAplicacion');
$itemParametro = recibir_dato('itemParametro');
$itemPermiso = recibir_dato('itemPermiso');
$itemDocumento = recibir_dato('itemDocumento');
$itemHref = recibir_dato('itemHref');
$mostrarEn = recibir_dato('mostrarEn');
$visibleMenu = recibir_dato('visibleMenu');
$requiereLogin = recibir_dato('requiereLogin');
$itemDeSistema = recibir_dato('itemDeSistema');
$idItemEdit = recibir_dato('idItemEdit');

if($cabIdItem==''){$cabIdItem='null';}


if($tipo==''){
	$mostrarEn='';
}

$itemDocumento=str_replace(' ','',$itemDocumento);
$itemDocumento=strtolower($itemDocumento);

if($orden==''){
	$sql="select max(orden) from items where ";
	if($cabIdItem=='null'){
		$sql.="cab_id_item is null";
	}else{
		$sql.="cab_id_item=$cabIdItem";
	}
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		$orden=$row['max']+1;
	}else{
		$orden=1;	
	}
}

if($tipo=='documento'){
	$itemParametro=$itemDocumento;
}else if($tipo=='href'){
	$itemParametro=$itemHref;
}

if($mostrarEn=='Entorno'){
	$mostrarEn='';
}

if(empty($idItemEdit)){
	$sql="
		insert into items(
			cab_id_item,
			item,
			orden,
			visible_menu,
			tipo,
			seccion,
			aplicacion,
			parametros,
			mostrar_en,
			permiso,
			requiere_login,
			item_de_sistema
		)values(
			$cabIdItem,
			'$item',
			$orden,
			$visibleMenu,
			'$tipo',
			'$itemSeccion',
			'$itemAplicacion',
			'$itemParametro',
			'$mostrarEn',
			'$itemPermiso',
			$requiereLogin,
			$itemDeSistema
		)
	";
}else{
	$sql="
		update
			items
		set
			cab_id_item=$cabIdItem,
			item='$item',
			orden=$orden,
			visible_menu=$visibleMenu,
			tipo='$tipo',
			seccion='$itemSeccion',
			aplicacion='$itemAplicacion',
			parametros='$itemParametro',
			mostrar_en='$mostrarEn',
			permiso='$itemPermiso',
			requiere_login=$requiereLogin,
			item_de_sistema=$itemDeSistema
		where
			id_item=$idItemEdit
	";	
}
$db->set_query($sql);
$db->execute_query();
?>