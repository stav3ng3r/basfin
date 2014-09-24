function inicializar_sistema_activaciones_lista(){
	listarSistemaActivaciones();
}

function listarSistemaActivaciones(){
	cargando('listaActivacion',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaActivacionCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaActivacionAccionPosSeleccionar').val();
	rpcSeccion('sistema','activacionesListar',datos,'id:listaActivacion');
}

function eliminarActivacion(idActivacion){
	cerrarDialogo();
	var datos = new Array();
	datos['idActivacion'] = idActivacion;
	rpcSeccion('sistema','activacionEliminar',datos,'fn:listarSistemaActivaciones();');
}