function inicializar_rubros_rubros_lista(){
	listarRubrosRubros();
	//rpcSeccion('generador_reportes','listaReportesAplicacion','','id:reportes_rubros__rubros_lista');
}

function listarRubrosRubros(){
	cargando('listaRubro',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaRubroCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaRubroAccionPosSeleccionar').val();
	rpcSeccion('rubros','rubrosListar',datos,'id:listaRubro');
}

function eliminarRubro(idRubro){
	cerrarDialogo();
	var datos = new Array();
	datos['idRubro'] = idRubro;
	rpcSeccion('rubros','rubroEliminar',datos,'fn:listarRubrosRubros();');
}