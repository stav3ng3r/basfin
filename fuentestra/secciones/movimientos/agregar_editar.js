function insertarEditarMovimiento(idMovimiento){
	var datos = new Array();
	datos['tipo']=valoresSeleccionadosRadio('tipoMovimiento');
	datos['fecha']=$('#fechaMovimiento').val();
	datos['idContacto']=$('#idContacto').val();
	datos['idConcepto']=$('#idConcepto').val();
	datos['observacion']=$('#observacion').val();
	datos['tipoComprobante']=$('#tipoComprobante').val();
	datos['nroComprobante']=$('#nroComprobante').val();
	datos['monto']=$('#monto').val();
	datos['fechaVencimiento']=$('#fechaVencimiento').val();
	datos['estado']=valoresSeleccionadosRadio('estado');
	if((datos['tipo']=='')||(datos['fecha']=='')||(datos['idContacto']=='')||(datos['idConcepto']=='')||(datos['monto']=='')||(datos['estado']=='')){
		dialogo('Debe completar todos los campos marcados con asterisco');
	}else{
		ocultar('submitFormAddMovimiento');
		mostrar('procesandoFormAddMovimiento');
		if(idMovimiento==''){
			var accionRPC = 'insertarMovimiento';
			var fnLuego= 'luegoInsertarMovimiento();';
		}else{
			var accionRPC = 'editarMovimiento';
			var fnLuego= 'luegoEditarMovimiento();';
			datos['idMovimiento']=idMovimiento;
		}
		rpcSeccion('movimientos',accionRPC,datos,'fn:' + fnLuego);
	}
}

function luegoInsertarMovimiento(){
	ocultar('procesandoFormAddMovimiento');
	listarMovimientos();
	dialogo('Desea agregar otro movimiento?','si:limpiarInputs();|no:cerrarVentana(' + nivelVentana + ');','pregunta');
}

function limpiarInputs(){
	$('#observacion').val('');
	$('#tipoComprobante').val('');
	$('#nroComprobante').val('');
	$('#monto').val('');
	$('#fechaVencimiento').val('');
	mostrar('submitFormAddMovimiento');
}

function luegoEditarMovimiento(){
	ocultar('procesandoFormAddMovimiento');
	dialogo('El registro se ha modificado exitósamente','aceptar:cerrarVentana(' + nivelVentana + ');','ok');
	listarMovimientos();
}