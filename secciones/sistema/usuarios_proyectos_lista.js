function inicializar_sistema_usuarios_proyectos_lista(){
	listarSistemaUsuariosProyectos();
	//rpcSeccion('generador_reportes','listaReportesAplicacion','','id:reportes_sistema__usuarios_proyectos_lista');
}

function listarSistemaUsuariosProyectos(){
	cargando('listaUsuarioProyecto',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaUsuarioProyectoCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaUsuarioProyectoAccionPosSeleccionar').val();
	rpcSeccion('sistema','usuariosProyectosListar',datos,'id:listaUsuarioProyecto');
}

function eliminarUsuarioProyecto(idUsuario, idProyecto){
	cerrarDialogo();
	var datos = new Array();
	datos['idUsuario'] = idUsuario;
	datos['idProyecto'] = idProyecto;
	rpcSeccion('sistema','usuarioProyectoEliminar',datos,'fn:listarSistemaUsuariosProyectos();');
}