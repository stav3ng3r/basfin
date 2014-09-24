function inicializar_cajas_cajas_lista(){
	listarCajasCajas();
}

function listarCajasCajas(){
	cargando('listaCaja',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaCajaCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaCajaAccionPosSeleccionar').val();
	rpcSeccion('cajas','cajasListar',datos,'id:listaCaja');
}

function eliminarCaja(idCaja){
	cerrarDialogo();
	
	var datos = new Array();
	datos['idCaja'] = idCaja;
	rpcSeccion('cajas','cajaEliminar',datos,'fn:listarCajasCajas();');
}