function inicializar_auditoria_auditoria_lista(){
	listarAuditoriaAuditoria();
}

function listarAuditoriaAuditoria(){
	cargando('listaAuditoria',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaAuditoriaCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaAuditoriaAccionPosSeleccionar').val();
	datos['tabla'] = $('#listaAuditoria_tabla').val();
	datos['rowid'] = $('#listaAuditoria_rowid').val();
	datos['accion'] = $('#listaAuditoria_accion').val();
	rpcSeccion('auditoria','auditoriaListar',datos,'id:listaAuditoria');
}