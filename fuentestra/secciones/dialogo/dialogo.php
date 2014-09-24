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

/*** IMPLEMENTAR DOBLE BOTON **/
/*
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id">Double Button</label>
  <div class="col-md-8">
    <button id="button1id" name="button1id" class="btn btn-success">Good Button</button>
    <button id="button2id" name="button2id" class="btn btn-danger">Scary Button</button>
  </div>
</div>
*/

//$htmlBot='<div class="form-group">';
//$htmlBot.='<label class="col-md-4 control-label"></label>';
$htmlBot='';
for($i=0;isset($vBot[$i])==true;$i++){
	list($valor,$accion)=explode(':',$vBot[$i]);
	$accion=str_replace('(and)','&',$accion);
	$accion='cerrarVentana();mostrar(\'objCerrarVentana'.$nivelVentana.'\');'.$accion.'return false;';
	if($i==0){
		$id=' id="priOpcionDialogo" ';
		$btnClass = 'btn-primary';
	}else{
		$id='';
		$btnClass = 'btn-default';
	}
	$accion=str_replace(chr(92)."'","'",$accion);
	$htmlBot.='<button '. $id .' onclick="'. $accion .'" class="btn '. $btnClass .'">'. $valor .'</button>'.chr(10);
}
//$htmlBot.='</div>';
//$htmlBot.='</div>';

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