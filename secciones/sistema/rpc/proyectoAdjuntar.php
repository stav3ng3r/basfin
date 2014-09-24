<?php
define('DS', DIRECTORY_SEPARATOR);
$raiz = realpath(dirname(__FIlE__) . DS . '../../../fuentestra') . DS;

$adjuntar = array(
	'directorio' 	=> 'sistema/logos/',
	'formatos'		=> 'jpg|jpeg|png|gif|pdf',
	'multiple' 		=> false,
	'previa'		=> array(
			'ancho' 	=> 150,
			'alto' 		=> 150
	)
);

include $raiz . '/adjuntar.php';
?>