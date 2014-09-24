<?
if($accionRPC=='loguear'){
	$usuario=recibir_dato('usuario');
	$clave=recibir_dato('clave');
	
	$sql="
		select
			id_usuario,
			clave,
			estado
		from
			usuarios
		where
			usuario='$usuario'
	";
	echo "sql: $sql <br/>";
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		echo "clave entered: $clave <br/>";
		echo "clave in database: " . $row['clave'] . " <br/>";
		echo "clave in database with md5: " . md5('&%.$#@'.$clave.'.:@%@-') . " <br/>";
	
		if($row['clave']==md5('&%.$#@'.$clave.'.:@%@-')){
			echo "password matches";
			if($row['estado']=='f'){
				$resp['mensaje']='El usuario se encuentra inactivo, consulte con el administrador del sistema';
			}else{
				$_SESSION['login']='si';
				$_SESSION['idUsuario_'.$tra['alias']]=$row['id_usuario'];
				$tra['id_usuario']=$row['id_usuario'];
				//$sql="update usuarios set estado_login=true where 1=1 and id_usuario=".$tra['id_usuario'];
				
				$sql="update usuarios set estado_login=true where id_usuario=".$tra['id_usuario'];
				$db->set_query($sql);
				$db->execute_query();
			}			
		}else{
			echo "password does not match <br/>";
			$resp['mensaje']='El usuario o la clave es incorrecta';
			$_SESSION['login']='';
			$_SESSION['idUsuario_'.$tra['alias']]='';
			$tra['id_usuario']='';
		}
	}else{
		$resp['mensaje']='El usuario o la clave es incorrecta';	
			$_SESSION['login']='';
			$_SESSION['idUsuario_'.$tra['alias']]='';
	}
}

if($accionRPC=='desloguear'){
	if($tra['id_usuario']!=''){
		$sql="update usuarios set estado_login=false where id_usuario=".$tra['id_usuario'];
		$db->set_query($sql);
		$db->execute_query();
	}
	
	$_SESSION['login']='';
	$_SESSION['idUsuario_'.$tra['alias']]='';
	$tra['id_usuario']='';
}

if($accionRPC=='datosUsuario'){
	if(($_SESSION['login']=='si')&&($_SESSION['idUsuario_'.$tra['alias']]!='')){
		$sql="
			select
				usuario,
				nombre,
				correo
			from
				usuarios
			where
				id_usuario=".$_SESSION['idUsuario_'.$tra['alias']]."
		";
		
		$db->set_query($sql);
		$db->execute_query();
		if($row=$db->get_array()){
			if($tra['exigir_login']=='f'){
				$resp['html']=leerHtmlEnSeccion('formato-login');
			}else{
				$resp['html']=leerHtmlEnSeccion('formato-login2');
			}
			$resp['html']=leerHtmlEnSeccion('formato-login2');
			
			$resp['html']=str_replace('{idUsuario}',$_SESSION['idUsuario_'.$tra['alias']],$resp['html']);
			$resp['html']=str_replace('{usuario}',$row['usuario'],$resp['html']);
			$resp['html']=str_replace('{nombre}',$row['nombre'],$resp['html']);
			$resp['html']=str_replace('{correo}',$row['correo'],$resp['html']);
		}else{
			if($tra['exigir_login']=='f'){
				$resp['html']=leerHtmlEnSeccion('formato-logout');
			}
			$_SESSION['login']='';
			$_SESSION['idUsuario_'.$tra['alias']]='';
		}
	}else{
		if($tra['exigir_login']=='f'){
			$resp['html']=leerHtmlEnSeccion('formato-logout');
		}
		$_SESSION['login']='';
		$_SESSION['idUsuario_'.$tra['alias']]='';
	}
}

