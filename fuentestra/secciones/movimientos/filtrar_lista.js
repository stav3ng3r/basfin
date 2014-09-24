function inicializar_movimientos_filtrar_lista(){
	document.getElementById('tipoMovimientoI').checked = filtListaMovimientos['filt_tipoMovimientoIngreso'];
	document.getElementById('tipoMovimientoE').checked = filtListaMovimientos['filt_tipoMovimientoEgreso'];
	$('#fechaMovimientoDesde').val(filtListaMovimientos['filt_fechaDesde']);
	$('#fechaMovimientoHasta').val(filtListaMovimientos['filt_fechaHasta']);
	
	
	$('#idContacto').val(filtListaMovimientos['filt_idContacto']);
	$('#idConcepto').val(filtListaMovimientos['filt_idConcepto']);
	$('#observacion').val(filtListaMovimientos['filt_observacion']);
	$('#tipoComprobante').val(filtListaMovimientos['filt_tipoComprobante']);
	$('#nroComprobante').val(filtListaMovimientos['filt_nroComprobante']);
	$('#monto').val(filtListaMovimientos['filt_monto']);
	document.getElementById('estadoP').checked = filtListaMovimientos['filt_estadoP'];
	document.getElementById('estadoC').checked = filtListaMovimientos['filt_estadoC'];
}

function validarFiltrarLista(){
	if((document.getElementById('tipoMovimientoI').checked==false)&&(document.getElementById('tipoMovimientoE').checked==false)){
		dialogo('Debe seleccionar al menos un tipo de movimiento');
		return false;
	}
	
	if((document.getElementById('estadoP').checked==false)&&(document.getElementById('estadoC').checked==false)){
		dialogo('Debe seleccionar al menos un tipo de estado de movimiento');
		return false;
	}
	
	filtListaMovimientos['filt_tipoMovimientoIngreso'] = document.getElementById('tipoMovimientoI').checked;
	filtListaMovimientos['filt_tipoMovimientoEgreso'] = document.getElementById('tipoMovimientoE').checked;
	filtListaMovimientos['filt_fechaDesde'] = $('#fechaMovimientoDesde').val();
	filtListaMovimientos['filt_fechaHasta'] = $('#fechaMovimientoHasta').val();
	filtListaMovimientos['filt_idContacto'] = $('#idContacto').val();
	filtListaMovimientos['filt_idConcepto'] = $('#idConcepto').val();
	filtListaMovimientos['filt_observacion'] = $('#observacion').val();
	filtListaMovimientos['filt_tipoComprobante'] = $('#tipoComprobante').val();
	filtListaMovimientos['filt_nroComprobante'] = $('#nroComprobante').val();
	filtListaMovimientos['filt_monto'] = $('#monto').val();
	filtListaMovimientos['filt_estadoP'] = document.getElementById('estadoP').checked;
	filtListaMovimientos['filt_estadoC'] = document.getElementById('estadoC').checked;

	listarMovimientos();
}