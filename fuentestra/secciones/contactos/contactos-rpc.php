<?
if($accionRPC=='enviarMensaje'){
	$nombre=recibir_dato('nombre','post');
	$correo=recibir_dato('correo','post');
	$telefono=recibir_dato('telefono','post');
	$asunto=recibir_dato('asunto','post');
	$mensaje=recibir_dato('mensaje','post');
	if(mail('info@tera.com.py',$asunto,$mensaje.chr(10).'-------------'.chr(10).$nombre.'-'.$correo.'-'.$telefono)==false){
		$resp['mensaje']="El mensaje no se ha podido enviar, consulte con el administrador del sitio";
	}else{
		$resp['mensaje']="El mensaje ha sido enviado exitósamente";
	}
}

if($accionRPC=='insertarContacto'){
	$nombreContacto=recibir_dato('nombreContacto','post');

	$sql="
		insert into contactos (
			id_sistema,
			id_contacto,
			nombre
		) values (
			".$tra['id_sistema'].",
			".obtenerSigId('contactos').",
			'$nombreContacto'
		)
	";
	$db->set_query($sql);
	$db->execute_query();
	$resp['mensaje']="El contacto se ha agregado exitósamente";
}
?>