<?
$idCategoria=recibir_dato('idCategoria');
$categoria='';
if($idCategoria!=''){
	$sql="select noticia_categoria from noticia_categorias where id_sistema=".$tra['id_sistema']." and id_noticia_categoria=".$idCategoria;
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$categoria=$row['noticia_categoria'];
}
$resp['html']=str_replace('{idCategoria}',$idCategoria,$resp['html']);
$resp['html']=str_replace('{categoria}',$categoria,$resp['html']);
?>