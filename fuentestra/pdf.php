<?
$seccion=recibir_dato('s');
$aplicacion=recibir_dato('a');
$destPdf=recibir_dato('destPdf');

if($guardarEnDebugOperaciones==1){
	debug('operacion','PDF',$seccion.'/'.$aplicacion);
}

//-- ini cargar vectos usuarios ----------------------------------
  //$sql="select id_usuario, usuario, nombre, correo from usuarios where id_sistema=".$tra['id_sistema'];
  $sql="select id_usuario, usuario, nombre, correo from usuarios";
  $db->set_query($sql);
  $db->execute_query();
  while($row=$db->get_array()){
	$vUsuarios[$row['id_usuario']]['usuario']=$row['usuario'];
	$vUsuarios[$row['id_usuario']]['nombre']=$row['nombre'];
	$vUsuarios[$row['id_usuario']]['correo']=$row['correo'];
  }
//-- fin cargar vectos usuarios ----------------------------------

if(file_exists('funciones/funciones.php')==true){
	include 'funciones/funciones.php';
}

if(file_exists('secciones/'.$seccion.'/funciones.php')==true){
	include 'secciones/'.$seccion.'/funciones.php';
}elseif(file_exists('fuentestra/secciones/'.$seccion.'/funciones.php')==true){
	include 'fuentestra/secciones/'.$seccion.'/funciones.php';
}
if(file_exists('funciones/extends-fpdf.php')==true){
	include 'funciones/extends-fpdf.php';
}

generarPDF($seccion,$aplicacion,$parametros,$destPdf);
?>