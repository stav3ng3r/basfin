function inicializar_usuarios_usuarios_lista(){
	listarUsuariosUsuarios();
}

function listarUsuariosUsuarios(){
	cargando('listaUsuario',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaUsuarioCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaUsuarioAccionPosSeleccionar').val();
	rpcSeccion('usuarios','usuariosListar',datos,'id:listaUsuario');
}

function eliminarUsuario(idUsuario){
	cerrarDialogo();
	
	var datos = new Array();
	datos['idUsuario'] = idUsuario;
	rpcSeccion('usuarios','usuarioEliminar',datos,'fn:listarUsuariosUsuarios();');
}