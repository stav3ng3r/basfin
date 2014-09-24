function procesarCambiarPeriodoTrabajo(){
	var datos = new Array();
	datos['periodo']=$('#cp_periodo').val();
	rpcSeccion('configuraciones','cambiarPeriodoTrabajo',datos,'fn:posCambiarPeriodoTrabajo();');
}

function posCambiarPeriodoTrabajo(){
	$('#sgpPeriodoTrabajo').html($('#cp_periodo').val());
	cerrarVentana();
	cargarSeccion('inicio');
}