<?php
$info = array(
	'id_usuario' => $_POST['id_usuario'],
	'id' => $_POST['id'],
	'seccion' => $_POST['seccion'],
	'rpc' => $_POST['rpc'],
	'archivos' => $archivos
);

ob_start();
include '../../secciones/'.$_POST['seccion'].'/rpc/'. $_POST['rpc'] .'.php';
$content = ob_get_contents();
ob_end_clean();

$adjunto = json_decode($content, true);
$datos = array_merge($info, array('adjuntos' => $adjunto));

$fp = fopen('tmp/'. sha1($_POST['id_usuario']), 'w');
fwrite($fp, $content);
fclose($fp);
?>