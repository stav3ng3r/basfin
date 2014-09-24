<?
$nivelVentana=recibir_dato('nivelVentana');
$posClickX=recibir_dato('posClickX');
$posClickY=recibir_dato('posClickY');
$onLoad=recibir_dato('onLoad');
$html='';
if(file_exists('ventana/ventana.css')==true){
	$onLoad.="agregarEstiloCss('ventana/ventana.css');";$b=1;
}else if(file_exists('fuentestra/ventana/ventana.css')==true){
	$onLoad.="agregarEstiloCss('fuentestra/ventana/ventana.css');";$b=1;
}
if(file_exists('ventana/estilos.css')==true){
	$onLoad.="agregarEstiloCss('ventana/estilos.css');";$b=1;
}else if(file_exists('fuentestra/ventana/estilos.css')==true){
	$onLoad.="agregarEstiloCss('fuentestra/ventana/estilos.css');";$b=1;
}
if(file_exists('ventana/ventana.html')==true){
	$resp['html']=leer_codigo_de_archivo('ventana/ventana.html');$b=1;
	
	$resp['html']=str_replace(' src="imagenes/',' src="ventana/'.$seccion.'/imagenes/',$resp['html']);
	$resp['html']=str_replace('url(imagenes/','url(ventana/'.$seccion.'/imagenes/',$resp['html']);
	$resp['html']=str_replace(' src="../../../fuentestra/',' src="fuentestra/',$resp['html']);
	$resp['html']=str_replace('url(../../../fuentestra/','url(fuentestra/',$resp['html']);
}else if(file_exists('fuentestra/ventana/ventana.html')==true){
	$resp['html']=leer_codigo_de_archivo('fuentestra/ventana/ventana.html');$b=1;	
	
	$resp['html']=str_replace(' src="imagenes/',' src="fuentestra/ventana/'.$seccion.'/imagenes/',$resp['html']);
	$resp['html']=str_replace('url(imagenes/','url(fuentestra/ventana/'.$seccion.'/imagenes/',$resp['html']);	
	$resp['html']=str_replace(' src="../../imagenes/',' src="fuentestra/imagenes/',$resp['html']);
	$resp['html']=str_replace('url(../../imagenes/','url(fuentestra/imagenes/',$resp['html']);	
}
if(file_exists('ventana/ventana.js')==true){
	$onLoad.="agregarFuncionJs('ventana/ventana.js','');";$b=1;
}else if(file_exists('fuentestra/ventana/ventana.js')==true){
	$onLoad.="agregarFuncionJs('fuentestra/ventana/ventana.js','');";
}
if($b==1){
	$resp['mensaje']='ok';
}else{
	$resp['mensaje']='no se encontraron codigos para la ventana';
}

$resp['html']=str_replace('{nivel}',$nivelVentana,$resp['html']);
$resp['html']=str_replace('{z-index}',(($nivelVentana*100)+9900),$resp['html']);

// --- $posIniTop=200-($nivelVentana*10)+10; ---
// --- $posIniLeft=($nivelVentana*10)-10; ---

$posIniTop=$posClickY-100;
if($posIniTop<100){
	$posIniTop=100;
}
$posIniLeft=($nivelVentana*10)-10;

$resp['html']=str_replace('{posIniTop}',$posIniTop.'px',$resp['html']);
$resp['html']=str_replace('{posIniLeft}',$posIniLeft.'px',$resp['html']);

$onLoad=str_replace(chr(92)."'","'",$onLoad);

$resp['onLoad']=$onLoad;
$resp['nivelVentana']=$nivelVentana;
traAjax($resp);
?>