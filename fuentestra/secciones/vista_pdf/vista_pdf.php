<?
$sec=recibir_dato('sec');
$apl=recibir_dato('apl');
$tit=recibir_dato('tit');
$param=recibir_dato('param');

$cantVariablesPost = count($_POST);
$tags = array_keys($_POST);			// obtiene los nombres de las varibles
$valores = array_values($_POST);		// obtiene los valores de las varibles

$parametrosPdf='';
for($i=0;$i<$cantVariablesPost;$i++){
	if($tags[$i]!='seccion' && $tags[$i]!='aplicacion' && $tags[$i]!='elementoDest' && $tags[$i]!='sec' && $tags[$i]!='apl' && $tags[$i]!='tit'){
		if($parametrosPdf!=''){$parametrosPdf.='&';}
		$parametrosPdf.=$tags[$i].'='.$valores[$i];
	}
}
$urlPDF = urlPDF($parametrosPdf,$apl,$sec);

if(file_exists('secciones/'.$sec.'/'.$apl.'.php')==true || file_exists('secciones/'.$sec.'/'.$apl.'.html')==true){
	$mostrarDetalle=1;
}else{
	$mostrarDetalle=0;	
}

$resp['html']=str_replace('{titulo}',$tit,$resp['html']);
$resp['html']=str_replace('{urlPDF}',$urlPDF,$resp['html']);
$resp['html']=str_replace('{sec}',$sec,$resp['html']);
$resp['html']=str_replace('{apl}',$apl,$resp['html']);
$resp['html']=str_replace('{params}',$parametrosPdf,$resp['html']);
$resp['html']=str_replace('{mostrarDetalle}',$mostrarDetalle,$resp['html']);
?>