<?
$texto=recibir_dato('texto');
$botones=recibir_dato('botones');
$nivelVentana=recibir_dato('nivelVentana');
$imagen=recibir_dato('imagen');

if($botones==''){
	$botones='aceptar';
}
if($imagen==''){
	$imagen='advertencia';
}

$vBot=explode('|',$botones);
$htmlBot='<table border="0" cellpadding="2" cellspacing="2" align="center"><tr>';
for($i=0;isset($vBot[$i])==true;$i++){
	list($valor,$accion)=explode(':',$vBot[$i]);
	$accion=str_replace('(and)','&',$accion);
	$accion='cerrarVentana();mostrar(\'objCerrarVentana'.$nivelVentana.'\');'.$accion.'return false;';
	if($i==0){
		$id=' id="priOpcionDialogo" ';
	}else{
		$id='';	
	}
	$accion=str_replace(chr(92)."'","'",$accion);
	$htmlBot.='<td><input '.$id.' type="submit" name="accion" value="'.$valor.'" onclick="'.$accion.'"></td>';
}
$htmlBot.='</tr></table>';

$urlImagen='';
if($imagen=='advertencia'){$urlImagen='../../imagenes/bot/32x32/warning.png';}
if($imagen=='ok'){$urlImagen='../../imagenes/bot/32x32/accept.png';}
if($imagen=='error'){$urlImagen='../../imagenes/bot/32x32/red_button.png';}
if($imagen=='comentario'){$urlImagen='../../imagenes/bot/32x32/comment.png';}
if($imagen=='info'){$urlImagen='../../imagenes/bot/32x32/info.png';}
if($imagen=='cerrado'){$urlImagen='../../imagenes/bot/32x32/lock.png';}
if($imagen=='pregunta'){$urlImagen='../../imagenes/bot/32x32/help.png';}
if($imagen=='eliminar'){$urlImagen='../../imagenes/bot/32x32/delete.png';}
if($urlImagen==''){
	$urlImagen='../../imagenes/bot/32x32/'.$imagen.'.png';
}

$texto=str_replace("t6t985comillaSimple746t985","'",$texto);
$texto=str_replace("#chr10#",chr(10),$texto);

$resp['html']=str_replace('{imagen}',$urlImagen,$resp['html']);
$resp['html']=str_replace('{texto}',$texto,$resp['html']);
$resp['html']=str_replace('{botones}',$htmlBot,$resp['html']);
?>