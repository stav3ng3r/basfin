<?
function tra(){
	global $tra;
	$html=leer_codigo_de_archivo('fuentestra/esquema.html');
	$html=armarCabecera($html);
	if(($_SESSION['login']=='si')&&($_SESSION['idUsuario_'.$tra['alias']]!='')){
		$displayAdmin='';
	}else{
		$displayAdmin='display:none;';
	}
	$html=str_replace('{displayAdmin}',$displayAdmin,$html);

	$accionJsEnlaceDirecto='';
	if(recibir_dato('accionJsEnlaceDirecto')!=''){
		list($seccion,$aplicacion,$parametros,$elementoDest)=explode(',',recibir_dato('accionJsEnlaceDirecto'));
		$accionJsEnlaceDirecto="cargarSeccion('$seccion','$aplicacion','$parametros','$elementoDest');";
	}
	$html=str_replace('{accionJsEnlaceDirecto}',$accionJsEnlaceDirecto,$html);
  
  if(is_file('cargando-sistema.html')==true){
    $htmlCargandoSistema=leer_codigo_de_archivo('cargando-sistema.html');
  }else{
    $htmlCargandoSistema=leer_codigo_de_archivo('fuentestra/cargando-sistema.html');
  }
	$html=str_replace('<div id="cuerpo"></div>','<div id="cuerpo">'.$htmlCargandoSistema.'</div>',$html);
    
	echo($html);
}

function traAjax($matriz){
	global $tra;
	devolverConSeparadores($matriz);
}

function armarCabecera($html){
	global $tra;
	$html=str_replace('{title}',$tra['titulo'],$html);
	$html=str_replace('{palabras clave}',$tra['palabras clave'],$html);
	$html=str_replace('{descripcion}',$tra['descripcion'],$html);
	if(file_exists('favicon.ico')==true){
		$htmlFavicon='<link rel="shortcut icon" href="favicon.ico?a='.$tra['id_sistema'].'"/>';
		$html=str_replace('</title>','</title>'.chr(13).$htmlFavicon.chr(13),$html);
	}
	return $html;
}

function leerHtmlEnSeccion($nombreArchivo){
	$seccion=recibir_dato('seccion');
	$html = '';
	$b=0;
	if(file_exists('secciones/'.$seccion.'/'.$nombreArchivo.'.html')==true){
		$html=leer_codigo_de_archivo('secciones/'.$seccion.'/'.$nombreArchivo.'.html');$b=1;

		$html=str_replace(' src="imagenes/',' src="secciones/'.$seccion.'/imagenes/',$html);
		$html=str_replace('url(imagenes/','url(secciones/'.$seccion.'/imagenes/',$html);
		$html=str_replace(' src="../../../fuentestra/',' src="fuentestra/',$html);

	}else if(file_exists('fuentestra/secciones/'.$seccion.'/'.$nombreArchivo.'.html')==true){
		$html=leer_codigo_de_archivo('fuentestra/secciones/'.$seccion.'/'.$nombreArchivo.'.html');$b=1;	

		$html=str_replace(' src="imagenes/',' src="fuentestra/secciones/'.$seccion.'/imagenes/',$html);
		$html=str_replace('url(imagenes/','url(fuentestra/secciones/'.$seccion.'/imagenes/',$html);	
		$html=str_replace(' src="../../imagenes/',' src="fuentestra/imagenes/',$html);
	}
	if($b==0){
		$html='No existe el archivo '.$nombreArchivo.'.html';
	}
	
	return $html;
}

function esArchivo($ruta){
	return file_exists($ruta);
}

function obtenerSigId($esquemaTabla,$campo=''){
	global $db5, $tra;
	
	list($esquema,$tabla)=explode('.',$esquemaTabla);
	if($tabla==''){
		$tabla=$esquema;
	}
	
	if($campo==''){
		$campo='id_'.substr($tabla,0,strlen($tabla)-1);
	}
	
	/*$sql5="select $campo from $esquemaTabla where id_sistema=".$tra['id_sistema']." order by $campo desc limit 1";*/
	
	$sql5="select $campo from $esquemaTabla order by $campo desc limit 1";
	$db5->set_query($sql5);
	$db5->execute_query();
	if($row5=$db5->get_array()){
		$idSig=$row5[$campo]+1;
	}else{
		$idSig=1;
	}
	return $idSig;	


}

