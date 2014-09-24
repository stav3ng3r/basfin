function inicializar_generador_tipo1_lista(){
	listarGenT1();
	rpcSeccion('generador_reportes','listaReportesAplicacion','','id:reportes');
}

function listarGenT1(){
	cargando('listaT1',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaT1CadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaT1AccionPosSeleccionar').val();
	rpcSeccion('generador_tipo1','t1Listar',datos,'id:listaT1');
}

function eliminarT1(idT1){
	var datos = new Array();
	datos['idT1'] = idT1;
	rpcSeccion('generador_tipo1','t1Eliminar',datos,'fn:listarGenT1();');
}