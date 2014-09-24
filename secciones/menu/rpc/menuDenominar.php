<?php
$id = recibir_dato('id');

$sql="
	select
		item as denominacion_denominar
	from
		items
	where
		id_item=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>