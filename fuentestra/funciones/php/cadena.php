<?
function leer_codigo_de_archivo($ruta){
	$codigo="";
	if(file_exists($ruta)==true){
		$DescriptorFichero = fopen($ruta,"r");
		while(!(feof($DescriptorFichero))){
			$buffer = fgets($DescriptorFichero,4096);
			$codigo.=$buffer;
		}
	}else{
		$codigo="no se encuentra el archivo ".$ruta." en la carpeta disenho";
	}
	return $codigo;
}

function ponerAcute($cadena){
	$cadena=str_replace('�','&aacute;',$cadena);
	$cadena=str_replace('�','&eacute;',$cadena);
	$cadena=str_replace('�','&iacute;',$cadena);
	$cadena=str_replace('�','&oacute;',$cadena);
	$cadena=str_replace('�','&uacute;',$cadena);
	$cadena=str_replace('�','&Aacute;',$cadena);
	$cadena=str_replace('�','&Eacute;',$cadena);
	$cadena=str_replace('�','&Iacute;',$cadena);
	$cadena=str_replace('�','&Oacute;',$cadena);
	$cadena=str_replace('�','&Uacute;',$cadena);
	return $cadena;
}

function checkedRadio($nombreRadio,$valor,$html){
    $html=str_replace('<input type="radio" name="'.$nombreRadio.'" value="'.$valor.'"','<input type="radio" name="'.$nombreRadio.'" value="'.$valor.'" checked',$html);
    return $html;
}

function selectedSelect($nombreSelect,$valor,$html){
	$posIniSelect=strpos($html,'<select name="'.$nombreSelect.'"');
    if($posIniSelect>0){
    	$i=$posIniSelect;
    	$posFinSelect=0;
    	while(($i<strlen($html))&&($posFinSelect==0)){
    		$i++;
    		if(substr($html,$i,9)=='</select>'){
    			$posFinSelect=$i+9;
    		}
    	}
    	$codigoSelect=substr($html,$posIniSelect,($posFinSelect-$posIniSelect));
    
        if(strpos($codigoSelect,'<option value="'.$valor.'"')<>-1){
            $codigoSelect=str_replace('<option value="'.$valor.'"','<option value="'.$valor.'" selected="selected"',$codigoSelect);
            $html=substr($html,0,$posIniSelect).$codigoSelect.substr($html,$posFinSelect);
        }
    }
	return $html;
}

function checkRadio($nombre,$valor,$html){
    $inputStr='<input type="radio" name="'.$nombre.'" value="'.$valor.'"';
	$posIni=strpos($html,$inputStr);
    $posFin=strpos($html,'>',$posIni);
    if($posIni!=''){
        $codigo=substr($html,$posIni,($posFin-$posIni));
        $valorStr=' checked="checked" ';
        $html=substr($html,0,$posIni + strlen($inputStr)) . $valorStr .substr($html,$posFin);
        //echo('<textarea cols="100" rows="20">'. $html .'</textarea>');
    }
	return $html;
}

function checkCheckBox($nombre,$html,$value=''){
    if($value!=''){
        $inputStr='<input type="checkbox" name="'.$nombre.'" value="'.$value.'"';;
    }else{
        $inputStr='<input type="checkbox" name="'.$nombre.'"';
    }
	$posIni=strpos($html,$inputStr);
    $inputStrLength=strlen($inputStr);
    if($posIni>0){
        $posFin=strpos($html, '>',$posIni)+1;  //$posIni + $inputStrLength;
        $codigo=substr($html,$posIni,($posFin-$posIni));
        $codigo=str_replace($inputStr,$inputStr.' checked="checked"',$codigo);
        $html=substr($html,0,$posIni). $codigo .substr($html,$posFin);     
    }
	return $html;
}

function numeroChr($caracter){
	for($i=0;$i<=254;$i++){
		if(chr($i)==$caracter){
			$num=$i;
			$i=255;
		}
	}
	return $num;
}

function largo_fijo($texto, $tamano, $caracter=""){
	$tamano_texto=strlen($texto);
	if($tamano_texto<$tamano){
		while(strlen($texto)<$tamano){
			$texto=$caracter.$texto;
		}
	}
	return $texto;
}