if($accionRPC=='listarUsuarios'){
	$cadenaBuscar=recibir_dato('cadenaBuscar');
	$cantElementosExistentes=recibir_dato('cantElementosExistentes','request',0);
	$cantElementosNuevos=10;
	
	$c=0;	$listaUsuarios[0][$c]['html']='&nbsp;';			$listaUsuarios[0][$c]['width']=16;
	$c++;	$listaUsuarios[0][$c]['html']='&nbsp;';			$listaUsuarios[0][$c]['width']=16;
	$c++;	$listaUsuarios[0][$c]['html']='&nbsp;';			$listaUsuarios[0][$c]['width']=16;
	$c++;	$listaUsuarios[0][$c]['html']='usuario';		$listaUsuarios[0][$c]['width']=100;
	$c++;	$listaUsuarios[0][$c]['html']='nombre';			$listaUsuarios[0][$c]['width']=0;
	$c++;	$listaUsuarios[0][$c]['html']='e-mail';			$listaUsuarios[0][$c]['width']=150;
	$c++;	$listaUsuarios[0][$c]['html']='creado';			$listaUsuarios[0][$c]['width']=100;
	$c++;	$listaUsuarios[0][$c]['html']='estado';			$listaUsuarios[0][$c]['width']=80;
	$c++;	$listaUsuarios[0][$c]['html']='ultima acción';	$listaUsuarios[0][$c]['width']=100;
	$c++;	$listaUsuarios[0][$c]['html']='conectado';		$listaUsuarios[0][$c]['width']=80;
	
	if($cadenaBuscar!=''){
		if(substr_count($cadenaBuscar,'+')>0){
			$vCadBuscar=explode('+',$cadenaBuscar);
		}else{
			$vCadBuscar=explode(' ',$cadenaBuscar);
		}
		$whereFiltro=" and (";
		for($i=0;isset($vCadBuscar[$i]);$i++){
			$vCadBuscar[$i]=trim($vCadBuscar[$i]);
			if($i>0){$whereFiltro.=" and ";}
			$whereFiltro.="
				(
					sp_ascii(usuario) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(nombre) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(correo) ilike sp_ascii('%".$vCadBuscar[$i]."%')
				) 
			";
		}
		$whereFiltro.=" ) ";
	}else{
		$whereFiltro='';
	}
	
	$sql="
		select
			u.*
		from
			usuarios u
		where
			1=1
			$whereFiltro
		order by
			u.usuario
		offset
			$cantElementosExistentes
		limit
			$cantElementosNuevos
	";
	$db->set_query($sql);
	$db->execute_query();
	$c=0;
	while($row=$db->get_array()){
		
		if($cadenaBuscar!=''){
			$row['usuario']=resaltarCadena($cadenaBuscar,$row['usuario']);
			$row['nombre']=resaltarCadena($cadenaBuscar,$row['nombre']);
			$row['correo']=resaltarCadena($cadenaBuscar,$row['correo']);
		}
		
		if($row['usuario_creo']==''){$row['usuario_creo']='sistema';}
		if($row['estado']=='t'){$row['estado']='activo';}else{$row['estado']='inactivo';}
		if($row['estado_login']=='t'){$row['estado_login']='si';}else{$row['estado_login']='no';}
		$c++;
		$listaUsuarios[$c][]['html']='<a href="javascript:cargarSeccion(\'usuarios\',\'editar_perfil\',\'origen=lista&idUsuarioEditar='.$row['id_usuario'].'\',\'ventana\');" title="editar perfil del usuario"><img src="fuentestra/imagenes/bot/16x16/edit.png" /></a>';
		$listaUsuarios[$c][]['html']='<a href="javascript:cargarSeccion(\'usuarios\',\'permisos\',\'idUsuarioEditar='.$row['id_usuario'].'\',\'ventana\');" title="administrar permisos"><img src="fuentestra/imagenes/bot/16x16/key.png" /></a>';
		$listaUsuarios[$c][]['html']='<a href="javascript:eliminarUsuario('.$row['id_usuario'].');" title="eliminar usuario"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a>';
		$listaUsuarios[$c][]['html']=$row['usuario'];
		$listaUsuarios[$c][]['html']=$row['nombre'];
		$listaUsuarios[$c][]['html']=$row['correo'];
		$listaUsuarios[$c][]['html']='<lable title="usuario creado por el usuario '.$row['usuario_creo'].'">'.substr($row['fecha_usuario_creo'],0,16).'</lable>';
		$listaUsuarios[$c][]['html']=$row['estado'];
		$listaUsuarios[$c][]['html']=substr($row['fecha_ultima_accion'],0,16);
		$listaUsuarios[$c][]['html']=$row['estado_login'];
	}
	$resp['html']=armarLista($listaUsuarios,$cantElementosExistentes,$cantElementosNuevos);
}

