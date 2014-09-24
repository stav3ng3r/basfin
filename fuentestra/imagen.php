<?php

// tipo 1 -> modificar tamano porcentualmente
// tipo 2 -> la imagen dentro del recuadro, requiere ancho o alto, o los dos
// tipo 3 -> la imagen se recorta para ocupar el 100% del recuedro, requiere ancho y alto
if($cadenaImagen!=''){
	$vCadena=explode('-*and*-',$cadenaImagen);
	for($i=0;isset($vCadena[$i])==true;$i++){
		list($variable,$valor)=explode('=',$vCadena[$i]);
		if($variable=='archivo'){$url=$valor;}
		if($variable=='tipo'){$tipo=$valor;}
		if($variable=='porc'){$porcentaje=$valor;}
		if($variable=='ancho'){$anchoRecuadro=$valor;}
		if($variable=='alto'){$altoRecuadro=$valor;}
		if($variable=='alinear'){$alinear=$valor;}
		if($variable=='descargar'){$descargar=$valor;}
		if($variable=='firma'){$firma=$valor;}
		if($variable=='icon'){$icon=$valor;}
	}
	
	if($porcentaje==''){$porcentaje=100;}
	if($alinear==''){$alinear='o';}
	if($descargar==''){$descargar=0;}
	if($firma==''){$firma=0;}
	
}else{
	$url=recibir_dato('archivo', 'request');
	$tipo=recibir_dato('tipo', 'request');
	$porcentaje=recibir_dato('porc', 'request', 100);
	$anchoRecuadro=recibir_dato('ancho', 'request');
	$altoRecuadro=recibir_dato('alto', 'request');
	$alinear=recibir_dato('alinear', 'request', 'o');
	$descargar=recibir_dato('descargar', 'request', 0);
	$firma=recibir_dato('firma', 'request', 0);
	$icon=recibir_dato('icon', 'request');
}

/*[O]|||[O]*/

$ext = substr(strrchr($url,'.'),1);
$img = false;

if(preg_match('/^(jpg|png|gif)/', $ext)){
	$img = true;
}

/*[O]|||[O]*/

if($url!='' && $img){
	$url=str_replace('@','/',$url);
	$ruta=substr($url,0,strripos($url,'/')+1);
	$url=substr($url,strripos($url,'/')+1);
	list($nombre,$extencion)=explode('.',$url);
	$url=$ruta.$url;
}else{
	$nombre='fondo.jpg';
	$extencion='jpg';
	$url='fuentestra/imagenes/varios/fondo.jpg';
}

list($anchoOriginal, $altoOriginal) = getimagesize($url);
if($extencion=='jpg'){$imagenOriginal = imagecreatefromjpeg($url);}
if($extencion=='png'){$imagenOriginal = imagecreatefrompng($url);}
if($extencion=='gif'){$imagenOriginal = imagecreatefromgif($url);}

$nombreArchivo='';
$vUrl=explode('/',$url);
for($i=0;isset($vUrl[$i])==true;$i++){
	$nombreArchivo=$vUrl[$i];
}



if($tipo==1){
	$porcentaje=$porcentaje/100;
	$sectorUtilImgOriginal['origen']['x']=0;
	$sectorUtilImgOriginal['origen']['y']=0;
	$sectorUtilImgOriginal['final']['x']=$anchoOriginal;
	$sectorUtilImgOriginal['final']['y']=$altoOriginal;
	$anchoResultado = $anchoOriginal * $porcentaje;
	$altoResultado = $altoOriginal * $porcentaje;
}

