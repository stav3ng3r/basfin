function inicializar_sistema_proyectos_lista(){
	listarSistemaProyectos();
	//rpcSeccion('generador_reportes','listaReportesAplicacion','','id:reportes_sistema__proyectos_lista');
}

function listarSistemaProyectos(){
	cargando('listaProyecto',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaProyectoCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaProyectoAccionPosSeleccionar').val();
	rpcSeccion('sistema','proyectosListar',datos,'id:listaProyecto');
}

function eliminarProyecto(idProyecto){
	cerrarDialogo();
	var datos = new Array();
	datos['idProyecto'] = idProyecto;
	rpcSeccion('sistema','proyectoEliminar',datos,'fn:listarSistemaProyectos();');
}