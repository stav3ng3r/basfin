<?php
$id = recibir_dato('id');

$sql="
	select
		rubro as denominacion_denominar
	from
		sistema.rubros
	where
		id_rubro=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>