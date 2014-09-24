<?php
$id = recibir_dato('id');

$sql="
	select
		denominacion as denominacion_denominar
	from
		sistema.cajas
	where
		id_caja=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>