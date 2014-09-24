<?
$idNoticia=$id;

$sql="
select
	n.id_noticia,
	n.titular,
	n.antetitulo,
	n.entradilla,
	n.permitir_comentar,
	n.fecha_noticia,
	n.estado,
	(
		select 
			a.referencia
		from 
			noticia_archivos na
			join archivos a on (a.id_sistema=na.id_sistema and a.id_archivo=na.id_archivo)
		where
			na.id_sistema=".$tra['id_sistema']." and na.id_noticia=n.id_noticia and (a.tipo='jpg' or a.tipo='gif' or a.tipo='png')
		order by
			na.orden asc
		limit 1
	) as archivo_referencia
from 
	noticias n
where 
	id_sistema=".$tra['id_sistema']." and
	id_noticia=$idNoticia
order by
	fecha_noticia desc
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['title']=$row['titular'];
	$resp['descripcion']=$row['entradilla'];
	$resp['info']=$row['entradilla'];
	if($row['archivo_referencia']!=''){
		$resp['imagen']='<img src="http://www.ipparaguay.com.py/2011/ip/index.php?o=ima&archivo='.$row['archivo_referencia'].'&tipo=2&ancho=120&alto=90">';
	}
	$resp['parametrosEnlaceDirecto']='noticias,extenso,idNoticia='.$idNoticia.',ventana';
}
?>