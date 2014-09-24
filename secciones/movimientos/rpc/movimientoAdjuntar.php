<?php
define('DS', DIRECTORY_SEPARATOR);
$raiz = realpath(dirname(__FIlE__) . DS . '../../../fuentestra') . DS;

$adjuntar = array(
	'directorio' 	=> 'movimientos/movimientos/',
	'formatos'		=> 'jpg|jpeg|pdf',
	'multiple' 		=> true,
	'previa'		=> array(
			'ancho' 	=> 180,
			'alto' 		=> 120
	)
);

include $raiz . '/adjuntar.php';
?>