function inicializar_sistema_activacion_ae(){
	$('#sistActivacionesAgEd_idProyecto').focus();
	autocompletar('sistema', 'sistActivacionesAgEd_idProyecto', '', '');
}

function agregarEditarSistemaActivaciones(){
	var datos = new Array();
	datos['idActivacionEdit'] = $('#sistActivacionesAgEd_idActivacionEdit').val();
	datos['idProyecto'] = $('#sistActivacionesAgEd_idProyectoId').val();
	datos['fechaActivacion'] = $('#sistActivacionesAgEd_fechaActivacion').val();
	datos['horaActivacion'] = $('#sistActivacionesAgEd_horaActivacion').val();
	datos['fechaOperacion'] = $('#sistActivacionesAgEd_fechaOperacion').val();
	datos['horaOperacion'] = $('#sistActivacionesAgEd_horaOperacion').val();
	datos['validez'] = $('#sistActivacionesAgEd_validez').val();
	datos['observacion'] = $('#sistActivacionesAgEd_observacion').val();
	
	if(datos['idProyecto']=='' || datos['fechaActivacion']=='' || datos['fechaActivacion'].indexOf('_')!=-1 || datos['fechaOperacion']=='' || datos['fechaOperacion'].indexOf('_')!=-1 ||
	datos['horaActivacion']=='' || datos['horaActivacion'].indexOf('_')!=-1 || datos['horaOperacion']=='' || datos['horaOperacion'].indexOf('_')!=-1){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('sistema','activacionAgregarEditar',datos,'fn:posAgregarEditarSistemaActivaciones();');
	}
}

function posAgregarEditarSistemaActivaciones(){
	listarSistemaActivaciones();
	var idActivacionEdit = $('#sistActivacionesAgEd_idActivacionEdit').val();
	if(idActivacionEdit!=''){
		cerrarVentana();
	}else{
		dialogo('Desea agregar otro registro','si:limpiarCamposSistemaActivaciones();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
	}
}

function limpiarCamposSistemaActivaciones(){
	$('#sistActivacionesAgEd_idProyecto').val('').focus();
	$('#sistActivacionesAgEd_idProyectoId').val('');
	$('#sistActivacionesAgEd_fechaActivacion').val('');
	$('#sistActivacionesAgEd_horaActivacion').val('');
	$('#sistActivacionesAgEd_fechaOperacion').val('');
	$('#sistActivacionesAgEd_horaOperacion').val('');
	$('#sistActivacionesAgEd_validez').val('');
	$('#sistActivacionesAgEd_observacion').val('');
}