function armarLista($matriz,$auxCantElementosExistentes='x',$auxCantElementosNuevos='x'){
	global $resp, $seccion, $accionRPC, $cantElementosExistentes, $cantElementosNuevos, $accionPosSeleccionar, $cadenaBuscar, $orderBy;

	if($auxCantElementosExistentes!='x'){
		$cantElementosExistentes=$auxCantElementosExistentes;
	}
	if($auxCantElementosNuevos!='x'){
		$cantElementosNuevos=$auxCantElementosNuevos;
	}

	$contenedor=$resp['contenedor'];

	$html='';
	if($cantElementosExistentes==0){
		$html.='<table class="table table-curved table-hover table-responsive">'.chr(13);
		$iniciar=0;
	}else{
		$iniciar=1;
	}
	$j=-1;
	for($i=$iniciar;isset($matriz[$i][0]['html'])==true;$i++){
		
		if(isset($matriz[$i]['title'])==false){$matriz[$i]['title']='';}
		if(isset($matriz[$i]['width'])==false){$matriz[$i]['width']='';}
		if(isset($matriz[$i]['style'])==false){$matriz[$i]['style']='';}
		if(isset($matriz[$i]['colspan'])==false){$matriz[$i]['colspan']='';}
		if(isset($matriz[$i]['estado'])==false){$matriz[$i]['estado']='';}
		
		/*
		if($i==0){
			$html.='<tr class="cab">'.chr(13);
		}else{
			$html.='<tr>'.chr(13);			
		}
		*/
		
		if($i==0){
			$html.='<thead>'.chr(13);
		}
		
		if(isset($matriz[$i]['id'])==true){
			$html.='<tr data-id="'.$matriz[$i]['id'].'">'.chr(13);
		}else{
			$html.='<tr>'.chr(13);
		}
		
		
		for($j=0;isset($matriz[$i][$j]['html'])==true;$j++){
			
			if(isset($matriz[$i][$j]['title'])==false){$matriz[$i][$j]['title']='';}
			if(isset($matriz[$i][$j]['width'])==false){$matriz[$i][$j]['width']='';}
			if(isset($matriz[$i][$j]['style'])==false){$matriz[$i][$j]['style']='';}
			if(isset($matriz[$i][$j]['colspan'])==false){$matriz[$i][$j]['colspan']='';}
			if(isset($matriz[$i][$j]['estado'])==false){$matriz[$i][$j]['estado']='';}
			
			if($i==0){
				if($matriz[$i][$j]['title']!=''){$title='title="'.$matriz[$i][$j]['title'].'"';}else{$title='';}
				$bTd=0;
				if(isset($matriz[0][$j]['permiso'])==true){
					if(poseePermiso($matriz[0][$j]['permiso'])==true){
						$bTd=1;
					}else{
						$bTd=0;
					}
				}else{
					$bTd=1;
				}

				if($bTd==1 && $j==0){
					if(isset($matriz[1][0]['html'])==true){
						if(substr_count($matriz[1][0]['html'],'seleccionarDeListado(')==1 && $accionPosSeleccionar==''){
							$bTd=0;
						}
					}
				}
				
				if(substr($matriz[$i][$j]['html'],strlen($matriz[$i][$j]['html'])-1,1)=='*'){
					$posResaltar[$j]=1;
					$matriz[$i][$j]['html']=substr($matriz[$i][$j]['html'],0,strlen($matriz[$i][$j]['html'])-1);
				}
				if($bTd==1){
					if(isset($matriz[$i][$j]['orderBy'])==true){
						$auxOrderby=' ';
						
						if(str_replace('desc','asc',$orderBy)==$matriz[$i][$j]['orderBy'].' asc'){
							if($orderBy==$matriz[$i][$j]['orderBy'].' asc'){
								$auxOrderby.='<a href="javascript:rpcSeccion(\''.$seccion.'\',\''.$accionRPC.'\',\'orderBy='.$matriz[$i][$j]['orderBy'].' desc\',\'id:'.$contenedor.'\');">&#9650;</a>';
							}else{
								$auxOrderby.='<a href="javascript:rpcSeccion(\''.$seccion.'\',\''.$accionRPC.'\',\'orderBy='.$matriz[$i][$j]['orderBy'].' asc\',\'id:'.$contenedor.'\');">&#9660;</a>';
							}
						}else{
							$auxOrderby.='<a href="javascript:rpcSeccion(\''.$seccion.'\',\''.$accionRPC.'\',\'orderBy='.$matriz[$i][$j]['orderBy'].' asc\',\'id:'.$contenedor.'\');">&and;</a>';
						}
					}else{
						$auxOrderby='';
					}
					$html.='<th width="'.$matriz[$i][$j]['width'].'" '.$title.' >'.$matriz[$i][$j]['html'].$auxOrderby.'</th>'.chr(13);
				}
			}else{
				if(isset($posResaltar[$j])==false){
					if(substr($matriz[0][$j]['html'],strlen($matriz[0][$j]['html'])-1,1)=='*'){
						$posResaltar[$j]=1;
					}else{
						$posResaltar[$j]=0;	
					}
				}
				
				$style='';
				if($matriz[0][$j]['style']!=''){
					$style.=$matriz[0][$j]['style'];
				}
				if($matriz[$i]['style']!=''){
					$style.=$matriz[$i]['style'];
				}
				if($matriz[$i][$j]['style']!=''){
					$style.=$matriz[$i][$j]['style'];
				}
				if(($matriz[$i]['estado']=='f')||($matriz[$i][$j]['estado']=='false')||($matriz[$i][$j]['estado']=='0')){
					$style.='text-decoration:line-through;color:#666;';
				}
				if($style!=''){
					$style='style="'.$style.'"';
				}
				
				if($matriz[$i][$j]['title']!=''){$title='title="'.$matriz[$i][$j]['title'].'"';}else{$title='';}
				
				$bColspan=0;
				$auxColspan='';
				if(isset($matriz[$i][$j]['colspan'])==true){
					if($matriz[$i][$j]['colspan']!=''){
						$bColspan=1;
						$auxColspan='colspan="'.$matriz[$i][$j]['colspan'].'"';
					}
				}
				$bTd=0;
				if(isset($matriz[0][$j]['permiso'])==true){
					if(poseePermiso($matriz[0][$j]['permiso'])==true){
						$bTd=1;
					}else{
						$bTd=0;
					}
				}else{
					$bTd=1;
				}
				if($bTd==1 && $j==0){
					if(isset($matriz[1][0]['html'])==true){
						if(substr_count($matriz[1][0]['html'],'seleccionarDeListado(')==1 && $accionPosSeleccionar==''){
							$bTd=0;
						}
					}
				}
				if($bTd==1){
					if($cadenaBuscar!='' && $posResaltar[$j]==1){
						$matriz[$i][$j]['html']=resaltarCadena($cadenaBuscar,$matriz[$i][$j]['html']);
					}
					if(isset($matriz[0][$j]['data'])==true){
						$atribData='data-name="'.$matriz[0][$j]['data'].'"';
					}else{
						$atribData='';	
					}
					
					$html.='<td '.$atribData.' '.$style.' '.$title.' '.$auxColspan.' >'.$matriz[$i][$j]['html'].'</td>'.chr(13);
				}
				if($bColspan==1){
					$j=$j+$matriz[$i][$j]['colspan']-1;
				}
			}
		}
		$html.='</tr>'.chr(13);

		if($i==0){
			$html.='</thead>'.chr(13);
			$html.='<tbody>'.chr(13);
		}		
	}
	if($j!=-1){
		$html.='<tr class="inf"><td colspan="'.$j.'"><i><label id="cantResultados">'.($cantElementosExistentes+$i-1).'</label> registros en la lista</i></td></tr>'.chr(13);
		if(($cantElementosNuevos!='')&&(($i-1)==$cantElementosNuevos)){
			$html.='
				<tr class="cargandoMasRegistros" style="display:none;">
					<td colspan="'.$j.'" align="center">
						<span class="glyphicon glyphicon-refresh spin"></span> agregando más elementos a la lista
					</td>
				</tr>
			'.chr(13);
			$html.='
				<tr class="verMasRegistros">
					<td colspan="'.$j.'" align="center">
						<form action="javascript:rpcSeccion(\''.$seccion.'\',\''.$accionRPC.'\',\'masFilas=true\',\'id:'.$contenedor.'\');">
							<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-plus"></span> Resultados</button>
							<div style="position:relative;">
								<div style="position:absolute; top:-25px; right:5px;"><a href="javascript:mostrarOcultar(\''.$contenedor.'CantResulNuevos\');"><span class="glyphicon glyphicon-cog"></span></a></div>
								<div id="'.$contenedor.'CantResulNuevos" style="position:absolute; top:-30px; right:30px; display:none;">mostrar de a <input type="text" id="'.$contenedor.'CantElementosNuevos" value="'.$cantElementosNuevos.'" style="width:30px; text-align:center;" /> resultados nuevos</div>
							</div>
						</form>
					</td>
				</tr>
			'.chr(13);
		}
		$resp['cantFilas']=$cantElementosExistentes+$i-1;
	}
	
	if($cantElementosExistentes==0){
		$html.='</tbody>'.chr(13);	
		$html.='</table>';
		$html.='
			<input type="hidden" id="'.$contenedor.'CantFilas" value="'.($i-1).'">
			<input type="hidden" id="'.$contenedor.'OrderBy" value="'.$orderBy.'">
		'.chr(13);
	}
	
	return $html;
}

