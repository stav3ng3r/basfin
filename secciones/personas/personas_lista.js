function inicializar_personas_personas_lista(){
	listarPersonasPersonas();
}

function listarPersonasPersonas(){
	cargando('listaPersona',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaPersonaCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaPersonaAccionPosSeleccionar').val();
	rpcSeccion('personas','personasListar',datos,'id:listaPersona');
}

function eliminarPersona(idPersona){
	cerrarDialogo();
	
	var datos = new Array();
	datos['idPersona'] = idPersona;
	rpcSeccion('personas','personaEliminar',datos,'fn:listarPersonasPersonas();');
}