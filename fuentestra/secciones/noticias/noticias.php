<?
$idCat=recibir_dato('idCat');
$cadenaBuscar=recibir_dato('cadenaBuscar');

$cadenaBuscar=str_replace('s1gn0mas','+',$cadenaBuscar);

$sql="
	select
		id_noticia_categoria,
		noticia_categoria
	from
		noticia_categorias
	where
		id_sistema=".$tra['id_sistema']." and
		substring(noticia_categoria,1,1)<>'.'
	order by
		noticia_categoria asc
		
";
$db->set_query($sql);
$db->execute_query();
$opcionesCategorias='<option value="">Todas las categorias</option>';
while($row=$db->get_array()){
	if($idCat==$row['id_noticia_categoria']){
		$auxSelected='selected';
	}else{
		$auxSelected='';
	}
	$opcionesCategorias.='<option value="'.$row['id_noticia_categoria'].'" '.$auxSelected.' >'.$row['noticia_categoria'].'</option>';
}

$sql="
	select
		id_noticia_categoria,
		noticia_categoria
	from
		noticia_categorias
	where
		id_sistema=".$tra['id_sistema']." and
		substring(noticia_categoria,1,1)='.'
	order by
		noticia_categoria asc
		
";
$db->set_query($sql);
$db->execute_query();
$opcionesCategorias.='<optgroup label="Por posicionamiento"></optgroup> ';
while($row=$db->get_array()){
	if($idCat==$row['id_noticia_categoria']){
		$auxSelected='selected';
	}else{
		$auxSelected='';
	}
	$opcionesCategorias.='<option value="'.$row['id_noticia_categoria'].'" '.$auxSelected.' >'.substr($row['noticia_categoria'],1).'</option>';
}

$resp['html']=str_replace('<select id="noticiaFiltro_idCat"></select>','<select id="noticiaFiltro_idCat">'.$opcionesCategorias.'</select>',$resp['html']);
$resp['html']=str_replace('{cadenaBuscar}',$cadenaBuscar,$resp['html']);
?>