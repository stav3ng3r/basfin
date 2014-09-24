<?php
ini_set('max_execution_time', 0);
session_start();

$dir = 'tmp/';

$archivo = "../../tra.ini";
$gestor = fopen($archivo, "r");
$contenido = fread($gestor, filesize($archivo));
fclose($gestor);

list($alias,$bd,$usuario,$clave,$servidor) = explode(',', $contenido);

$idUsuario = $_SESSION['idUsuario_' . $alias];

$x=0;

if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while(($file = readdir($dh)) !== false) {
			if ($file == sha1($idUsuario)) {
				$x=1;
			}
		}
		closedir($dh);
	}
}

if($x==1) {
	$gestor = fopen($dir . sha1($idUsuario), "r");
	$contenido = fread($gestor, filesize($dir . sha1($idUsuario)));
	fclose($gestor);
	
	unlink($dir . sha1($idUsuario));

	echo $contenido;
}

flush();
?>