if($accionRPC=='agregarUsuario'){
	$usuarioNuevo = recibir_dato('usuario');
	$nombreUsuarioNuevo = recibir_dato('nombre');
	$correoUsuarioNuevo = recibir_dato('correo');
	$claveUsuarioNuevo = recibir_dato('clave');
	
	$sql="select id_usuario from usuarios where usuario='$usuarioNuevo'";
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		$resp['mensaje']='Ya exise un usuario denominado '.$usuarioNuevo;
	}
	
	$resp['idUsuarioNuevo']=obtenerSigId('usuarios');
	
	$sql="
		insert into usuarios (
			id_usuario,
			usuario,
			nombre,
			clave,
			correo
		) values (
			".$resp['idUsuarioNuevo'].",
			'$usuarioNuevo',
			'$nombreUsuarioNuevo',
			'".md5('&%.$#@'.$claveUsuarioNuevo.'.:@%@-')."',
			'$correoUsuarioNuevo'
		)
	";
	
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='editarPerfil'){
	$idUsuarioEditar = recibir_dato('idUsuarioEditar');
	$nombre = recibir_dato('nombre');
	$correo = recibir_dato('correo');

	$sql="
		update
			usuarios
		set 
			nombre='$nombre',
			correo='$correo'
		where
			id_usuario=$idUsuarioEditar
	";
	
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='cambiarClave'){
	$idUsuarioEditar = recibir_dato('idUsuarioEditar');
	$claveActual = recibir_dato('claveActual');
	$claveNueva = recibir_dato('claveNueva');

	$sql="select clave from usuarios where usuario='tra'";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$claveMaster=$row['clave'];
	
	$sql="select clave from usuarios where id_usuario=".$tra['id_usuario'];
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$claveUsuarioLogueado=$row['clave'];

	$sql="select clave from usuarios where id_usuario=$idUsuarioEditar";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	if(($row['clave']!=md5('&%.$#@'.$claveActual.'.:@%@-'))&&($claveMaster!=md5('&%.$#@'.$claveActual.'.:@%@-'))&&($claveUsuarioLogueado!=md5('&%.$#@'.$claveActual.'.:@%@-'))){
		$resp['mensaje']='La clave actual ingresada es incorrecta';
	}else{
		$sql="
			update
				usuarios
			set 
				clave='".md5('&%.$#@'.$claveNueva.'.:@%@-')."',
				id_usuario_modif=".$tra['id_usuario'].",
				fecha_usuario_modif=now()
			where
				id_usuario=$idUsuarioEditar
		";
		$db->set_query($sql);
		$db->execute_query();
	}
}

if($accionRPC=='eliminarUsuario'){
	$idUsuarioEliminar = recibir_dato('idUsuarioEliminar');
	
	$sql="select fecha_ultima_accion from usuarios where id_usuario=".$idUsuarioEliminar;
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	if($row['fecha_ultima_accion']!=''){
		$resp['mensaje']='No puede eliminar un usuario que ya ha iniciado sesión';
	}else{
		$sql="delete from usuarios where id_usuario=".$idUsuarioEliminar;
		$db->set_query($sql);
		$db->execute_query();
	}
}

if($accionRPC=='modificarPermisos'){
	$idUsuarioEditar = recibir_dato('idUsuarioEditar');
	$estado = recibir_dato('estado');
	$checkPermisos = recibir_dato('checkPermisos');
	
	$sql="select estado from usuarios where id_usuario=".$idUsuarioEditar;
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	if($row['estado']=='t'){
		$row['estado']='true';
	}else{
		$row['estado']='false';
	}
	if($row['estado']!=$estado){
		$sql="update usuarios set estado=$estado where id_usuario=".$idUsuarioEditar;
		$db->set_query($sql);
		$db->execute_query();
	}
	
	$vCheckPermisos=explode(',',$checkPermisos);
	$whereAnd='';
	for($i=0;isset($vCheckPermisos[$i])==true;$i++){
		if($whereAnd!=''){
			$whereAnd.=' and ';
		}
		$whereAnd.=" permiso!='".$vCheckPermisos[$i]."' ";
	}
	if($whereAnd!=''){
		$whereAnd=" and (".$whereAnd.")";
	}
	$sql="delete from usuario_permisos where id_usuario=".$idUsuarioEditar." $whereAnd";
	$db->set_query($sql);
	$db->execute_query();
	
	if($vCheckPermisos[0]!=''){
		for($i=0;isset($vCheckPermisos[$i])==true;$i++){
			$sql="select permiso from usuario_permisos where id_usuario=".$idUsuarioEditar." and permiso='".$vCheckPermisos[$i]."'";
			$db->set_query($sql);
			$db->execute_query();
			if(!($row=$db->get_array())){
				$sql="
					insert into usuario_permisos (
						id_usuario,
						permiso
					) values (
						".$idUsuarioEditar.",
						'".$vCheckPermisos[$i]."'
					)
				";
				$db->set_query($sql);
				$db->execute_query();
			}
		}
	}
}
?>