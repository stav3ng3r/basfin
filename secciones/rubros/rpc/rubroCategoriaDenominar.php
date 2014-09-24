<?php
$id = recibir_dato('id');

$sql="
	select
		rubro_categoria as denominacion_denominar
	from
		sistema.rubros_categorias
	where
		id_rubro_categoria=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>