function debug($proceso,$bandera,$resultado='',$capa='php'){
	global $tra, $db;
	
	if($tra['id_usuario']==''){
		$auxIdUsuario=0;
	}else{
		$auxIdUsuario=$tra['id_usuario'];
	}
	
	$sql="
		insert into debug(
			id_usuario,
			proceso,
			bandera,
			resultado,
			capa
		) values (
			$auxIdUsuario,
			'$proceso',
			'$bandera',
			$$$resultado$$,
			'$capa'
		)
	";
	$db->set_query($sql);
	$db->execute_query();
	
	/*
	$fp = fopen('fuentestra/debug.dat', 'a');
	fwrite($fp, $tra['id_usuario'].'-'.microtime().'->'.$cadena.chr(10));
	fclose($fp);
	*/
}



function infoAuditoria($tabla,$rowid=null,$accion=null){
	$accion = !empty($accion) ? '&accion='.$accion : null;
	$info = !empty($accion)?'info_red':'info';
	$html='<a href="javascript:cargarSeccion(\'auditoria\',\'auditoria_lista\',\'tabla='.$tabla.'&rowid='.$rowid.$accion.'\',\'ventana\');"><span title="Mostrar información de auditoría de usuarios" class="glyphicon glyphicon-info-sign"></span></a>';
	return $html;
}

