<?
$idNoticia=recibir_dato('idNoticia');

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

registrarVisita('noticias','extenso','idNoticia='.$idNoticia,$titular);

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
	nc.noticia_categoria
from 
	noticia_rel_noticia_categoria rel
	join noticia_categorias nc on (nc.id_sistema=rel.id_sistema and rel.id_noticia_categoria=nc.id_noticia_categoria)
where 
	rel.id_sistema=".$tra['id_sistema']." and rel.id_noticia=$idNoticia
order by
	nc.noticia_categoria asc
";
$db->set_query($sql);
$db->execute_query();
$categorias='';
while($row=$db->get_array()){
	if($row['noticia_categoria'][0]!='.'){
		if($categorias!=''){$categorias.=', ';}
		$categorias.=$row['noticia_categoria'];
	}
}

$sql="
	select 
		na.id_archivo,
		a.referencia,
		a.descripcion,
		a.tipo,
		a.id_archivo_vista_previa
	from 
		noticia_archivos na
		join archivos a on (a.id_sistema=na.id_sistema and a.id_archivo=na.id_archivo)
	where
		na.id_sistema=".$tra['id_sistema']." and 
		na.id_noticia=$idNoticia and 
		(a.tipo='jpg' or a.tipo='gif' or a.tipo='png' or a.tipo='flv' or a.tipo='mp3')
	order by
		na.orden asc
";
$db->set_query($sql);
$db->execute_query();
$htmlArchivos='';
$cantArchivosMultimedia=0;
while($row=$db->get_array()){
	$cantArchivosMultimedia++;
	
	if($row['descripcion']==''){
		$altoImagen=375;
	}else{
		$altoImagen=345;	
	}
	
	if(($row['tipo']=='jpg')||($row['tipo']=='gif')||($row['tipo']=='png')){
		$htmlArchivos.='<li>'.leerHtmlEnSeccion('formato-recuadro-multimedia-en-extenso-noticia').'</li>'.chr(13);
		
		$enlaceAmpliar="javascript:cargarSeccion('archivos','ampliar_multimedia','idArchivo=".$row['id_archivo']."','ventana');";
		$multimedia="<img src='index.php?o=ima&archivo=".$row['referencia']."&tipo=2&ancho=500&alto=$altoImagen'>";
		
		if($enlaceAmpliar!=''){
			$multimedia='<a href="'.$enlaceAmpliar.'" title="Haga click para ampliar la imágen">'.$multimedia.'</a>';
		}
		$htmlArchivos=str_replace('{multimedia}',$multimedia,$htmlArchivos);
		$htmlArchivos=str_replace('{descripcion}',$row['descripcion'],$htmlArchivos);
	}else if($row['tipo']=='flv'){
		if($row['id_archivo_vista_previa']!=''){
			$sql2="select referencia from archivos where id_sistema=".$tra['id_sistema']." and id_archivo=".$row['id_archivo_vista_previa'];
			$db2->set_query($sql2);
			$db2->execute_query();
			$row2=$db2->get_array();
			$refImaVistaPrev=$row2['referencia'];
			$imgVistaPrevia='&amp;previewImage=index.php?o=imaarchivo='.$refImaVistaPrev.'-*and*-tipo=3-*and*-ancho=500-*and*-alto='.$altoImagen;
		}else{
			$imgVistaPrevia='';
		}
		if($row['descripcion']==''){
			$descripcion='';
		}else{
			$descripcion='<div>'.$row['descripcion'].'</div>';
		}
		$htmlArchivos.='
		<li>
			<object id="FLVScrubber" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="500" height="'.$altoImagen.'">
				<param name="movie" value="scrubber.swf">
				<param name="bgcolor" value="#000000">
				<param name="allowScriptAccess" value="always">
				<param name="allowFullScreen" value="true">
				<param name="flashVars" value="file=archivos/'.$row['referencia'].$imgVistaPrevia.'">
				<param name="wmode" value="opaque">
				<embed src="scrubber.swf" wmode="transparent" bgcolor="#000000" name="FLVScrubber" allowscriptaccess="always" allowfullscreen="true" flashvars="file=archivos/'.$row['referencia'].$imgVistaPrevia.'" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" width="500" height="'.$altoImagen.'">
			</object>
			'.$descripcion.'
		</li>
		'.chr(13);
	}else if($row['tipo']=='mp3'){
		
	}
	
}

$sql="
	select 
		na.id_archivo,
		a.referencia,
		a.descripcion,
		a.peso,
		a.tipo
	from 
		noticia_archivos na
		join archivos a on (a.id_sistema=na.id_sistema and a.id_archivo=na.id_archivo)
	where
		na.id_sistema=".$tra['id_sistema']." and 
		na.id_noticia=$idNoticia and 
		(a.tipo<>'jpg' and a.tipo<>'gif' and a.tipo<>'png' and a.tipo<>'flv' and a.tipo<>'mp3')
	order by
		na.orden asc
