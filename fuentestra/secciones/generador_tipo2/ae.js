function inicializar_generador_tipo2_ae(){
	denominar('generador_tipo2','t2Denominar',$('#genT2AgEd_seleccionarInput').val(),'genT2AgEd_seleccionarHtml'); //--x-
	//--e->inicializarDenominars
	//--e->focusPrimerInput
}

function agregarEditarGenT2(){
	var datos = new Array();
	datos['idT2Edit'] = $('#genT2AgEd_idT2Edit').val();
	datos['text'] = $('#genT2AgEd_text').val(); //--x-
	datos['integer'] = $('#genT2AgEd_integer').val(); //--x-
	datos['bigint'] = $('#genT2AgEd_bigint').val(); //--x-
	datos['decimal'] = $('#genT2AgEd_decimal').val(); //--x-
	datos['date'] = $('#genT2AgEd_date').val(); //--x-
	datos['select'] = $('#genT2AgEd_select').val(); //--x-
	datos['textarea'] = $('#genT2AgEd_textarea').val(); //--x-
	datos['radio'] = $('[name=genT2AgEd_radio]:checked').val(); //--x-
	datos['checkbox'] = $('#genT2AgEd_checkbox').prop('checked'); //--x-
	datos['seleccionar'] = $('#genT2AgEd_seleccionarInput').val(); //--x-
	//--e->obtencionValoresInputs
	
	//--e->verificacionDeCamposObligatorios
	if(datos['text']=='' || datos['seleccionar']=='' || datos['integer']=='' || datos['decimal']=='' || datos['date']=='' || datos['select']==''  || datos['textarea']=='' || datos['radio']==''){ //--x-
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('generador_tipo2','t2AgregarEditar',datos,'fn:posAgregarEditarGenT2();');
	}
}

function posAgregarEditarGenT2(){
	var row = rowRPC;
	cerrarVentana();
	cargarSeccion('generador_tipo2','vista','idT2='+row['id']);
}