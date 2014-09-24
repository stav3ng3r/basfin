<?php
$id = recibir_dato('id');

$sql="
	select
		text as denominacion_denominar
	from
		otros.generador_abm
	where
		id_generador_abm=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>