<?php
$x = recibir_dato('x');
$y = recibir_dato('y');
$w = recibir_dato('w');
$h = recibir_dato('h');

$archivo = recibir_dato('archivo');

$infoArchivo = getimagesize($archivo);

$ancho = $infoArchivo[0];
$alto = $infoArchivo[1];
$ancho_rd = 600;
$alto_rd = 600;

if($ancho > $alto){
	$alto_rd = round(($ancho_rd*$alto)/$ancho);
}else{
	$ancho_rd = round(($alto_rd*$ancho)/$alto);
}

$x = round(($ancho*$x)/$ancho_rd);
$y = round(($alto*$y)/$alto_rd);
$w = round(($ancho*$w)/$ancho_rd);
$h = round(($alto*$h)/$alto_rd);

$targ_w = $w;
$targ_h = $h;
$jpeg_quality = 90;

$src = $archivo;
$img_r = imagecreatefromjpeg($src);
$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
imagejpeg($dst_r,$archivo,$jpeg_quality);

imagedestroy($dst_r);
?>