<?
$idArchivo=recibir_dato('idArchivo');
$sql="select tipo, referencia, peso, ancho, alto, nombre, descripcion from archivos where id_sistema=".$tra['id_sistema']." and id_archivo=$idArchivo";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	
	registrarVisita('archivos','ampliar_multimedia','idArchivo='.$idArchivo,$row['referencia'].' - '.$row['titulo']);
	
	$multimedia='';
	if(($row['tipo']=='jpg')||($row['tipo']=='png')||($row['tipo']=='gif')){
		$multimedia='<img src="index.php?o=ima&archivo='.$row['referencia'].'&tipo=2&ancho=800&alto=800">';
	}
	$resp['html']=str_replace('{multimedia}',$multimedia,$resp['html']);
	$resp['html']=str_replace('{nombre}',$row['nombre'],$resp['html']);
	$resp['html']=str_replace('{descripcion}',str_replace(chr(10),'<br>',$row['descripcion']),$resp['html']);
}
?>