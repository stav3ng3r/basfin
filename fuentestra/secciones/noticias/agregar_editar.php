<?
$idNoticia=recibir_dato('idNoticia');
$fechaHora=date('d/m/Y H:i');
$titular='';
$antetitulo='';
$entradilla='';
$cuerpo='';

$idsCategorias='';
$idsArchivos='';
$idsNoticiasRelacionadas='';

if($idNoticia!=''){
	$sql="
	select
		fecha_noticia,
		titular,
		antetitulo,
		entradilla,
		cuerpo,
		permitir_comentar,
		estado
	from 
		noticias
	where 
		id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$fechaHora=$row['fecha_noticia'];
	$titular=$row['titular'];
	$antetitulo=$row['antetitulo'];
	$entradilla=$row['entradilla'];
	$cuerpo=$row['cuerpo'];
	$permitirComentar=$row['permitir_comentar'];
	$publicado=$row['estado'];
	
	$sql="
	select
		rel.id_noticia_categoria
	from 
		noticia_rel_noticia_categoria rel
		join noticia_categorias n on (n.id_sistema=rel.id_sistema and rel.id_noticia_categoria=n.id_noticia_categoria)
	where 
		rel.id_sistema=".$tra['id_sistema']." and rel.id_noticia=$idNoticia
	order by
		n.noticia_categoria asc
	";
	$db->set_query($sql);
	$db->execute_query();
	$idsCategorias='';
	while($row=$db->get_array()){
		if($idsCategorias!=''){$idsCategorias.=',';}
		$idsCategorias.=$row['id_noticia_categoria'];
	}
	
	$sql="
	select
		id_archivo
	from 
		noticia_archivos
	where 
		id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia
	order by
		orden
	";
	$db->set_query($sql);
	$db->execute_query();
	$idsArchivos='';
	while($row=$db->get_array()){
		if($idsArchivos!=''){$idsArchivos.=',';}
		$idsArchivos.=$row['id_archivo'];
	}
	
	$sql="
	select
		id_noticia_relacionada
	from 
		noticia_relacionadas
	where 
		id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia
	";
	$db->set_query($sql);
	$db->execute_query();
	$idsNoticiasRelacionadas='';
	while($row=$db->get_array()){
		if($idsNoticiasRelacionadas!=''){$idsNoticiasRelacionadas.=',';}
		$idsNoticiasRelacionadas.=$row['id_noticia_relacionada'];
	}
}


$resp['html']=str_replace('{idNoticia}',$idNoticia,$resp['html']);
$resp['html']=str_replace('{fechaHora}',$fechaHora,$resp['html']);
$resp['html']=str_replace('{titular}',$titular,$resp['html']);
$resp['html']=str_replace('{antetitulo}',$antetitulo,$resp['html']);
$resp['html']=str_replace('{entradilla}',$entradilla,$resp['html']);
$resp['html']=str_replace('{cuerpo}',$cuerpo,$resp['html']);
if($permitirComentar=='t'){
	$resp['html']=str_replace('<input id="permitirComentar" type="checkbox"','<input id="permitirComentar" type="checkbox" checked',$resp['html']);
}
if($publicado=='t'){
	$resp['html']=str_replace('<input id="publicado" type="checkbox"','<input id="publicado" type="checkbox" checked',$resp['html']);
}
$resp['html']=str_replace('{idsCategorias}',$idsCategorias,$resp['html']);
$resp['html']=str_replace('{idsArchivos}',$idsArchivos,$resp['html']);
$resp['html']=str_replace('{idsNoticiasRelacionadas}',$idsNoticiasRelacionadas,$resp['html']);
?>