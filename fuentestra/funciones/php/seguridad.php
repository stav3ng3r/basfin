<?php
//$minutosParaDesconeccion=35;

function recibir_dato($variable, $metodo='request', $por_defecto=''){
	$valor=$por_defecto;
	
	if(($metodo=="post")||($metodo=="_post")){
		if(isset($_POST[$variable])==true){
			$valor=$_POST[$variable];
		}
	}
	if(($metodo=="get")||($metodo=="_get")){
		if(isset($_GET[$variable])==true){
			$valor=$_GET[$variable];
		}
	}
	if(($metodo=="request")||($metodo=="_request")){
		if(isset($_REQUEST[$variable])==true){
			$valor=$_REQUEST[$variable];
		}
	}
	$valor=utf8_decode($valor);
	$valor=str_replace('746t985otroParametro746t985','&',$valor);
	$valor=str_replace('|signomas|','+',$valor);
	
	$valor=trim($valor);
	
	if($variable!='onLoad' && $variable!='accionLogin' && $variable!='query' && $variable!='subtitulo' && $variable!='condicion'){
		$valor=pg_escape_string($valor);
	}
	
	return $valor;
}

function recibir_numero($variable, $metodo="request", $por_defecto=""){
	$valor=recibir_dato($variable, $metodo, $por_defecto);
	$valor=str_replace('.','',$valor);
	return $valor;
}

function verifSqlInjection($cadena){

	// header('Location: index.php?s=login&cerrar=si');
}

function obtener_direccion_ip()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
  {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
  {
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

function poseePermiso($sentencia,$tipo='and'){
	global $tra, $db5;
	
	if($sentencia==''){
		return true;	
	}
	
	$vPermisos=explode(',',$sentencia);
	$cTrue=0;
	$cPermisos=0;
	for($i=0;isset($vPermisos[$i])==true;$i++){
		$sql="select * from usuario_permisos where id_usuario=".$tra['id_usuario']." and permiso='".$vPermisos[$i]."'";
		$db5->set_query($sql);
		$db5->execute_query();
		if($row=$db5->get_array()){
			$cTrue++;
		}
		$cPermisos++;
	}
	if($tipo=='and'){
		if($cTrue==$cPermisos){
			return true;	
		}else{
			return false;
		}
	}else if($tipo=='or'){
		if($cTrue>=1){
			return true;	
		}else{
			return false;
		}
	}
	return false;
}