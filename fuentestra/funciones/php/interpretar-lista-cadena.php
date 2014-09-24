<?
function obtenerEmail($posicion,$cadena){
	for($i=$posicion-1;isset($cadena[$i])==true;$i--){
		if($cadena[$i]!=''){
			if(caracterPermitido($cadena[$i])==1){
				$posicionIni=$i;
			}else{
				$i=-1;	
			}
		}
	}
	
	for($i=$posicion+1;isset($cadena[$i])==true;$i++){
		if($cadena[$i]!=''){
			if(caracterPermitido($cadena[$i])==1){
				$posicionFin=$i;
			}else{
				$i=strlen($cadena);	
			}
		}
	}
	
	$correo=substr($cadena,$posicionIni,$posicionFin-$posicionIni+1);
	$correo=strtolower($correo);
	if(comprobar_email($correo)==1){
		$nombre='';
		if(($cadena[$posicionIni-1]=='<')||($cadena[$posicionIni-1]=='(')){
			$c2=0;
			$gPosInicioNombre='';
			for($i=$posicionIni-2;((isset($cadena[$i])==true)&&($c2<=100)&&($gPosInicioNombre==''));$i--){
				$c2++;
				if(caracterInicioNombre($cadena[$i])==1){
					$gPosInicioNombre=$i+1;
				}
			}
			if($gPosInicioNombre!=''){
				$nombre=substr($cadena,$gPosInicioNombre,$posicionIni-$gPosInicioNombre-1);
				$nombre=trim($nombre);
				if(($nombre[0]=='"')&&($nombre[strlen($nombre)-1]=='"')){
					$nombre=substr($nombre,1,strlen($nombre)-2);
				}
			}
		}
	}else{
		$correo='';
		$nombre='';
	}
	return $correo.'#%w)#'.$nombre;
}

function obtenerAscii($letra){
	for($i=0;$i<=254;$i++){
		if(chr($i)==$letra){
			return $i;
		}
	}
}

function caracterPermitido($letra){
	$caracteresPermitidos="+-.0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz"; //arroba ya esta fuera de la lista para que no se duplique
	for($i=0;isset($caracteresPermitidos[$i])==true;$i++){
		if($caracteresPermitidos[$i]==$letra){
			return 1;
		}
	}
	return 0;
}

function caracterInicioNombre($letra){
	$caracteresPermitidos=",;:";
	for($i=0;isset($caracteresPermitidos[$i])==true;$i++){
		if($caracteresPermitidos[$i]==$letra){
			return 1;
		}
	}
	return 0;
}

function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
} 
?>