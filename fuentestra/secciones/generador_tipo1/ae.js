function inicializar_generador_tipo1_ae(){
	denominar('generador_tipo1','t1Denominar',$('#genT1AgEd_seleccionarInput').val(),'genT1AgEd_seleccionarHtml'); //--x-
	//--e->inicializarDenominars
	//--e->focusPrimerInput
	
	//--e->adjuntarArchivos
}

function agregarEditarGenT1(){
	var datos = new Array();
	datos['idT1Edit'] = $('#genT1AgEd_idT1Edit').val();
	datos['text'] = $('#genT1AgEd_text').val(); //--x-
	datos['integer'] = $('#genT1AgEd_integer').val(); //--x-
	datos['bigint'] = $('#genT1AgEd_bigint').val(); //--x-
	datos['decimal'] = $('#genT1AgEd_decimal').val(); //--x-
	datos['date'] = $('#genT1AgEd_date').val(); //--x-
	datos['select'] = $('#genT1AgEd_select').val(); //--x-
	datos['textarea'] = $('#genT1AgEd_textarea').val(); //--x-
	datos['radio'] = $('[name=genT1AgEd_radio]:checked').val(); //--x-
	datos['checkbox'] = $('#genT1AgEd_checkbox').prop('checked'); //--x-
	datos['seleccionar'] = $('#genT1AgEd_seleccionarInput').val(); //--x-
	datos['adjuntar'] = $('.traUploadImagenes').traAdjuntos(); //--x-
	//--e->obtencionValoresInputs
	
	//--e->verificacionDeCamposObligatorios
	if(datos['text']=='' || datos['seleccionar']=='' || datos['integer']=='' || datos['decimal']=='' || datos['date']=='' || datos['select']==''  || datos['textarea']=='' || datos['radio']==''){ //--x-
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('generador_tipo1','t1AgregarEditar',datos,'fn:posAgregarEditarGenT1();');
	}
}

function posAgregarEditarGenT1(){
	listarGenT1();
	var idT1Edit = $('#genT1AgEd_idT1Edit').val();
	if(idT1Edit!=''){
		cerrarVentana();
	}else{
		dialogo('Desea agregar otro registro','si:limpiarCamposGenT1();|no:cerrarVentana();','pregunta');	
	}
}

function limpiarCamposGenT1(){
	$('#genT1AgEd_text').val(''); //--x-
	$('#genT1AgEd_seleccionarInput').val(''); //--x-
	$('#genT1AgEd_seleccionarHtml').html(''); //--x-
	$('#genT1AgEd_integer').val(''); //--x-
	$('#genT1AgEd_bigint').val(''); //--x-
	$('#genT1AgEd_decimal').val(''); //--x-
	$('#genT1AgEd_date').val(''); //--x-
	$('#genT1AgEd_select').val(''); //--x-
	$('#genT1AgEd_textarea').val(''); //--x-
	$('[name=genT1AgEd_radio]').prop('checked',false); //--x-
	$('#genT1AgEd_checkbox').prop('checked',false); //--x-
	$('#genT1AgEd_idT1').val(''); //--x-
	//--e->limpiarCamposAe
	//--e->focusPrimerInput
}