";
$db->set_query($sql);
$db->execute_query();
$htmlArchivosNoMultimedia='';
while($row=$db->get_array()){
	$link='archivos/'.$row['referencia'];
	$imagen='';
	$tamanho=$row['peso'].' KB';
	if($row['tipo']=='pdf'){
		$link.="\" onClick=\"window.open(this.href, '_blank', 'width=800,height=500'); return false;";
		$imagen='fuentestra/imagenes/formatos/32x32/pdf.png';
	}else if($row['tipo']=='mp3'){
		$imagen='fuentestra/imagenes/formatos/32x32/mp3.png';
	}else if($row['tipo']=='zip'){
		$imagen='fuentestra/imagenes/formatos/32x32/zip.png';
	}else if($row['tipo']=='rar'){
		$imagen='fuentestra/imagenes/formatos/32x32/rar.png';
	}else if($row['tipo']=='txt'){
		$imagen='fuentestra/imagenes/formatos/32x32/txt.png';
	}else if($row['tipo']=='exe'){
		$imagen='fuentestra/imagenes/formatos/32x32/exe.png';
	}else if($row['tipo']=='yt'){
		$imagen='fuentestra/imagenes/formatos/32x32/you-tube.png';
	}else if(($row['tipo']=='doc')||($row['tipo']=='docx')){
		$imagen='fuentestra/imagenes/formatos/32x32/word.png';
	}else if(($row['tipo']=='xls')||($row['tipo']=='xlsx')){
		$imagen='fuentestra/imagenes/formatos/32x32/excel.png';
	}else if(($row['tipo']=='ppt')||($row['tipo']=='pptx')){
		$imagen='fuentestra/imagenes/formatos/32x32/power-point.png';
	}else if(($row['tipo']=='avi')||($row['tipo']=='mp4')||($row['tipo']=='flv')){
		$imagen='fuentestra/imagenes/formatos/32x32/video.png';
	}else{
		$imagen='fuentestra/imagenes/formatos/32x32/default.png';
	}
	
	$htmlArchivosNoMultimedia.=leerHtmlEnSeccion('fila-archivo-no-multimedia-en-extenso').chr(13);
	$htmlArchivosNoMultimedia=str_replace('{idArchivo}',$row['id_archivo'],$htmlArchivosNoMultimedia);
	$htmlArchivosNoMultimedia=str_replace('{enlace}',$link,$htmlArchivosNoMultimedia);
	$htmlArchivosNoMultimedia=str_replace('{vistaPrevia}','<img src="'.$imagen.'">',$htmlArchivosNoMultimedia);
	$htmlArchivosNoMultimedia=str_replace('{nombre}',substr($row['referencia'],15),$htmlArchivosNoMultimedia);
	$htmlArchivosNoMultimedia=str_replace('{descripcion}',$row['descripcion'],$htmlArchivosNoMultimedia);
	$htmlArchivosNoMultimedia=str_replace('{peso}',$row['peso'],$htmlArchivosNoMultimedia);
}
if($htmlArchivosNoMultimedia!=''){
	$htmlArchivosNoMultimedia='
		<div style="background-color:#CCC; font-weight:bold; padding:5px; color:#333;">ARCHIVOS ADJUNTOS</div>
		<div>'.$htmlArchivosNoMultimedia.'</div>
	';
}


$sql="
	select
		n.id_noticia,
		n.titular,
		n.fecha_noticia
	from
		noticia_relacionadas rel
		join noticias n on (n.id_sistema=rel.id_sistema and rel.id_noticia_relacionada=n.id_noticia)
	where
		rel.id_sistema=".$tra['id_sistema']." and
		rel.id_noticia=$idNoticia
	order by
		n.fecha_noticia desc
";
$db->set_query($sql);
$db->execute_query();
$htmlNoticiasRelacionadas='';
while($row=$db->get_array()){
	$htmlNoticiasRelacionadas.="<li><a href=\"javascript:cargarSeccion('noticias','extenso','idNoticia=".$row['id_noticia']."','ventana');\">".$row['titular'].' ('.$row['fecha_noticia'].')</a></li>'.chr(13);
}
if($htmlNoticiasRelacionadas!=''){
	$htmlNoticiasRelacionadas='
	    <div style="background-color:#CCC; font-weight:bold; padding:5px; color:#333;">NOTICIAS RELACIONADAS</div>
        <div style="line-height:20px; padding:10px;">'.$htmlNoticiasRelacionadas.'</div>
	';
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
$resp['html']=str_replace('{categorias}',$categorias,$resp['html']);
$resp['html']=str_replace('{htmlArchivos}',$htmlArchivos,$resp['html']);

$resp['html']=str_replace('{cantArchivosMultimedia}',$cantArchivosMultimedia,$resp['html']);
$resp['html']=str_replace('{htmlArchivosNoMultimedia}',$htmlArchivosNoMultimedia,$resp['html']);
$resp['html']=str_replace('{listaDeNoticiasRelacionadas}',$htmlNoticiasRelacionadas,$resp['html']);
?>