<?php
require 'conexion.php';

$idUsuario = $_POST['id_usuario'];

$datos = array();

$sql="
	select
		info_aplicacion_tracam
	from
		usuarios
	where
		id_usuario='$idUsuario'
";
$consulta = pg_query($sql);
$fila = pg_fetch_array($consulta);

$vector = explode('#', $fila['info_aplicacion_tracam']);
$info = explode(',', $vector[0]);
$rpc = str_replace('AgregarEditar', 'Adjuntar', $info[1]);

//include 'secciones/'. $info[2] .'/rpc/' . $rpc;

$datos['id'] = $info[0];
$datos['seccion'] = $info[2];
$datos['rpc'] = $rpc;

echo json_encode(array($datos));
?>