if($tipo==2){
	$sectorUtilImgOriginal['origen']['x']=0;
	$sectorUtilImgOriginal['origen']['y']=0;
	$sectorUtilImgOriginal['final']['x']=$anchoOriginal;
	$sectorUtilImgOriginal['final']['y']=$altoOriginal;
	
	if(($anchoRecuadro=='')&&($altoRecuadro!='')){
		$altoResultado=$altoRecuadro;
		$anchoResultado=($anchoOriginal*$altoResultado)/$altoOriginal;
	}
	if(($anchoRecuadro!='')&&($altoRecuadro=='')){
		$anchoResultado=$anchoRecuadro;
		$altoResultado=($altoOriginal*$anchoResultado)/$anchoOriginal;
	}
	if(($anchoRecuadro!='')&&($altoRecuadro!='')){
		$proporcionOriginal=$anchoOriginal/$altoOriginal;
		$proporcionRecuadro=$anchoRecuadro/$altoRecuadro;
		if($proporcionOriginal==$proporcionRecuadro){
			$anchoResultado=$anchoRecuadro;
			$altoResultado=$altoRecuadro;
		}
		if($proporcionOriginal<$proporcionRecuadro){
			$altoResultado=$altoRecuadro;
			$anchoResultado=($anchoOriginal*$altoResultado)/$altoOriginal;
		}
		if($proporcionOriginal>$proporcionRecuadro){
			$anchoResultado=$anchoRecuadro;
			$altoResultado=($altoOriginal*$anchoResultado)/$anchoOriginal;
		}
	}
}

if($tipo==3){	
	if(($anchoRecuadro!='')&&($altoRecuadro!='')){
		$altoResultado=$altoRecuadro;
		$anchoResultado=$anchoRecuadro;
		
		$sectorUtilImgOriginal['origen']['y']=0;
		$sectorUtilImgOriginal['origen']['x']=0;
		
		$sectorUtilImgOriginal['final']['x']=$anchoOriginal;
		$sectorUtilImgOriginal['final']['y']=($anchoOriginal*$altoRecuadro)/$anchoRecuadro;

		if($sectorUtilImgOriginal['final']['y']>$altoOriginal){
			$sectorUtilImgOriginal['final']['y']=$altoOriginal;
			$sectorUtilImgOriginal['final']['x']=($altoOriginal*$anchoRecuadro)/$altoRecuadro;
		}
		
		$anchoUtil=$sectorUtilImgOriginal['final']['x'];
		$altoUtil=$sectorUtilImgOriginal['final']['y'];
		
		if($alinear=='c'){
			$sectorUtilImgOriginal['origen']['x']=($anchoOriginal/2)-($anchoUtil/2);
			$sectorUtilImgOriginal['origen']['y']=($altoOriginal/2)-($altoUtil/2);
		}
		if($alinear=='f'){
			$sectorUtilImgOriginal['origen']['x']=$anchoOriginal-$anchoUtil;
			$sectorUtilImgOriginal['origen']['y']=$altoOriginal-$altoUtil;
		}
	}
}
$imagenResultado = imagecreatetruecolor($anchoResultado, $altoResultado);
imagealphablending($imagenResultado,false);
$fondo = imagecolorallocatealpha($imagenResultado, 254, 254, 254, 127);
imagefilledrectangle($imagenResultado, 0, 0, $anchoResultado, $altoResultado, $fondo);
imagealphablending($imagenResultado,true);
imagecopyresampled($imagenResultado, $imagenOriginal, 0, 0, $sectorUtilImgOriginal['origen']['x'], $sectorUtilImgOriginal['origen']['y'], $anchoResultado, $altoResultado, $sectorUtilImgOriginal['final']['x'], $sectorUtilImgOriginal['final']['y']);

/*
debug('A','imagenResultado',$imagenResultado);
debug('A','imagenOriginal',$imagenOriginal);
debug('A',"sectorUtilImgOriginal['origen']['x']",$sectorUtilImgOriginal['origen']['x']);
debug('A',"sectorUtilImgOriginal['origen']['y']",$sectorUtilImgOriginal['origen']['y']);
debug('A','anchoResultado',$anchoResultado);
debug('A','altoResultado',$altoResultado);
debug('A',"sectorUtilImgOriginal['final']['x']",$sectorUtilImgOriginal['final']['x']);
debug('A',"sectorUtilImgOriginal['final']['y']",$sectorUtilImgOriginal['final']['y']);
debug('--------------------------------------');
*/

