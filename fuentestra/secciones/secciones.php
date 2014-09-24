<?

if($tra['id_usuario']!=''){
	
	$db->set_query("delete from sesion_pgsql where id_sesion_pgsql=pg_backend_pid();");
	$db->execute_query();
	
	if($_SESSION['visita_navegador']==''){
		$_SESSION['visita_navegador']=$_SERVER['HTTP_USER_AGENT'];
	}
	
	if($_SESSION['visita_ip']==''){
		if (getenv("HTTP_X_FORWARDED_FOR")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
			$client = gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']);
		}else{
			$ip = getenv("REMOTE_ADDR");
			$client = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		}
		$str = preg_split("/\./", $client);
		$i = count($str);
		$x = $i - 1;
		$n = $i - 2;
		$isp = $str[$n] . "." . $str[$x];
		$_SESSION['visita_ip']=$ip;
		$_SESSION['visita_isp']=$isp;
	}

	$sql="insert into sesion_pgsql (id_sesion_pgsql,id_usuario,ip) values (pg_backend_pid(),".$tra['id_usuario'].",'".$_SESSION['visita_ip']."');";
	$db->set_query($sql);
	$db->execute_query();
}

//-- ini cargar vectos usuarios ----------------------------------
 // $sql="select id_usuario, usuario, nombre, correo from usuarios where id_sistema=".$tra['id_sistema'];
  $sql="select id_usuario, usuario, nombre, correo from usuarios";
  $db->set_query($sql);
  $db->execute_query();
  while($row=$db->get_array()){
    $vUsuarios[$row['id_usuario']]['usuario']=$row['usuario'];
    $vUsuarios[$row['id_usuario']]['nombre']=$row['nombre'];
    $vUsuarios[$row['id_usuario']]['correo']=$row['correo'];
  }
//-- fin cargar vectos usuarios ----------------------------------
//-- ini cargar permisos habilitados ----------------------------

//-- fin cargar permisos habilitados ----------------------------

$accionRPC=recibir_dato('accionRPC','request');
$seccion=recibir_dato('seccion');
if(isset($_REQUEST['folder'])==true){
	$accionRPC='subirArchivo';
	$seccion='archivos';
}
$permisosTxt='';
if(file_exists('secciones/'.$seccion.'/permisos.txt')==true){
	$permisosTxt=leer_codigo_de_archivo('secciones/'.$seccion.'/permisos.txt');
}elseif(file_exists('fuentestra/secciones/'.$seccion.'/permisos.txt')==true){
	$permisosTxt=leer_codigo_de_archivo('fuentestra/secciones/'.$seccion.'/permisos.txt');
}

if($permisosTxt!=''){
	
	$permisosTxt=str_replace(chr(13),'',$permisosTxt);
	$vPermisosTxt=explode(chr(10),$permisosTxt);

	for($i=0;isset($vPermisosTxt[$i])==true;$i++){
		list($detalle,$permiso)=explode('#',$vPermisosTxt[$i]);
		//$sql="select permiso from permisos where id_sistema=".$tra['id_sistema']." and permiso='$permiso'";
		$sql="select permiso from permisos where permiso='$permiso'";
		$db->set_query($sql);
		$db->execute_query();
		if(!($row=$db->get_array())){
			$sql="insert into permisos (permiso, detalle) values ('$permiso', '".utf8_encode($detalle)."')";
			$db->set_query($sql);
			$db->execute_query();
			$sql="insert into usuario_permisos (id_usuario, permiso) values (1, '$permiso')";
			$db->set_query($sql);
			$db->execute_query();
		}
	}
}
if(file_exists('funciones/funciones.php')==true){
	include 'funciones/funciones.php';
}

if(file_exists('funciones/extends-fpdf.php')==true){
	include 'funciones/extends-fpdf.php';
}

if(file_exists('secciones/'.$seccion.'/funciones.php')==true){
	include 'secciones/'.$seccion.'/funciones.php';
}elseif(file_exists('fuentestra/secciones/'.$seccion.'/funciones.php')==true){
	include 'fuentestra/secciones/'.$seccion.'/funciones.php';
}