function resaltarCadena($cadena,$contenido,$class='',$style=''){
	$vB = array('�', '�', '�', '�', '�', 'n');
	$vR = array('a', 'e', 'i', 'o', 'u', 'n');
	
	$cadena2=str_replace($vB,$vR,strtolower($cadena));
	$contenido2=str_replace($vB,$vR,strtolower($contenido));
	if(($class=='')&&($style=='')){$class="resalteBusqueda";$style='font-weight:bold;color: red;';}
	if($class!=''){$class="class='$class'";}
	if($style!=''){$style="style='$style'";}
	
	if(substr($cadena,0,1)=='"' && substr($cadena,strlen($cadena)-1,1)=='"'){
		$vCadBuscar[0]=substr($cadena,1,strlen($cadena)-2);
	}else if(substr_count($cadena2,'+')>0){
		$vCadBuscar=explode('+',$cadena2);
	}else{
		$vCadBuscar=explode(' ',$cadena2);
	}
	for($i=0;isset($vCadBuscar[$i]);$i++){
		$vCadBuscar[$i]=trim($vCadBuscar[$i]);
		$largoCadena[$i]=strlen($vCadBuscar[$i]);
	}
	$contenidoResultado='';
	$largoContenido=strlen($contenido);

	for($i=0;$i<$largoContenido;$i++){
		
		$b=-1;
		for($j=0;isset($vCadBuscar[$j])==true;$j++){
			if(substr($contenido2,$i,$largoCadena[$j])==$vCadBuscar[$j]){
				$b=$j;
			}
		}
		if($b!=-1){
			$contenidoResultado.="<label $class $style>".substr($contenido,$i,$largoCadena[$b]).'</label>';
			$i=$i+$largoCadena[$b]-1;
		}else{
			$contenidoResultado.=$contenido[$i];
		}
	}
	
	
	return $contenidoResultado;
}

function agregar_style_a_palabra_en_texto($palabra,$texto,$style="font-weight:bold;", $class=""){
	$cadena2=$texto;
	if($palabra!=''){
		//$texto_minuscula=quitar_puntuaciones($texto);
		//$palabra_minuscula=quitar_puntuaciones($palabra);

		$largo_palabra=strlen($palabra);
		$largo_texto=strlen($texto);
		$cadena2='';
		if($largo_texto>=$largo_palabra){
			for($i=0;$i<=($largo_texto-$largo_palabra);$i++){
				if(substr($texto_minuscula,$i,$largo_palabra)==$palabra_minuscula){
					$aux_class='';
					if($class!=""){
						$aux_class="class='".$class."'";
					}
					$cadena2.="<b ".$aux_class." style='".$style."'>".substr($texto,$i,$largo_palabra).'</b>';
					$i=$i+$largo_palabra-1;
				}else{
					$cadena2.=$texto[$i];
				}
			}
			for($j=$i;$j<=$largo_texto;$j++){
				$cadena2.=$texto[$j];
			}
		}
	}
	return $cadena2;
}

function preparaNombreArchivo($texto){
	
	$texto=strtolower($texto);
	
	$i=0;

	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="a";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="e";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="i";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="o";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="u";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="a";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="a";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="e";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="e";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="i";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="i";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="o";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="o";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="u";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="u";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="n";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']="'";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']=chr(34);
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']="#";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']="&";
	$v[$i]['r']="y";
	//------------------------------------------
	$i++;
	$v[$i]['b']="!";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']="?";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']=",";
	$v[$i]['r']=" ";
	//------------------------------------------
	$i++;
	$v[$i]['b']="�";
	$v[$i]['r']="a";
	//------------------------------------------
	$i++;
	$v[$i]['b']=' ';
	$v[$i]['r']='-';
	//------------------------------------------
	
	for($j=1;isset($v[$j]['b'])==true;$j++){
		$texto=str_replace($v[$j]['b'],$v[$j]['r'],$texto);
	}
	
	$auxTexto='';
	$b=0;
	for($i=strlen($texto)-1;$i>=0;$i--){
		if($b==0){
			$auxTexto=$texto[$i].$auxTexto;
			if($texto[$i]=='.'){
				$b=1;
			}
		}else{
			if($texto[$i]!='.'){
				$auxTexto=$texto[$i].$auxTexto;
			}
		}
	}
	$texto=$auxTexto;
	$texto=date('YmdHis').'_'.$texto;
	return $texto;
}

function devolverConSeparadores($matriz){
	$separadorAsignacion = '#->#';
	$separadorCampo = '#*#'.chr(13).chr(10);
	$cadena='';
	foreach($matriz as $clave=>$valor){
		$cadena.=$clave.$separadorAsignacion.$valor.$separadorCampo;
	}
	echo($cadena);
}

function valorChar($caracter){
	for($i=0;$i<=254;$i++){
		if($caracter==chr($i)){
			return $i;
		}
	}
}