function infoReg($row){
  global $tra, $vUsuarios;
  
  $idUsuarioCreo=$row['id_usuario_creo'];
  $fechaUsuarioCreo=$row['fecha_usuario_creo'];
  $idUsuarioModif=$row['id_usuario_modif'];
  $fechaUsuarioModif=$row['fecha_usuario_modif'];
  
  $html='';
  $title='';
  if($idUsuarioCreo!=''){
    $title.='Creado por el usuario '.$vUsuarios[$idUsuarioCreo]['usuario'];
    if($fechaUsuarioCreo!=''){
      $title.=' ('.formatear_fecha($fechaUsuarioCreo,'D, d/m/Y H:i').')';  
    }
  }
  if($idUsuarioModif!=''){
    if($fechaUsuarioModif!=$fechaUsuarioCreo){
      if($title!=''){$title.=' y ';}
      $title.='Modificado por el usuario '.$vUsuarios[$idUsuarioModif]['usuario'];
      if($fechaUsuarioModif!=''){
        $title.=' ('.formatear_fecha($fechaUsuarioModif,'D, d/m/Y H:i').')';  
      }
    }
  }
  if($title!=''){
    $html='<img src="fuentestra/imagenes/bot/16x16/info.png" title="'.$title.'" />';  
  }
  return $html;
}

