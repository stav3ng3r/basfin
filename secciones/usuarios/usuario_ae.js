function inicializar_usuarios_usuario_ae(){
	$('#usuaUsuariosAgEd_usuario').focus();
	
	var idUsuarioEdit = $('#usuaUsuariosAgEd_idUsuarioEdit').val();
	if (idUsuarioEdit != '') {
		$('.usuaUsuariosAgEd_editar').removeClass('hidden');
		$('#usuaUsuariosAgEd_usuario').remove();
	} else {
		$('#usuaUsuariosAgEd_usuario').removeClass('hidden');
		$('.usuaUsuariosAgEd_editar').remove();		
	}
}

function agregarEditarUsuariosUsuarios(){
	var datos = new Array();
	datos['idUsuarioEdit'] = $('#usuaUsuariosAgEd_idUsuarioEdit').val();
	
	if (datos['idUsuarioEdit'] == '') {
		datos['usuario'] = $('#usuaUsuariosAgEd_usuario').val();
	} else {
		datos['aclave'] = $('#usuaUsuariosAgEd_aclave').val();
	}
	
	datos['nombre'] = $('#usuaUsuariosAgEd_nombre').val();
	datos['email'] = $('#usuaUsuariosAgEd_email').val();
	datos['clave'] = $('#usuaUsuariosAgEd_clave').val();
	datos['cclave'] = $('#usuaUsuariosAgEd_cclave').val();
		
	if (datos['usuario']=='' || datos['nombre']=='' || datos['email']=='' || (datos['aclave']==null && (datos['clave']=='' || datos['cclave']==''))) {
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');
	} else if (datos['clave']!=datos['cclave']) {
		dialogo('La confirmación de la clave no coincide con la clave');			
	} else if (datos['aclave']!=null && datos['aclave']=='') {
		dialogo('Ingrese su clave para realizar la modificación');				
	} else {
		rpcSeccion('usuarios','usuarioAgregarEditar',datos,'fn:posAgregarEditarUsuariosUsuarios();');
	}
}

function posAgregarEditarUsuariosUsuarios(){
	var row=rowRPC;
	listarUsuariosUsuarios();
	var idUsuarioEdit = $('#usuaUsuariosAgEd_idUsuarioEdit').val();
	if (idUsuarioEdit != '') {
		cerrarVentana();
	} else {
		//dialogo('Desea agregar otro registro','si:limpiarCamposUsuariosUsuarios();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
		dialogo('El usuario se ha insertado con éxito, desea asignarle permisos de acceso?','si:irAsignarPermisosPosNuevoUsuario(' + row['idUsuario'] + ');cerrarDialogo();|no','ok');
	}
}

function irAsignarPermisosPosNuevoUsuario(idUsuarioNuevo){
	cargarSeccion('usuarios','permisos_lista','idUsuarioEditar=' + idUsuarioNuevo,'ventana');
}

function limpiarCamposUsuariosUsuarios(){
	$('#usuaUsuariosAgEd_usuario').val('').focus();
}