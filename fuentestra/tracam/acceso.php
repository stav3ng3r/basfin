<?php
require 'conexion.php';

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$datos = array();

$sql="
	select
		*
	from
		usuarios
	where
		usuario='$usuario' and
		clave='". md5('&%.$#@'. $clave .'.:@%@-') ."'
";
$consulta = pg_query($sql);
if($fila = pg_fetch_array($consulta)) {
	$datos['estado'] = 1;
	$datos['id_usuario'] = $fila['id_usuario'];
} else {
	$datos['estado'] = 0;
}

echo json_encode(array($datos));
?>