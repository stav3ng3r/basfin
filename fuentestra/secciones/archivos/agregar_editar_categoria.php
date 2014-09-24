<?
$idCategoria=recibir_dato('id');
$nombreCategoria='';

if($idCategoria!=''){
    $sql="select archivo_categoria from archivo_categorias where id_sistema=".$tra['id_sistema']." and id_archivo_categoria=$idCategoria";
    $db->set_query($sql);
    $db->execute_query();
    if($row=$db->get_array()){
    	$nombreCategoria=$row['archivo_categoria'];
    }
}

$resp['html']=str_replace('{idCategoriaArchivo}',$idCategoria,$resp['html']);
$resp['html']=str_replace('{nombreCategoria}',$nombreCategoria,$resp['html']);
?>