function registrarVisita($seccion,$aplicacion='',$parametros='',$observacion=''){
	
	global $db5, $tra;

	$observacion=utf8_encode($observacion);

	if($_SESSION['visita_identificadorSesion']==''){
		$sql5 = "select identificador_sesion from visitas order by identificador_sesion desc limit 1";
		$db5->set_query($sql5);
		$db5->execute_query();
		if($row5 = $db5->get_array()){
			$_SESSION['visita_identificadorSesion']=$row5['identificador_sesion']+1;
		}else{
			$_SESSION['visita_identificadorSesion']=1;
		}
	}

	if($_SESSION['logmulti']=='si'){
		$log='true';
		$idMiembro=$_SESSION['id_miembro'];
	}else{
		$log='false';
		$idMiembro='null';
	}
	
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
	
	if($tra['id_usuario']==''){
		$idUsuario='null';
	}else{
		$idUsuario=$tra['id_usuario'];
	}

	/*
	$sql5 = "
		insert into visitas (
			id_sistema,
			id_visita,
			identificador_sesion,
			id_usuario,
			seccion,
			aplicacion,
			parametros,
			observacion,
			ip,
			origen,
			navegador,
			isp,
			fecha_hora
		)values(
			".$tra['id_sistema'].",
			".obtenerSigId('visitas').",
			".$_SESSION['visita_identificadorSesion'].",
			$idUsuario,
			'$seccion',
			'$aplicacion',
			'$parametros',
			'$observacion',
			'".$_SESSION['visita_ip']."',
			'".$_SERVER['HTTP_REFERER']."',
			'".$_SESSION['visita_navegador']."',
			'".$_SESSION['visita_isp']."',
			now()
		)
	";

	$db5->set_query($sql5);
	$db5->execute_query();
	*/
}
function urlPDF($parametros='',$aplicacion='',$seccion=''){
	
	if($seccion==''){
		$seccion=recibir_dato('seccion');
	}
	if($aplicacion==''){
		$aplicacion=recibir_dato('aplicacion');
	}
	if($aplicacion==''){
		$aplicacion=$seccion;
	}
	$cadenaURL='index.php?o=pdf&s='.$seccion.'&a='.$aplicacion;
	if($parametros!=''){
		$cadenaURL.='&'.$parametros;
	}
	$cadenaURL.='&cache='.rand(1000,9999);
	return $cadenaURL;
}
function generarPDF($seccion,$aplicacion,$parametros,$destPdf){
	global $db, $db2, $db3, $db4, $db5, $tra, $vUsuarios;
	
	if($parametros!=''){
		$vAux1=explode('&',$parametros);
		for($i=0;isset($vAux1[$i])==true;$i++){
			$vAux2=explode('=',$vAux1[$i]);
			$vParametrosPDF[$vAux2[0]]=$vAux2[1];
		}
	}
	$nombreArchivoPdf='';
	
	//if(file_exists('secciones/'.$seccion.'/'.$aplicacion.'_'.valorCampoConfig('alias').'-pdf.php')==true){
	//	include 'secciones/'.$seccion.'/'.$aplicacion.'_'.valorCampoConfig('alias').'-pdf.php';
	//}else{
		include 'secciones/'.$seccion.'/'.$aplicacion.'-pdf.php';
	//}
	
	if($destPdf=='mostrar' || $destPdf==''){
		$pdf->SetDisplayMode('fullwidth','single');
		$pdf->Output($nombreArchivoPdf,'I');
		return 1;
	}else if($destPdf=='guardar'){
		$pdf->Output($nombreArchivoPdf,'D');
		return 1;
	}else if($destPdf=='guardarServidor'){
		$pdf->Output($nombreArchivoPdf,'D');
		return 1;
	}else if($destPdf=='cadena'){
		$vRespPdf['nombre']=$nombreArchivoPdf;
		$vRespPdf['cadena']=$pdf->Output('', 'S');
		return $vRespPdf;
	}
}
function enviarCorreo($para,$asunto,$mensaje,$vAdjunto){
	
	$cadenaEmailConfig=valorCampoConfig('emailConfig');
	$vEmailConfig=explode(chr(10),$cadenaEmailConfig);
	for($i=0;isset($vEmailConfig[$i])==true;$i++){
		list($variable,$valor)=explode('=',$vEmailConfig[$i]);
		$emailConfig[$variable]=$valor;
	}
	
	if($emailConfig['Mailer']==''){$emailConfig['Mailer']='smtp';}
	if($emailConfig['Host']==''){$emailConfig['Host']='localhost';}
	if($emailConfig['Port']==''){$emailConfig['Port']='25';}

	$mail = new phpmailer();
	$mail->Mailer = $emailConfig['Mailer'];
	$mail->Host = $emailConfig['Host'];
	$mail->Port = $emailConfig['Port'];
	$mail->SMTPAuth = true;
	$mail->Username = $emailConfig['Username'];
	$mail->Password = $emailConfig['Password'];
	$mail->From = $emailConfig['From'];
	$mail->FromName = $emailConfig['FromName'];
	
	$mail->Timeout=30;
	$mail->AddAddress($para);
	$mail->Subject = $asunto;
	$mail->Body = $mensaje;
	$mail->AltBody = $mensaje;
	
	for($i=1;isset($vAdjunto[$i]['tipo'])==true;$i++){
		if($vAdjunto[$i]['tipo']=='FPDF'){
			$mail->AddStringAttachment($vAdjunto[$i]['archivo']['cadena'], $vAdjunto[$i]['archivo']['nombre'],"base64","application/pdf");
		}
	}
	$mail->Send();	
}
function seleccionarDeLista($id,$denominacion){
	global $resp;
	return '<div style="width:16px;height:16px;"><a href="javascript:seleccionarDeListado(\''.$resp['contenedor'].'\',\''.$id.'\',\''.$denominacion.'\');" title="seleccionar"><span class="glyphicon glyphicon-pushpin"></span></a></div>';
}

