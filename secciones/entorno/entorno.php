<?php

if($tra['id_usuario']!=''){
	$sql="
		select
			id_proyecto
		from
			sistema.usuarios_proyectos
		where
			id_usuario={$tra['id_usuario']} and
			activo=true
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$_SESSION['id_proyecto']=$row['id_proyecto'];
}

if(!isset($tra['tema'])) $tra['tema'] = '';

switch ($tra['tema']) {
	case 'azul':
	   $colorPrimary = "#4E0BE0";
	   $colorLight1 = "#7E51E0";
	   $colorLight2 = "#6127E0";
	   $colorDark1 = "#3907A7";
	   $colorDark2 = "#2D0582";
	   $textColor = "#FFFFFF";
		break;	
	case 'verde':
	   $colorPrimary = "#244E19";
	   $colorLight1 = "#56854A";
	   $colorLight2 = "#37602C";
	   $colorDark1 = "#13370A";
	   $colorDark2 = "#071F00";
	   $textColor = "#FFFFFF";
		break;	
	default:
	   $colorPrimary = "#CC7A00";
	   $colorLight1 = "#FFB74D";
	   $colorLight2 = "#F89E17";
	   $colorDark1 = "#A76400";
	   $colorDark2 = "#7D4B00";
	   $textColor = "#FFFFFF";
		break;
}

$tema = '
	<style type="text/css">
		thead{
			background-color: #333333;
			color: '.$colorPrimary.';
		}
		.btn-default {
			color: '.$textColor.';
			text-shadow: none !important;
		}
		
		.btn-primary, .btn-default {
			background-image: linear-gradient(to bottom, '.$colorLight2.' 0%, '.$colorDark1.' 100%);
			background-repeat: repeat-x;
			border-color: '.$colorPrimary.';
			
		}
		
		.btn-primary:active, .btn-default.active {
			background-color: '.$colorLight1.';
			border-color: '.$colorPrimary.';
			color: '.$textColor.';
		}
		.btn-primary:hover, .btn-primary:focus, .btn-default:hover, .btn-default:focus {
			background-image: linear-gradient(to bottom, '.$colorLight1.' 0%, '.$colorPrimary.' 100%);
			background-repeat: repeat-x;
			border-color: '.$colorPrimary.';
			background-position: 0 0px;
			color: '.$textColor.';
		}
		
		.open.dropdown-toggle.btn-primary, .open.dropdown-toggle.btn-default {
			background-color: #444444;
			border-color: #222222;
			color: '.$colorLight2.';
		}
		
		.navbar-nav > li > a {
			color: '.$colorPrimary.' !important;
		}
		
		.navbar-text {
			color: '.$colorPrimary.' !important;
		}
		
		.glyphicon {
			color: '.$colorPrimary.';
		}
	</style>
';

//$tiempo = date('h:i:s', time());
date_default_timezone_set('America/Asuncion');
$tiempo = time();
$fecha = date('d/m/Y');
$periodo = $_SESSION['periodo'];
?>