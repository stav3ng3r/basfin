<?php
$id = recibir_dato('id');

$sql="
	select
		categoria as denominacion_denominar
	from
		sistema.categorias
	where
		id_categoria=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>