function filtrarQueryLista($sql){
	global $cantElementosNuevos, $cantElementosExistentes;
	$sql.="
		limit
			$cantElementosNuevos
		offset
			$cantElementosExistentes
	";
	return $sql;
}

function generarWhereFiltroCadenaBuscar($condiciones){
	global $cadenaBuscar;
	if($cadenaBuscar!=''){
		if(substr($cadenaBuscar,0,1)=='"' && substr($cadenaBuscar,strlen($cadenaBuscar)-1,1)=='"'){
			$vCadBuscar[0]=substr($cadenaBuscar,1,strlen($cadenaBuscar)-2);
		}else if(substr_count($cadenaBuscar,'+')>0){
			$vCadBuscar=explode('+',$cadenaBuscar);
		}else{
			$vCadBuscar=explode(' ',$cadenaBuscar);
		}
		$whereFiltro=' and (';
		for($i=0;isset($vCadBuscar[$i]);$i++){
			$vCadBuscar[$i]=trim($vCadBuscar[$i]);
			if($i>0){$whereFiltro.=" and ";}
			$whereFiltro.="
				(
					$condiciones
				) 
			";
			$whereFiltro=str_replace('{text}',$vCadBuscar[$i],$whereFiltro);
		}
		$whereFiltro.=" ) ";
	}else{
		$whereFiltro="";
	}
	return $whereFiltro;
}
/*
echo "print tra in fuentestra/funciones/php/tra.php: ";
print_r($tra);
*/

