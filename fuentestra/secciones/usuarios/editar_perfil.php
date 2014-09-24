<?
$idUsuarioEditar=recibir_dato('idUsuarioEditar');

if($idUsuarioEditar=='{tra:id_usuario}'){
	$idUsuarioEditar=$tra['id_usuario'];
}
/*
$sql="
	select
		usuario,
		nombre,
		correo
	from
		usuarios
	where
		id_sistema=".$tra['id_sistema']." and
		id_usuario=$idUsuarioEditar
";
*/

$sql="
	select
		usuario,
		nombre,
		correo
	from
		usuarios
	where
		id_usuario=$idUsuarioEditar
";


$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$resp['html']=str_replace('{usuario}',$row['usuario'],$resp['html']);
$resp['html']=str_replace('{nombre}',$row['nombre'],$resp['html']);
$resp['html']=str_replace('{correo}',$row['correo'],$resp['html']);
$resp['html']=str_replace('{origen}',recibir_dato('origen'),$resp['html']);
$resp['html']=str_replace('{idUsuarioEditar}',$idUsuarioEditar,$resp['html']);
?>