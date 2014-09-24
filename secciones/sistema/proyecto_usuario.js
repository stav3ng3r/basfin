function inicializar_sistema_proyecto_usuario(){
	listarSistemaProyectoUsuario();
}

function listarSistemaProyectoUsuario(){
	cargando('listaProyectoUsuario',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaProyectoUsuarioCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaProyectoUsuarioAccionPosSeleccionar').val();
	datos['idProyecto'] = $('#listaProyectoUsuario_idProyecto').val();
	rpcSeccion('sistema','proyectoUsuariosListar',datos,'id:listaProyectoUsuario');
}

function agregarUsuarioProyectoUsuario(idUsuario) {
	var datos = new Array();
	datos['idProyecto'] = $('#listaProyectoUsuario_idProyecto').val();
	datos['idUsuario'] = idUsuario;
	rpcSeccion('sistema','proyectoUsuarioAgregar',datos,'fn:listarSistemaProyectoUsuario();');	
}

function eliminarProyectoUsuario(idProyecto, idUsuario) {
	var datos = new Array();
	datos['idProyecto'] = idProyecto;
	datos['idUsuario'] = idUsuario;
	rpcSeccion('sistema','proyectoUsuarioEliminar',datos,'fn:listarSistemaProyectoUsuario();cerrarDialogo();');	
}