//-------- ini firma -----------------------------------------------------------------------------------------
	/*$sql="select firma from archivos where referencia='".recibir_dato('archivo', 'request')."'";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	if($row['firma']=='t'){
		$urlFirma='imagenes/firma.png';
		if(is_file($urlFirma)==false){
			$urlFirma='fuentestra/imagenes/varios/firma.png';
		}
		list($firmaAnchoOriginal, $firmaAltoOriginal) = getimagesize($urlFirma);
		$firmaImagenOriginal = imagecreatefrompng($urlFirma);
	
		$firmaSectorUtilImgOriginal['origen']['x']=0;
		$firmaSectorUtilImgOriginal['origen']['y']=0;
		$firmaSectorUtilImgOriginal['final']['x']=$firmaAnchoOriginal;
		$firmaSectorUtilImgOriginal['final']['y']=$firmaAltoOriginal;
		
		$anchoRecuadro=$anchoResultado;
		$altoRecuadro=$altoResultado;
		
		if(($anchoRecuadro=='')&&($altoRecuadro!='')){
			$firmaAltoResultado=$altoRecuadro;
			$firmaAnchoResultado=($firmaAnchoOriginal*$firmaAltoResultado)/$firmaAltoOriginal;
		}
		if(($anchoRecuadro!='')&&($altoRecuadro=='')){
			$firmaAnchoResultado=$anchoRecuadro;
			$firmaAltoResultado=($firmaAltoOriginal*$firmaAnchoResultado)/$firmaAnchoOriginal;
		}
		if(($anchoRecuadro!='')&&($altoRecuadro!='')){
			$firmaProporcionOriginal=$firmaAnchoOriginal/$firmaAltoOriginal;
			$firmaProporcionRecuadro=$anchoRecuadro/$altoRecuadro;
			if($firmaProporcionOriginal==$firmaProporcionRecuadro){
				$firmaAnchoResultado=$anchoRecuadro;
				$firmaAltoResultado=$altoRecuadro;
			}
			if($firmaProporcionOriginal<$firmaProporcionRecuadro){
				$firmaAltoResultado=$altoRecuadro;
				$firmaAnchoResultado=($firmaAnchoOriginal*$firmaAltoResultado)/$firmaAltoOriginal;
			}
			if($firmaProporcionOriginal>$firmaProporcionRecuadro){
				$firmaAnchoResultado=$anchoRecuadro;
				$firmaAltoResultado=($firmaAltoOriginal*$firmaAnchoResultado)/$firmaAnchoOriginal;
			}
		}
	
		$firmaImagenResultado = imagecreatetruecolor($firmaAnchoResultado, $firmaAltoResultado);
		imagealphablending($firmaImagenResultado,false);
		$firmaFondo = imagecolorallocatealpha($firmaImagenResultado, 254, 254, 254, 127);
		imagefilledrectangle($firmaImagenResultado, 0, 0, $firmaAnchoResultado, $firmaAltoResultado, $firmaFondo);
		imagealphablending($firmaImagenResultado,true);
		imagecopyresampled($firmaImagenResultado, $firmaImagenOriginal, 0, 0, $firmaSectorUtilImgOriginal['origen']['x'], $firmaSectorUtilImgOriginal['origen']['y'], $firmaAnchoResultado, $firmaAltoResultado, $firmaSectorUtilImgOriginal['final']['x'], $firmaSectorUtilImgOriginal['final']['y']);
	
		$difAncho=$anchoRecuadro-$firmaAnchoResultado;
		$difAlto=$altoRecuadro-$firmaAltoResultado;
		if($difAncho>0){$difAncho=$difAncho/2;}
		if($difAlto>0){$difAlto=$difAlto/2;}
		imagecopy($imagenResultado,$firmaImagenResultado,$difAncho,$difAlto,0,0,$firmaAnchoResultado,$firmaAltoResultado);
		imagedestroy($firmaImagenResultado);
	}*/
//-------- fin firma -----------------------------------------------------------------------------------------

