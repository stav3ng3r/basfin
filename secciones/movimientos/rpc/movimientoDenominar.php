<?php
$id = recibir_dato('id');

$sql="
	select
		comprobante_tipo as denominacion_denominar
	from
		sistema.movimientos
	where
		id_movimiento=$id
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$resp['html']=$row['denominacion_denominar'];
}else{
	$resp['html']='no existe';
}
?>