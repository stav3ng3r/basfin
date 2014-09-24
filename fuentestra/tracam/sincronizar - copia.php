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
$c = 0; 

while ($c < 1) {
	usleep(10000);
	//clearstatcache();
	
	if($_COOKIE['c']) {
		$c=1;
		break;
	}
	
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while(($file = readdir($dh)) !== false) {
				if ($file == sha1($idUsuario)) {
					$c=1;
					$x=1;
					break;
				} else {
					$c=$_COOKIE['c'];	
				}
			}
			closedir($dh);
		}
	}
}

if($x==1) {
	unlink('tmp/' . sha1($idUsuario));
	
	$datos = array();
	$datos['archivo'] = '1';
	$datos['tiempo'] = '2';
	$datos['info'] = '3';
	
	echo json_encode($datos);
}

flush();
?>