//-------- ini icon -----------------------------------------------------------------------------------------
	//if(($icon=='video')||($icon=='audio')){
	if(isset($ext) && !$img){
		/*
		$urlFirma='imagenes/'.$icon.'.png';
		if(is_file($urlFirma)==false){
			$urlFirma='fuentestra/imagenes/varios/'.$icon.'.png';
		}		
		*/
		$urlFirma='imagenes/'.$ext.'.png';
		if(is_file($urlFirma)==false){
			$urlFirma='fuentestra/imagenes/varios/'.$ext.'.png';
		}
		list($firmaAnchoOriginal, $firmaAltoOriginal) = getimagesize($urlFirma);
		$firmaImagenOriginal = imagecreatefrompng($urlFirma);
	
		$firmaSectorUtilImgOriginal['origen']['x']=0;
		$firmaSectorUtilImgOriginal['origen']['y']=0;
		$firmaSectorUtilImgOriginal['final']['x']=$firmaAnchoOriginal;
		$firmaSectorUtilImgOriginal['final']['y']=$firmaAltoOriginal;
		
		$anchoRecuadro=$anchoResultado;
		$altoRecuadro=$altoResultado;
		
		if(($anchoRecuadro=='')&&($altoRecuadro!='')){
			$firmaAltoResultado=$altoRecuadro;
			$firmaAnchoResultado=($firmaAnchoOriginal*$firmaAltoResultado)/$firmaAltoOriginal;
		}
		if(($anchoRecuadro!='')&&($altoRecuadro=='')){
			$firmaAnchoResultado=$anchoRecuadro;
			$firmaAltoResultado=($firmaAltoOriginal*$firmaAnchoResultado)/$firmaAnchoOriginal;
		}
		if(($anchoRecuadro!='')&&($altoRecuadro!='')){
			$firmaProporcionOriginal=$firmaAnchoOriginal/$firmaAltoOriginal;
			$firmaProporcionRecuadro=$anchoRecuadro/$altoRecuadro;
			if($firmaProporcionOriginal==$firmaProporcionRecuadro){
				$firmaAnchoResultado=$anchoRecuadro;
				$firmaAltoResultado=$altoRecuadro;
			}
			if($firmaProporcionOriginal<$firmaProporcionRecuadro){
				$firmaAltoResultado=$altoRecuadro;
				$firmaAnchoResultado=($firmaAnchoOriginal*$firmaAltoResultado)/$firmaAltoOriginal;
			}
			if($firmaProporcionOriginal>$firmaProporcionRecuadro){
				$firmaAnchoResultado=$anchoRecuadro;
				$firmaAltoResultado=($firmaAltoOriginal*$firmaAnchoResultado)/$firmaAnchoOriginal;
			}
		}
	
		$firmaImagenResultado = imagecreatetruecolor($firmaAnchoResultado, $firmaAltoResultado);
		imagealphablending($firmaImagenResultado,false);
		$firmaFondo = imagecolorallocatealpha($firmaImagenResultado, 254, 254, 254, 127);
		imagefilledrectangle($firmaImagenResultado, 0, 0, $firmaAnchoResultado, $firmaAltoResultado, $firmaFondo);
		imagealphablending($firmaImagenResultado,true);
		imagecopyresampled($firmaImagenResultado, $firmaImagenOriginal, 0, 0, $firmaSectorUtilImgOriginal['origen']['x'], $firmaSectorUtilImgOriginal['origen']['y'], $firmaAnchoResultado, $firmaAltoResultado, $firmaSectorUtilImgOriginal['final']['x'], $firmaSectorUtilImgOriginal['final']['y']);
	
		$difAncho=$anchoRecuadro-$firmaAnchoResultado;
		$difAlto=$altoRecuadro-$firmaAltoResultado;
		if($difAncho>0){$difAncho=$difAncho/2;}
		if($difAlto>0){$difAlto=$difAlto/2;}
		imagecopy($imagenResultado,$firmaImagenResultado,$difAncho,$difAlto,0,0,$firmaAnchoResultado,$firmaAltoResultado);
		imagedestroy($firmaImagenResultado);
	}
//-------- fin icon -----------------------------------------------------------------------------------------
if($extencion=='jpg'){header("Content-Type: image/jpeg;");}
if($extencion=='png'){header("Content-Type: image/png;");}
if($extencion=='gif'){header("Content-Type: image/gif;");}
if($descargar==1){
	header('Content-Disposition: attachment; filename="'.$nombreArchivo.'"');
}

// crear nueva imagen desde la marca de agua 
//$marcadeagua = imagecreatefrompng('ma.png'); 

// copiar la "marca de agua" en la fotografia 
//imagecopy($imagenResultado, $marcadegua, 0, 0, 0, 0, 0, 0);

imagesavealpha($imagenResultado,true);

if($extencion=='jpg'){imagejpeg($imagenResultado, NULL, 100);}
if($extencion=='png'){imagepng($imagenResultado, NULL, 0);}
if($extencion=='gif'){imagegif($imagenResultado, NULL, 100);}

imagedestroy($imagenResultado);
?>