$resp['html']='';
if($accionRPC!=''){  // consulta al archivo rpc
	
	if($guardarEnDebugOperaciones==1){
		if($accionRPC!='actualizarHorarioDeSistema'){
			debug('operacion','RPC',$seccion.'/'.$accionRPC);
		}else{
			debug('operacion HORA','RPC',$seccion.'/'.$accionRPC);	
		}
	}
	
	//registrarVisita($seccion,'rpc',$accionRPC);
	
	$resp['seccion']=$seccion;
	$resp['accionRPC']=$accionRPC;
	$resp['accionSiguiente']=recibir_dato('accionSiguiente','post');

	$resp['contenedor']=recibir_dato('contenedor'); // recibir valor del contenedor de listados
	
	$cadenaBuscar=recibir_dato('cadenaBuscar'); // recibir valor para precarga de filtro
	$accionPosSeleccionar = recibir_dato('accionPosSeleccionar'); // recibe valor para indicar la accion posSeleccionar en el pin
	$cantElementosExistentes=recibir_dato('cantElementosExistentes','request',0); // cantidad de elemntos ya cargados en la lista
	$orderBy=recibir_dato('orderBy'); //recibe el valor para el order by del listado
	if($orderBy=='undefined'){$orderBy='';}
	$cantElementosNuevos=recibir_dato('cantElementosNuevos','request',10); //precarga de cantidad de valores nuevos en cada consulta a la lista
	if($cantElementosNuevos=='undefined'){$cantElementosNuevos=10;}
	if($cantElementosNuevos==''){$cantElementosNuevos=1000;}

	$b=0;
	if(file_exists('secciones/'.$seccion.'/'.$seccion.'-rpc.php')==true){
		include 'secciones/'.$seccion.'/'.$seccion.'-rpc.php';$b=1;
	}elseif(file_exists('fuentestra/secciones/'.$seccion.'/'.$seccion.'-rpc.php')==true){
		include 'fuentestra/secciones/'.$seccion.'/'.$seccion.'-rpc.php';$b=1;
	}
	if(file_exists('secciones/'.$seccion.'/rpc/'.$accionRPC.'.php')==true){
		include 'secciones/'.$seccion.'/rpc/'.$accionRPC.'.php';$b=1;
	}elseif(file_exists('fuentestra/secciones/'.$seccion.'/rpc/'.$accionRPC.'.php')==true){
		include 'fuentestra/secciones/'.$seccion.'/rpc/'.$accionRPC.'.php';$b=1;
	}
	if($b==0){
		$resp['mensaje']='no existe el archivo '.$seccion.'-rpc.php en la seccion '.$seccion;
	}
}else{
	
	$aplicacion=recibir_dato('aplicacion');
	$accion=recibir_dato('accion');
	$elementoDest=recibir_dato('elementoDest');
	$onLoad=recibir_dato('onLoad');
	$htmlDetectado='';
	$b=0;
	
	if($guardarEnDebugOperaciones==1){
		debug('operacion','SECCION',$seccion.'/'.$aplicacion);
	}
	
	//registrarVisita($seccion,$aplicacion);

	$onLoad=utf8_decode($onLoad);
	
	if($aplicacion==''){
		$aplicacion=$seccion;
	}
	if(file_exists('estilos/estilos.css')==true){
		$onLoad.="agregarEstiloCss('estilos/estilos.css');";
	}else if(file_exists('fuentestra/estilos/estilos.css')==true){
		$onLoad.="agregarEstiloCss('fuentestra/estilos/estilos.css');";
	}
	if(file_exists('secciones/'.$seccion.'/'.$seccion.'.css')==true){
		$onLoad.="agregarEstiloCss('secciones/".$seccion."/".$seccion.".css');";$b=1;
	}else if(file_exists('fuentestra/secciones/'.$seccion.'/'.$seccion.'.css')==true){
		$onLoad.="agregarEstiloCss('fuentestra/secciones/".$seccion."/".$seccion.".css');";$b=1;
	}
	if(file_exists('secciones/'.$seccion.'/'.$aplicacion.'.html')==true){
		$htmlDetectado='local';
		$resp['html']=leer_codigo_de_archivo('secciones/'.$seccion.'/'.$aplicacion.'.html');$b=1;
	}else if(file_exists('fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.html')==true){
		$htmlDetectado='global';
		$resp['html']=leer_codigo_de_archivo('fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.html');$b=1;	
	}

	//-- recibe valores correspondientes a listados ---
	$cadenaBuscar=recibir_dato('cadenaBuscar'); // recibir valor para precarga de filtro
	$cadenaBuscarAnt=recibir_dato('cadenaBuscarAnt'); // recibir valor del filtro actual
	$accionPosSeleccionar = recibir_dato('accionPosSeleccionar'); // recibe valor para indicar la accion posSeleccionar en el pin

	//-- agrega elemento input AccionPosSeleccionar ----
	$auxPosCadenaBuscar=strpos($resp['html'],'CadenaBuscar"');
	if($auxPosCadenaBuscar>0){
		$aux2PosCadenaBuscar=strrpos($resp['html'],'"',(strlen($resp['html'])-($auxPosCadenaBuscar+11))*-1);
		if($aux2PosCadenaBuscar>0){
			$aux3ElementoCadenaBuscar=substr($resp['html'],$aux2PosCadenaBuscar+1,$auxPosCadenaBuscar-$aux2PosCadenaBuscar-1);
			if(strpos($resp['html'],'id="'.$aux3ElementoCadenaBuscar.'"')==true && strpos($resp['html'],'id="'.$aux3ElementoCadenaBuscar.'AccionPosSeleccionar"')==false){
				$resp['html'].='<input type="hidden" id="'.$aux3ElementoCadenaBuscar.'AccionPosSeleccionar" value="'.$accionPosSeleccionar.'" />';
			}			
		}
	}
	
	if(file_exists('secciones/'.$seccion.'/'.$aplicacion.'.php')==true){
		include 'secciones/'.$seccion.'/'.$aplicacion.'.php';$b=1;
	}elseif(file_exists('fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.php')==true){
		include 'fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.php';$b=1;
	}
	

	
//-- ini reemplazar llave por variables ------------
	$auxRespHtml=$resp['html'];
	$b2=1;
	unset($vElementosLlaves);
	$cElementosLlaves=0;
	while($b2==1){
		$auxRespHtml=' '.$auxRespHtml;
		$iniElemento=strpos($auxRespHtml,'{');
		if($iniElemento==0){
			$b2=0;
		}else{
			$elemento = strstr($auxRespHtml, '{');
			$elemento = strstr($elemento, '}', true);
			$finElemento=strlen($elemento);
			if($finElemento==0){
				$b2=0;
			}else{
				$elemento=substr($elemento,1);
				$cElementosLlaves++;
				$vElementosLlaves[$cElementosLlaves]=$elemento;
				$auxRespHtml=substr($auxRespHtml,$iniElemento+$finElemento+1);
			}
		}
	}
	$getVars=get_defined_vars();
	for($i=1;$i<=$cElementosLlaves;$i++){
		if(strpos($vElementosLlaves[$i],chr(13))===false && strpos($vElementosLlaves[$i],chr(10))===false){
			$resp['html']=str_replace('{'.$vElementosLlaves[$i].'}',$getVars[$vElementosLlaves[$i]],$resp['html']);
		}
	}
//-- fin reemplazar llave por variables ------------

//-- ini asignar valores a los input
	$html=$resp['html'];
	$html=str_replace('<INPUT','<input',$html);
	$html=str_replace('<input','#*#*#<input',$html);
	$b1=1;
	while($b1==1){
		unset($variablePHP);
		unset($valorVariablePHP);
		$auxInputType='';
		$auxInputValue='';
		$auxInputName='';
		$inputValueDefinido=0;
		$posIni=strpos(strtolower($html),'#*#*#<input');
		if($posIni==0){
			$b1=0;
		}else{
			$inputCompleto=substr($html,$posIni);
			$posFin=strpos(strtolower($inputCompleto),'>');		
			$inputCompleto=substr($inputCompleto,5,$posFin-4);
			$vPropiedadesInput=explode(' ',substr($inputCompleto,7));
			for($i=0;isset($vPropiedadesInput[$i])==true;$i++){
				if(substr(strtolower($vPropiedadesInput[$i]),0,5)=='type='){
					$auxInputType=substr($vPropiedadesInput[$i],5);
					$auxInputType=trim($auxInputType);
					$auxInputType=trim($auxInputType,'"');
					$auxInputType=trim($auxInputType,"'");
				}
				if(substr(strtolower($vPropiedadesInput[$i]),0,5)=='name='){
					$auxInputName=substr($vPropiedadesInput[$i],5);
					$auxInputName=trim($auxInputName);
					$auxInputName=trim($auxInputName,'"');
					$auxInputName=trim($auxInputName,"'");
					if(strpos($auxInputName,'_')>0){
						list($aux,$variablePHP_inputName)=explode('_',$auxInputName);
					}else{
						$variablePHP_inputName=$auxInputName;
					}
				}
				if(substr(strtolower($vPropiedadesInput[$i]),0,3)=='id='){
					$auxId=substr($vPropiedadesInput[$i],3);
					$auxId=trim($auxId);
					$auxId=trim($auxId,'"');
					$auxId=trim($auxId,"'");
					if(strpos($auxId,'_')>0){
						list($aux,$variablePHP)=explode('_',$auxId);
					}else{
						$variablePHP=$auxId;
					}
				}
				if(substr(strtolower($vPropiedadesInput[$i]),0,6)=='value='){
					$auxInputValue=substr($vPropiedadesInput[$i],6);
					$auxInputValue=trim($auxInputValue);
					$auxInputValue=trim($auxInputValue,'"');
					$auxInputValue=trim($auxInputValue,"'");
					$inputValueDefinido=1;
				}
			}
			
			$inputNuevoCompleto=$inputCompleto;
			
			if(($auxInputType=='text' || $auxInputType=='hidden') && $inputValueDefinido==0 && isset($variablePHP)==true){
				$gDefVars=get_defined_vars();
				if(isset($gDefVars[$variablePHP])==true){
					$valorVariablePHP=$gDefVars[$variablePHP];
					$inputNuevoCompleto=substr($inputCompleto,0,6).' value="'.$valorVariablePHP.'" '.substr($inputCompleto,7);
				}
			}
			
			if($auxInputType=='radio' && $auxInputName!='' && $inputValueDefinido==1){
				$gDefVars=get_defined_vars();
				if(isset($gDefVars[$variablePHP_inputName])==true){
					$valorVariablePHP=$gDefVars[$variablePHP_inputName];
					if($auxInputValue==$valorVariablePHP){
						$inputNuevoCompleto=substr($inputCompleto,0,6).' checked '.substr($inputCompleto,7);
					}
				}
			}
			
			if($auxInputType=='checkbox'){
				if($inputValueDefinido==0 && isset($variablePHP)==true){
					$gDefVars=get_defined_vars();
					if(isset($gDefVars[$variablePHP])==true){
						$valorVariablePHP=$gDefVars[$variablePHP];
						
						if($valorVariablePHP===true || $valorVariablePHP==='true' || $valorVariablePHP==='t' || $valorVariablePHP===1 || $valorVariablePHP==='1'){
							$inputNuevoCompleto=substr($inputCompleto,0,6).' checked '.substr($inputCompleto,7);
						}
					}
				}else if($auxInputName!=''){
					$gDefVars=get_defined_vars();
					if(isset($gDefVars[$variablePHP_inputName])==true){
						$valorVariablePHP=$gDefVars[$variablePHP_inputName];							
						if($inputValueDefinido==1){
							if(strpos(' '.$valorVariablePHP,',')>0){
								unset($auxValoresCheckbox);
								$auxValoresCheckbox=explode(',',$valorVariablePHP);
								for($ic=0;isset($auxValoresCheckbox[$ic])==true;$ic++){
									if($auxInputValue==$auxValoresCheckbox[$ic]){
										$inputNuevoCompleto=substr($inputCompleto,0,6).' checked '.substr($inputCompleto,7);
									}
								}
							}else{
								if($auxInputValue==$valorVariablePHP){
									$inputNuevoCompleto=substr($inputCompleto,0,6).' checked '.substr($inputCompleto,7);
								}
							}
						}else{
							if($valorVariablePHP===true || $valorVariablePHP==='true' || $valorVariablePHP==='t' || $valorVariablePHP===1 || $valorVariablePHP==='1'){
								$inputNuevoCompleto=substr($inputCompleto,0,6).' checked '.substr($inputCompleto,7);
							}
						}
					}					
				}
			}
			
			$html=str_replace('#*#*#'.$inputCompleto,$inputNuevoCompleto,$html);
		}
	}
	$resp['html']=$html;
//-- fin asignar valores a los input

//-- ini asignar selected en los options dentro de las etiquetas select
	$html=$resp['html'];
	$html=str_replace('<SELECT','<select',$html);
	$html=str_replace('<select','#*#*#<select',$html);

	$b1=1;
	while($b1==1){
		$posIni=strpos(strtolower($html),'#*#*#<select');
		if($posIni==0){
			$b1=0;
		}else{
			$auxHtml=substr($html,$posIni);
			$posFin=strpos(strtolower($auxHtml),'</select>');
			$auxHtml=substr($auxHtml,0,$posFin+9);
			
			$posPreFin=strpos(strtolower($auxHtml),'>');
			$etiquetaCabecera=substr($auxHtml,5,$posPreFin-4);
			$vParametros=explode(' ',substr($etiquetaCabecera,8));
			for($i=0;isset($vParametros[$i])==true;$i++){
				$vParametros[$i]=trim($vParametros[$i]);
				if($vParametros[$i]!='' && substr($vParametros[$i],0,3)=='id='){
					$idElemento=substr($vParametros[$i],3);
					$idElemento=trim($idElemento,'>');
					$idElemento=trim($idElemento,'"');
					$idElemento=trim($idElemento,"'");
				}
			}
			unset($vOptions);
			$cOptions=0;
			if($idElemento!=''){
				//-- obtener el valor del id
				if(strpos($idElemento,'_')>0){
					list($aux,$variablePHP)=explode('_',$idElemento);
				}else{
					$variablePHP=$idElemento;
				}

				$gDefVars=get_defined_vars();
				if(isset($gDefVars[$variablePHP])==true){
					$valorId=$gDefVars[$variablePHP];
				}else{
					$valorId='';
				}
				
				$htmlOptions=substr($auxHtml,strlen($etiquetaCabecera),strlen($auxHtml)-strlen($etiquetaCabecera)-9);
				
				$bExisteSelected=0;
				$b=1;
				while($b==1){
					$posIniOpt=strpos(strtolower(' '.$htmlOptions),'<option');
					if($posIniOpt>0){
						$auxHtmlOpt=substr($htmlOptions,$posIniOpt);
						$posFinOpt=strpos(strtolower($auxHtmlOpt),'</option>');
						if($posFinOpt>0){
							$auxHtmlUnOpt=substr($auxHtmlOpt,6,$posFinOpt-6);
							
							if(strpos(strtolower($auxHtmlUnOpt),'selected')>0){
								$auxHtmlUnOpt=str_replace('selected="selected"','',$auxHtmlUnOpt);
								$auxHtmlUnOpt=str_replace("selected='selected'",'',$auxHtmlUnOpt);
								$auxHtmlUnOpt=str_replace("selected=selected",'',$auxHtmlUnOpt);
								$auxHtmlUnOpt=str_replace("selected=''",'',$auxHtmlUnOpt);
								$auxHtmlUnOpt=str_replace('selected=""','',$auxHtmlUnOpt);
								$auxHtmlUnOpt=str_replace('selected','',$auxHtmlUnOpt);
								$bExisteSelected=1;
								$optionSelected=1;
							}else{
								$optionSelected=0;
							}
							
							list($optionValor,$optionDetalle)=explode('>',$auxHtmlUnOpt);
							$optionValor=trim($optionValor);
							$optionValor=str_replace('value=','',$optionValor);
							$optionValor=trim($optionValor,'"');
							$optionValor=trim($optionValor,"'");
							if($optionValor==''){
								$optionValor=$optionDetalle;
							}							
							$cOptions++;
							$vOptions[$cOptions]['valor']=$optionValor;
							$vOptions[$cOptions]['detalle']=$optionDetalle;
							$vOptions[$cOptions]['selected']=$optionSelected;
							
							$htmlOptions=substr($htmlOptions,$posIniOpt+$posFinOpt+9);
						}else{
							$b=0;
						}
					}else{
						$b=0;
					}
				}
				$htmlOptionNuevo=$etiquetaCabecera.chr(10);
				for($i=1;$i<=$cOptions;$i++){
					if($bExisteSelected==0){
						if($vOptions[$i]['valor']==$valorId){
							$auxSelected='selected';
						}else{
							$auxSelected='';
						}
					}else{
						if($vOptions[$i]['selected']==1){
							$auxSelected='selected';
						}else{
							$auxSelected='';
						}
					}
					$htmlOptionNuevo.='<option value="'.$vOptions[$i]['valor'].'" '.$auxSelected.'>'.$vOptions[$i]['detalle'].'</option>'.chr(10);
				}
				if(isset($definirOptions[$variablePHP]['options'])==true){
					$vOptionsDefinidosEnPhp=explode(',',$definirOptions[$variablePHP]['options']);
					for($i=0;isset($vOptionsDefinidosEnPhp[$i])==true;$i++){
						unset($auxValorOpt);
						unset($auxDetalleOpt);
						list($auxValorOpt,$auxDetalleOpt)=explode('=',$vOptionsDefinidosEnPhp[$i]);
						if(isset($auxDetalleOpt)==false){
							$auxDetalleOpt=$auxValorOpt;
						}
						$selected='';
						if($definirOptions[$variablePHP]['selected']!=''){
							if($definirOptions[$variablePHP]['selected']==$auxValorOpt){
								$selected='selected';
							}
						}else{
							if($auxValorOpt==$valorId){
								$selected='selected';
							}
						}
						$htmlOptionNuevo.='<option value="'.$auxValorOpt.'" '.$selected.' >'.$auxDetalleOpt.'</option>'.chr(10);
					}
				}
				$htmlOptionNuevo.='</select>';
				$html=substr($html,0,$posIni).$htmlOptionNuevo.substr($html,$posIni+$posFin+9);
			}
		}
	}
	$resp['html']=$html;
//-- fin asignar selected en los options dentro de las etiquetas select

	$resp['html']=str_replace('{cadenaBuscar}',$cadenaBuscar,$resp['html']); // reemplazar valor para precarga de filtro
	$resp['html']=str_replace('{cadenaBuscarAnt}',$cadenaBuscarAnt,$resp['html']); // reemplazar valor de filtro anterior
	$resp['html']=str_replace('{accionPosSeleccionar}',$accionPosSeleccionar,$resp['html']); // reemplaza valor de la accion posSeleccionar en el input id {alias_accionPosSeleccionar}
	
	$funcionJs='';
	if(file_exists('secciones/'.$seccion.'/'.$aplicacion.'.js')==true){
		$urlFuncion="secciones/".$seccion."/".$aplicacion.".js";$b=1;
		$funcionJs=leer_codigo_de_archivo('secciones/'.$seccion.'/'.$aplicacion.'.js');
	}else if(file_exists('fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.js')==true){
		$urlFuncion='fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.js';$b=1;
		$funcionJs=leer_codigo_de_archivo('fuentestra/secciones/'.$seccion.'/'.$aplicacion.'.js');
	}

	if($funcionJs!=''){
		if(substr_count($funcionJs, 'function inicializar_'.$seccion.'_'.$aplicacion.'()')==1){
			$onLoad.="agregarFuncionJs('".$urlFuncion."','inicializar_".$seccion."_".$aplicacion."();');";
		}else if(substr_count($funcionJs, 'function inicializar_'.$seccion.'()')==1){
			$onLoad.="agregarFuncionJs('".$urlFuncion."','inicializar_".$seccion."();');";
		}else{
			$onLoad.="agregarFuncionJs('".$urlFuncion."','');";
		}
	}
	if($b==1){
		$resp['mensaje']='ok';
	}else{
		$resp['mensaje']='no existe la aplicacion '.$aplicacion.' en la seccion '.$seccion;
	}

	if($htmlDetectado=='local'){
		$resp['html']=str_replace(' src="imagenes/',' src="secciones/'.$seccion.'/imagenes/',$resp['html']);
		$resp['html']=str_replace('url(imagenes/','url(secciones/'.$seccion.'/imagenes/',$resp['html']);
		$resp['html']=str_replace(' src="../../../fuentestra/',' src="fuentestra/',$resp['html']);
		$resp['html']=str_replace('url(../../../fuentestra/','url(fuentestra/',$resp['html']);
	}else if($htmlDetectado=='global'){
		$resp['html']=str_replace(' src="imagenes/',' src="fuentestra/secciones/'.$seccion.'/imagenes/',$resp['html']);
		$resp['html']=str_replace('url(imagenes/','url(fuentestra/secciones/'.$seccion.'/imagenes/',$resp['html']);	
		$resp['html']=str_replace(' src="../../imagenes/',' src="fuentestra/imagenes/',$resp['html']);
		$resp['html']=str_replace('url(../../imagenes/','url(fuentestra/imagenes/',$resp['html']);		
	}

	$onLoad.="initInputFecha();"; //-- asignar caracteristicas de formato y validacion de fecha para input class="inputFecha"
	$onLoad.="initInputHora();";
	//$onLoad.="initTipTip();";
	$onLoad.="initInputSeparadorMiles();";

	$resp['html']=str_replace('{dominio}',$tra['dominio'],$resp['html']);
	
	$onLoad=str_replace(chr(92)."'","'",$onLoad);
	$resp['elementoDest']=$elementoDest;
	$resp['onLoad']=$onLoad;
	
	$anchoContenedor=recibir_dato('anchoContenedor');
	if($anchoContenedor!=''){
		$resp['html']='<div style="width:'.$anchoContenedor.';">'.$resp['html'].'</div>';
	}
}

