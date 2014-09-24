<?
$guardarEnDebugOperaciones=0;

//-- datos para la coneccion a la bd por defecto --
$tra['bdDefault']='bdtra';
$tra['bdDefaultUsuario']='postgres';
$tra['bdDefaultClave']='teraadmin';
$tra['bdDefaultIp']='localhost';

if($tra['bd']==''){$tra['bd']=$tra['bdDefault'];}
if($tra['bdUsuario']==''){$tra['bdUsuario']=$tra['bdDefaultUsuario'];}
if($tra['bdClave']==''){$tra['bdClave']=$tra['bdDefaultClave'];}
if($tra['bdIp']==''){$tra['bdIp']=$tra['bdDefaultIp'];}

include('funciones/php/generales.php');

$nuevoSistema=recibir_dato('nuevoSistema');
$b=0;
//$sql="select id_sistema, titulo, palabras_claves, descripcion, dominio, exigir_login from sistemas where alias='".$tra['alias']."'";
$sql="select titulo, palabras_claves, descripcion, dominio, exigir_login from sistemas where alias='".$tra['alias']."'";

$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
	$tra['id_sistema']='';
	$tra['titulo']=$row['titulo'];
	$tra['palabras clave']=$row['palabras_claves'];
	$tra['descripcion']=$row['descripcion'];
	$tra['dominio']=$row['dominio'];
	$tra['exigir_login']=$row['exigir_login'];
	$tra['id_usuario']=$_SESSION['idUsuario_'.$tra['alias']];
	$b=1;
}else{
	if($nuevoSistema=='procesoInsert'){
		$tra['titulo']=recibir_dato('titulo','post');
		$tra['descripcion']=recibir_dato('descripcion','post');
		$tra['palabras clave']=recibir_dato('palabrasClave','post');
		$usuario=recibir_dato('usuario','post');
		$nombre=recibir_dato('nombre','post');
		$clave=recibir_dato('clave','post');
		$correo=recibir_dato('correo','post');
		
		$sql="select id_sistema from sistemas order by id_sistema desc limit 1";
		$db->set_query($sql);
		$db->execute_query();
		if($row=$db->get_array()){
			$tra['id_sistema']=$row['id_sistema']+1;
		}else{
			$tra['id_sistema']=1;
		}
		
		$sql="
			insert into sistemas (
				id_sistema, alias, titulo, palabras_claves, descripcion
			) values (
				".$tra['id_sistema'].", '".$tra['alias']."', '".utf8_encode($tra['titulo'])."', '".utf8_encode($tra['palabras clave'])."', '".utf8_encode($tra['descripcion'])."'
			)
		";
		$db->set_query($sql);
		$db->execute_query();
		
		$sql="
			insert into usuarios (
				id_sistema,
				id_usuario,
				usuario,
				nombre,
				clave,
				correo,
				id_usuario_creo,
				fecha_usuario_creo,
				id_usuario_modif,
				fecha_usuario_modif
			) values (
				".$tra['id_sistema'].",
				1,
				'$usuario',
				'".utf8_encode($nombre)."',
				'".md5('&%.$#@'.$clave.'.:@%@-')."',
				'$correo',
				null,
				now(),
				null,
				now()
			)
		";
		$db->set_query($sql);
		$db->execute_query();
		
		$b=1;
	}
}
if($b==0){
	if($nuevoSistema=='insert'){
		include 'nuevosistema.php';
	}else{
		echo("El sistema <b>".$tra['alias']."</b> no se encuentra registrado en base de datos <b>".$tra['bd']."</b> <a href='index.php?nuevoSistema=insert'>registrar</a>");
	}
}else{	
	$tra['operacion']=recibir_dato('o');
	if(isset($_REQUEST['folder'])==true){$tra['operacion']='secciones';}

	$resp['esq']='ok';
	$resp['mensaje']='';
	if($tra['operacion']!=''){
		if($tra['operacion']=='ima'){
			include('imagen.php');
		}else if(substr($tra['operacion'],0,10)=='imaarchivo'){
			$cadenaImagen=substr($tra['operacion'],3);
			include('imagen.php');
		}else if(substr($tra['operacion'],0,13)=='enlacedirecto'){
			list($operacion,$seccion,$id)=explode(',',$tra['operacion']);
			$accionRPC='compartir';
			$resp['html']=leer_codigo_de_archivo('fuentestra/esquema-enlace-directo.html');
			if(is_file('fuentestra/secciones/'.$seccion.'/enlace_directo.php')==true){
				include 'fuentestra/secciones/'.$seccion.'/enlace_directo.php';
			}
			$resp['html']=str_replace('{title}',$resp['title'],$resp['html']);
			$resp['html']=str_replace('{palabras clave}',$resp['palabras clave'],$resp['html']);
			$resp['html']=str_replace('{descripcion}',$resp['descripcion'],$resp['html']);
			$resp['html']=str_replace('{imagen}',$resp['imagen'],$resp['html']);
			$resp['html']=str_replace('{info}',$resp['info'],$resp['html']);
			$resp['html']=str_replace('{accionJavaScript}',$resp['accionJavaScript'],$resp['html']);
			$resp['html']=str_replace('{parametrosEnlaceDirecto}',$resp['parametrosEnlaceDirecto'],$resp['html']);
			echo($resp['html']);
		}else if($tra['operacion']=='pdf'){
			include('pdf.php');
		}else if($tra['operacion']=='debug'){
			include('debug.php');
		}else{
			include($tra['operacion'].'/'.$tra['operacion'].'.php');
		}
	}else{
		tra();
	}
}

/*
echo "print tra in fuentestra/operaciones.php: ";
print_r($tra);
*/
/*
echo "print included files in fuentestra/operaciones.php: ";
print_r(get_included_files());
*/

?>