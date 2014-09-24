function inicializar_cajas_caja_ae(){
	$('#cajaCajasAgEd_denominacion').focus();
}

function agregarEditarCajasCajas(){
	var datos = new Array();
	datos['idCajaEdit'] = $('#cajaCajasAgEd_idCajaEdit').val();
	datos['denominacion'] = $('#cajaCajasAgEd_denominacion').val();
	
	if (datos['denominacion'] == '') {
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	} else {
		rpcSeccion('cajas','cajaAgregarEditar',datos,'fn:posAgregarEditarCajasCajas();');
	}
}

function posAgregarEditarCajasCajas(){
	listarCajasCajas();
	var idCajaEdit = $('#cajaCajasAgEd_idCajaEdit').val();
	if(idCajaEdit!=''){
		cerrarVentana();
	}else{
		dialogo('Desea agregar otro registro','si:limpiarCamposCajasCajas();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
	}
}

function limpiarCamposCajasCajas(){
	$('#cajaCajasAgEd_denominacion').val('').focus();
}