if($resp['mensajeBotones']!=''){
	$resp['mensajeBotones']=str_replace('&','(and)',$resp['mensajeBotones']);
}

$resp['permisosHabilitados']='';
if($_SESSION['login']=='si'){
	$resp['permisosHabilitados']='login';
}
if($tra['id_usuario']!=''){
  
  $sql="
  	select
  		permiso
  	from
  		usuario_permisos
  	where
  		id_usuario=".$tra['id_usuario']."
  ";
  
  $db->set_query($sql);
  $db->execute_query();
  $permisosHabilitados='';
  while($row=$db->get_array()){
  	if($resp['permisosHabilitados']!=''){$resp['permisosHabilitados'].=',';}
  	$resp['permisosHabilitados'].=$row['permiso'];
  	if($permisosHabilitados!=''){
  		$permisosHabilitados.=' and ';
  	}
  	$permisosHabilitados.=' permiso!=\''.$row['permiso'].'\' ';
  }
  if($permisosHabilitados!=''){
  	$permisosHabilitados=' and ('.$permisosHabilitados.') ';
  }
}

$resp['permisosNoHabilitados']='';
$resp['exigir_login']=$tra['exigir_login'];
if($_SESSION['login']!='si'){
	$resp['permisosNoHabilitados']='login';
	$resp['estado_login']='f';
}else{
	$resp['estado_login']='t';
}


$sql="
	select
		permiso
	from
		permisos
	where
		1=1 $permisosHabilitados
";

$db->set_query($sql);
$db->execute_query();
while($row=$db->get_array()){
	if($resp['permisosNoHabilitados']!=''){$resp['permisosNoHabilitados'].=',';}
	$resp['permisosNoHabilitados'].=$row['permiso'];
}

if($tra['id_usuario']!=''){
  $sql="update usuarios set fecha_ultima_accion=now() where id_usuario=".$tra['id_usuario'];
  
  $db->set_query($sql);
  $db->execute_query();
}

$sql="update usuarios set estado_login=false where fecha_ultima_accion < now()-interval '10 MINUTES' and estado_login=true";
$db->set_query($sql);
$db->execute_query();

traAjax($resp);

if($tra['id_usuario']!=''){
	$db->set_query("delete from sesion_pgsql where id_sesion_pgsql=pg_backend_pid();");
	$db->execute_query();
}
?>