function siguienteValorCadenaNumerica($valorInicial,$parametro=1){
	if($valorInicial==''){
		$valorSiguiente=siguienteValorCadenaNumerica('000000',$parametro);
	}else{
		$c=0;
		for($i=strlen($valorInicial)-1;$i>=0;$i--){
			if($valorInicial[$i]=='0' || $valorInicial[$i]=='1' || $valorInicial[$i]=='2' || $valorInicial[$i]=='3' || $valorInicial[$i]=='4' || $valorInicial[$i]=='5' || $valorInicial[$i]=='6' || $valorInicial[$i]=='7' || $valorInicial[$i]=='8' || $valorInicial[$i]=='9'){
				$c++;
			}else{
				$i=0;	
			}
		}
		$valorNumericoSig=substr($valorInicial,strlen($valorInicial)-$c)+$parametro;
		while(strlen(substr($valorInicial,strlen($valorInicial)-$c))!=strlen($valorNumericoSig)){
			$valorNumericoSig='0'.$valorNumericoSig;
		}
		$valorSiguiente=substr($valorInicial,0,strlen($valorInicial)-$c).$valorNumericoSig;
	}
	return $valorSiguiente;
}

function generarLoremIpsum($min,$max){
	$ref='there are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc';
	$n1=rand(0,strlen($ref));
	$ref2=$ref.' '.$ref.' '.$ref;
	for($i=$n1;$ref2[$i]!=' ';$i++){}
	$inicio=$i+1;
	return substr($ref2,$inicio,rand($min,$max));
}

function textoRegular($cadena){
	$cadena=strtolower($cadena);
	$cadenaResul='';
	$b=0;
	for($i=0;$i<strlen($cadena);$i++){
		if($cadena[$i]!=' ' && $b==0){
			$cadenaResul.=strtoupper($cadena[$i]);
			$b=1;
		}else{
			$cadenaResul.=$cadena[$i];
		}
		if($cadena[$i]==' ' || $cadena[$i]=='.' || $cadena[$i]==chr(13) || $cadena[$i]==chr(10)){
			$b=0;
		}
	}
	
	$vReemplazar=explode(',','De,Y,O,U,A,E,El,La,Las,Los,En,Por');
	
	for($i=0;isset($vReemplazar[$i])==true;$i++){
		$cadenaResul=str_replace(' '.$vReemplazar[$i].' ',' '.strtolower($vReemplazar[$i]).' ',$cadenaResul);
	}
	return $cadenaResul;
}

function limitarCadena($cadena, $limite=45, $label=true) {
	if($limite<0){
		$texto = (strlen($cadena) > $limite*-1) ? '...'.substr($cadena,$limite) : $cadena;		
	}else{
		$texto = (strlen($cadena) > $limite) ? substr($cadena,0,$limite).'...' : $cadena;		
	}

	if($label==true && $texto!=$cadena){
		$texto='<label title="'.$cadena.'">'.$texto.'</label>';
	}

	return $texto;
}

function singular($cadena){
	$texto = explode(chr(32),trim($cadena));
	$excepciones = array('seis');
	
	for($j=0,$l=0;$j<count($texto);$j++,$l++){
		$pos = strpos($texto[$j], chr(95));
		if($pos!==false){
			$palabra_guion = explode(chr(95),$texto[$j]);
			for($k=0;$k<count($palabra_guion);$k++){
				$palabra[$l] = $palabra_guion[$k];

				if($k==0){
					$guion[$l]=chr(32);
				}else{
					$guion[$l]=chr(95);
				}
				
				if($k<count($palabra_guion)-1){
					$l++;
				}
			}
		}else{
			$palabra[$l] = $texto[$j];
			$guion[$l]=false;
		}
	}
	
	$expcecion = array_intersect(array_map('strtolower',$palabra),array_map('strtolower',$excepciones));
	
	for($i=0;$i<count($palabra);$i++){
		$extraerPlural = substr(strtolower($palabra[$i]),-2);
		
		if($i>0){ 
			if($guion[$i]===false){
				$singular .= chr(32);
			}else{
				$singular .= $guion[$i];
			}
		}
		
		if(strtolower($palabra[$i]) == $expcecion[$i]){
			$singular .= $palabra[$i];
		}else{
			if($extraerPlural=='es' && preg_match('/[aeiou]/i',substr($palabra[$i],-4,1)) && preg_match('/[bdlrst]/i',substr($palabra[$i],-3,1))){
				$singular .= substr($palabra[$i],0,-2);
			}elseif($extraerPlural=='es' && ((preg_match('/[bgl]/i',substr($palabra[$i],-4,1)) && preg_match('/[lr]/i',substr($palabra[$i],-3,1))) || preg_match('/[bdlrst]/i',substr($palabra[$i],-3,1)))){
				$singular .= substr($palabra[$i],0,-1);
			}elseif(substr($palabra[$i],-3)=='ces'){
				$singular .= substr($palabra[$i],0,-3).'z';
			}elseif($extraerPlural=='es'){
				$singular .= substr($palabra[$i],0,-2);
			}elseif(substr($extraerPlural,0)!='e' && substr($extraerPlural,1)=='s'){
				$singular .= substr($palabra[$i],0,-1);
			}else{
				$singular .= $palabra[$i];
			}
		}
	}
	
	return $singular;
}