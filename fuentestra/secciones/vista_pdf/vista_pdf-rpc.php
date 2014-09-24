<?
if($accionRPC=='enviarPorCorreo'){
	$asunto = recibir_dato('asunto');
	$para = recibir_dato('para');
	$mensaje = recibir_dato('mensaje');
	$urlPDF = recibir_dato('urlPDF');
	$urlPDF=str_replace('index.php?o=pdf&','',$urlPDF);
	$vParamUrlPDF=explode('&',$urlPDF);
	$parametrosPdf='';
	for($i=0;isset($vParamUrlPDF[$i])==true;$i++){
		list($variable,$valor)=explode('=',$vParamUrlPDF[$i]);
		if($variable=='s'){
			$sec=$valor;
		}else if($variable=='a'){
			$apl=$valor;
		}else if($variable=='cache'){
			$cachePdf=$valor;
		}else{
			if($parametrosPdf!=''){$parametrosPdf.='&';}
			$parametrosPdf.=$vParamUrlPDF[$i];
		}
	}
	$vAdjunto[1]['tipo']='FPDF';
	$vAdjunto[1]['archivo']=generarPDF($sec,$apl,$parametrosPdf,'cadena');
	enviarCorreo($para,$asunto,$mensaje,$vAdjunto);	
}
?>