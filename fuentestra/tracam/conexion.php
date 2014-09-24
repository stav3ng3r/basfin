<?php
$nombre_fichero = "../../tra.ini";
$gestor = fopen($nombre_fichero, "r");
$contenido = fread($gestor, filesize($nombre_fichero));
fclose($gestor);

list($alias,$bd,$usuario,$clave,$servidor) = explode(',', $contenido);

$conexion = array(
	'servidor' => $servidor,
	'puerto' => 5432,
	'base_de_datos' => $bd,
	'usuario' => $usuario,
	'clave' => $clave
);

$conexion[0] = @pg_connect("host={$conexion['servidor']} port={$conexion['puerto']} dbname={$conexion['base_de_datos']} user={$conexion['usuario']} password={$conexion['clave']} options='--client_encoding=UTF8'") or die ($conexion['error']);
?>