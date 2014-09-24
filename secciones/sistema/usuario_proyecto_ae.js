function inicializar_sistema_usuario_proyecto_ae(){
	$('#sistUsuariosProyectosAgEd_idUsuario').focus();
	
	autocompletar('sistema', 'sistUsuariosProyectosAgEd_usuario', 'proyectos_lista', 'proyecto_ae');
	autocompletar('sistema', 'sistUsuariosProyectosAgEd_proyecto', 'proyectos_lista', 'proyecto_ae');
}

function agregarEditarSistemaUsuariosProyectos(){
	var datos = new Array();
	datos['idUsuarioEdit'] = $('#sistUsuariosProyectosAgEd_idUsuarioEdit').val();
	datos['idProyectoEdit'] = $('#sistUsuariosProyectosAgEd_idProyectoEdit').val();
	datos['idUsuario'] = $('#sistUsuariosProyectosAgEd_usuarioId').val();
	datos['idProyecto'] = $('#sistUsuariosProyectosAgEd_proyectoId').val();
	datos['activo'] = $('#sistUsuariosProyectosAgEd_activo').prop('checked');
	
	if(datos['idUsuario']=='' || datos['idProyecto']==''){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('sistema','usuarioProyectoAgregarEditar',datos,'fn:posAgregarEditarSistemaUsuariosProyectos();');
	}
}

function posAgregarEditarSistemaUsuariosProyectos(){
	listarSistemaUsuariosProyectos();
	var idUsuarioProyectoEdit = $('#sistUsuariosProyectosAgEd_idUsuarioProyectoEdit').val();
	if(idUsuarioProyectoEdit!=''){
		cerrarVentana();
	}else{
		dialogo('Desea agregar otro registro','si:limpiarCamposSistemaUsuariosProyectos();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
	}
}

function limpiarCamposSistemaUsuariosProyectos(){
	$('#sistUsuariosProyectosAgEd_idUsuario').val('');
	$('#sistUsuariosProyectosAgEd_idProyecto').val('');
	$('#sistUsuariosProyectosAgEd_activo').prop('checked',false);
	$('#sistUsuariosProyectosAgEd_idUsuario').focus();
}