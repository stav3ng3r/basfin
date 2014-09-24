<?php

if($accionRPC=='comprobarSesion'){
	if(($_SESSION['login']=='si')&&($_SESSION['idUsuario_'.$tra['alias']]!='')){
		$resp['sesionIniciada'] = 't';
	}else{
		$resp['sesionIniciada'] = 'f';
	}
}

?>