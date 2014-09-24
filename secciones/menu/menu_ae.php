<?
$idItem = recibir_dato('idItem');
$cabIdItemAg = recibir_dato('cabIdItem');

if(!empty($idItem)){
	$sql="
		select
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
		from
			items
		where
			id_item=$idItem
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();

	$cabIdItem = $row['cab_id_item'];
	$item = $row['item'];
	$orden = $row['orden'];

	$tipo = $row['tipo'];
	$item_seccion = $row['seccion'];
	$item_aplicacion = $row['aplicacion'];
	$item_permiso = $row['permiso'];

	if($tipo=='documento'){
		$item_parametros = '';
		$item_documento = str_replace('documento=','',$row['parametros']);
		$item_href = '';
	}else if($tipo=='aplicacion'){
		$item_parametros = $row['parametros'];
		$item_documento = '';
		$item_href = '';
	}else if($tipo=='href'){
		$item_parametros = '';
		$item_documento = '';
		$item_href = $row['parametros'];
	}else{
		$item_parametros = '';
		$item_documento = '';
		$item_href = '';
	}
	$mostrarEn = $row['mostrar_en'];
	$visibleMenu = $row['visible_menu'];
	$requiereLogin = $row['requiere_login'];
	$itemDeSistema = $row['item_de_sistema'];
}else{
	$cabIdItem = $cabIdItemAg;
	$item = '';
	$orden = '';
	$tipo = '';
	$item_seccion = '';
	$item_aplicacion = '';
	$item_parametros = '';
	$item_permiso = '';
	$item_documento = '';
	$item_href = '';
	$mostrarEn = '';
	$visibleMenu  = 't';
	$requiereLogin = 't';
	$itemDeSistema = 'f';
}

if($tra['id_usuario']==1){
	$usutra=1;
}else{
	$usutra=0;
}

$resp['html']=str_replace('{idItem}',$idItem,$resp['html']);
$resp['html']=str_replace('{cabIdItem}',$cabIdItem,$resp['html']);
$resp['html']=str_replace('{item}',$item,$resp['html']);
$resp['html']=str_replace('{orden}',$orden,$resp['html']);
$resp['html']=selectedSelect('menuMenuAgEd_tipo',$tipo,$resp['html']);
$resp['html']=str_replace('{seccion}',$item_seccion,$resp['html']);
$resp['html']=str_replace('{aplicacion}',$item_aplicacion,$resp['html']);
$resp['html']=str_replace('{parametros}',$item_parametros,$resp['html']);
$resp['html']=str_replace('{permiso}',$item_permiso,$resp['html']);
$resp['html']=str_replace('{documento}',$item_documento,$resp['html']);
$resp['html']=str_replace('{href}',$item_href,$resp['html']);
$resp['html']=selectedSelect('menuMenuAgEd_mostrarEn',$mostrarEn,$resp['html']);
$resp['html']=checkCheckBox('menuMenuAgEd_visibleMenu',$resp['html'],$visibleMenu);
$resp['html']=checkCheckBox('menuMenuAgEd_requiereLogin',$resp['html'],$requiereLogin);
$resp['html']=checkCheckBox('menuMenuAgEd_itemDeSistema',$resp['html'],$itemDeSistema);
$resp['html']=str_replace('{usutra}',$usutra,$resp['html']);
?>