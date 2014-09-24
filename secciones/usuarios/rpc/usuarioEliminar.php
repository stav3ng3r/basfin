<?php
$idUsuario=recibir_dato('idUsuario');
	
$sql="select fecha_ultima_accion from usuarios where id_usuario=$idUsuario";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
if($row['fecha_ultima_accion']!=''){
	$resp['mensaje']='No puede eliminar un usuario que ya ha iniciado sesión';
}else{
	$sql="delete from usuarios where id_usuario=$idUsuario";
	$db->set_query($sql);
	$db->execute_query();
}
?>