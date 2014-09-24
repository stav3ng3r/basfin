<?php
/*$directorio = 'sistema/logos/';
$formatos = 'jpg|png|gif';
$multiple = false;*/



//include '../../../fuentestra/adjuntar.php';


$adjuntar = array(
	'directorio' => 'sistema/logos/',
	'formatos'	=> 'jpg|jpeg',
	'multiple' => false,
	'previa' => array(
		'ancho' => 460,
		'alto' => 380
	)
);

setcookie('adjuntar', $adjuntar);
header('Location: ../../../fuentestra/adjuntar.php');
?>