function inicializar_generador_tipo2_lista(){
	listarGenT2();
	rpcSeccion('generador_reportes','listaReportesAplicacion','','id:reportes');
}

function listarGenT2(){
	cargando('listaT2',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaT2CadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaT1AccionPosSeleccionar').val();
	rpcSeccion('generador_tipo2','t2Listar',datos,'id:listaT2');
}

function eliminarT2(idT2){
	var datos = new Array();
	datos['idT2'] = idT2;
	rpcSeccion('generador_tipo2','t1Eliminar',datos,'fn:listarGenT2();');
}