<?php
$archivo = recibir_dato('archivo');
$lado = recibir_dato('lado');

if($lado==1){
	$grados = 90;
}else{
	$grados = 270;	
}

// Tipo de contenido
header('Content-type: image/jpeg');

$archivo = 'secciones/'.$archivo;

$jpeg_quality = 90;
// Cargar
$origen = imagecreatefromjpeg($archivo);

// Rotar
$rotar = imagerotate($origen, $grados, 0);

// Imprimir
imagejpeg($rotar,$archivo,$jpeg_quality);

// Liberar la memoria
imagedestroy($origen);
imagedestroy($rotar);
?>