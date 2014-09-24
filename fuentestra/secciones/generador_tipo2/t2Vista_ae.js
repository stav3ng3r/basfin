function inicializar_generador_tipo2_t2Vista_ae(){
	denominar('generador_tipo2','t2Denominar',$('#genT2VisAgEd_seleccionarInput').val(),'genT2VisAgEd_seleccionarHtml'); //--x-
	//--e->inicializarDenominars:2
	//--e->focusPrimerInput:2
}

function agregarEditarGenT2Vista(){
	var datos = new Array();
	datos['idT2'] = $('#genT2Vista_idT2').val();
	datos['idT2VistaEdit'] = $('#genT2VisAgEd_idT2VistaEdit').val();
	datos['text'] = $('#genT2VisAgEd_text').val(); //--x-
	datos['integer'] = $('#genT2VisAgEd_integer').val(); //--x-
	datos['bigint'] = $('#genT2VisAgEd_bigint').val(); //--x-
	datos['decimal'] = $('#genT2VisAgEd_decimal').val(); //--x-
	datos['date'] = $('#genT2VisAgEd_date').val(); //--x-
	datos['select'] = $('#genT2VisAgEd_select').val(); //--x-
	datos['textarea'] = $('#genT2VisAgEd_textarea').val(); //--x-
	datos['radio'] = $('[name=genT2VisAgEd_radio]:checked').val(); //--x-
	datos['checkbox'] = $('#genT2VisAgEd_checkbox').prop('checked'); //--x-
	datos['idT2Vista'] = $('#genT2VisAgEd_idT2Vista').val(); //--x-
	datos['seleccionar'] = $('#genT2VisAgEd_seleccionarInput').val(); //--x-
	//--e->obtencionValoresInputs:2
	
	//--e->verificacionDeCamposObligatorios:2
	if(datos['text']=='' || datos['seleccionar']=='' || datos['integer']=='' || datos['bigint']=='' || datos['decimal']=='' || datos['date']=='' || datos['select']==''  || datos['textarea']=='' || datos['radio']==''){ //--x-
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('generador_tipo2','t2VistaAgregarEditar',datos,'fn:posAgregarEditarGenT2Vista();');
	}
}

function posAgregarEditarGenT2Vista(){
	listarGenT2Vista();
	var idT2VistaEdit = $('#genT2VisAgEd_idT2VistaEdit').val();
	if(idT2VistaEdit!=''){
		cerrarVentana();
	}else{
		dialogo('Desea agregar otro registro','si:limpiarCamposGeneradorT2Vista();|no:cerrarVentana();','pregunta');	
	}
}

function limpiarCamposGeneradorT2Vista(){
	$('#genT2VisAgEd_text').val(''); //--x-
	$('#genT2VisAgEd_seleccionarInput').val(''); //--x-
	$('#genT2VisAgEd_seleccionarHtml').html(''); //--x-
	$('#genT2VisAgEd_integer').val(''); //--x-
	$('#genT2VisAgEd_bigint').val(''); //--x-
	$('#genT2VisAgEd_decimal').val(''); //--x-
	$('#genT2VisAgEd_date').val(''); //--x-
	$('#genT2VisAgEd_select').val(''); //--x-
	$('#genT2VisAgEd_textarea').val(''); //--x-
	$('[name=genT2VisAgEd_radio]').prop('checked',false); //--x-
	$('#genT2VisAgEd_checkbox').prop('checked',false); //--x-
	$('#genT2VisAgEd_idT2Vista').val(''); //--x-
	//--e->limpiarCamposAe:2
	//--e->focusPrimerInput:2
}