function definirOptions($id,$options,$selected=null){
	global $definirOptions;
	
	if(strpos($id,'_')>0){
		list($aux,$variablePHP)=explode('_',$id);
	}else{
		$variablePHP=$id;
	}
	
	$definirOptions[$variablePHP]['options']=$options;
	$definirOptions[$variablePHP]['selected']=$selected;
}

function posUpload($ruta, $archivo, $archivoViejo, $prefijo, $prefijoViejo){
	$archivosTmp = array();
	$archivosActual = array();
	$archivosFinal = array();
	$archivosNew = array();
	
	$raiz = 'archivos/';
	
	$adjuntosAnterior = explode('|', $archivoViejo);
	$adjunto = explode('|', $archivo);
	for($i=0; $i<count($adjunto); $i++){		
		$nombreArchivo = substr($adjunto[$i],4);		
		
		if(substr($adjunto[$i],0,4)=='tmp/'){
			$rename = substr($nombreArchivo,strpos($nombreArchivo,'_')+1);
			$extension = strrchr($rename, '.');
			$archivosNew[$i]=str_replace($extension,null,$prefijo.'_'.$rename.'_'.rand(1000,9999)).$extension;
			
			rename($raiz . trim($ruta,'/').'/tmp/'.$nombreArchivo, $raiz . trim($ruta,'/').'/'.$archivosNew[$i]);
			
			$archivosTmp[$i]=substr($adjunto[$i],4);
		}else{
			if($prefijoViejo!=$prefijo){
				$adj = $adjunto[$i];
				$adjunto[$i] = $prefijo.substr($adjunto[$i],strlen($prefijoViejo));
				rename($raiz . trim($ruta,'/').'/'.$adj, $raiz . trim($ruta,'/').'/'.$adjunto[$i]);
				$adjuntosAnterior[$i]=$adjunto[$i];
			}				

			$archivosActual[$i]=$adjunto[$i];
		}
	}

	$archivosFinal = array_map('agregarComillas', array_intersect($archivosActual, $adjuntosAnterior) + $archivosNew);
	ksort($archivosFinal);
	$archivosDel = array_diff($adjuntosAnterior, $archivosActual);

	foreach($archivosDel as $key=>$value){
		if(!empty($value)){
			rename($raiz . trim($ruta,'/').'/'.$value, $raiz . trim($ruta,'/').'/del/'.$value);
		}
	}

	$toArrayPostgreSQL = implode(',', $archivosFinal);
	
	return '{'. $toArrayPostgreSQL . '}';
}

function agregarComillas($cadena){
	return '"'. $cadena . '"';
}

function mostrarUpload($ruta, $adjuntos, $ancho, $alto) {
	$resultado = array();
	
	if($adjuntos) {
		$archivos = explode('|', $adjuntos);
		
		for ($i=0; $i<count($archivos); $i++) {
			$resultado[] = array(
				'nombre_temp' 	=> $archivos[$i],
				'ubicacion'		=> trim($ruta, '/').'/'.$archivos[$i],
				'ancho'			=> $ancho,
				'alto'			=> $alto,
				'estado'		=> true,
				'nombre_original' => $archivos[$i],
				'peso'			=> filesize('archivos/'.trim($ruta, '/').'/'.$archivos[$i]),
				'proporcion' 	=> @getimagesize('archivos/'.trim($ruta, '/').'/'.$archivos[$i])				
			);
		}
	}
	
	return json_encode($resultado);
}

function rpcSeccion($seccion,$accion,$parametros=array()){
	global $db;
	
	foreach($parametros as $key => $value) {
		$_REQUEST[$key]=$value;
	}
	
	include 'secciones/'.$seccion.'/rpc/'.$accion.'.php';
	return $resp['html'];
}
?>