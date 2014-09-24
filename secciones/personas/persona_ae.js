var valorCookiePersona;

function inicializar_personas_persona_ae(){
	$('#persPersonasAgEd_identificador').focus();
	
	if ($.cookie('valor')) {
		valorCookiePersona = $.cookie('valor');
		$.removeCookie('valor');
		$('#persPersonasAgEd_persona').val($('#'+valorCookiePersona).val());	
	}
}

function agregarEditarPersonasPersonas(){
	var datos = new Array();
	datos['idPersonaEdit'] = $('#persPersonasAgEd_idPersonaEdit').val();
	datos['identificador'] = $('#persPersonasAgEd_identificador').val();
	datos['persona'] = $('#persPersonasAgEd_persona').val();
	datos['direccion'] = $('#persPersonasAgEd_direccion').val();
	datos['telefono'] = $('#persPersonasAgEd_telefono').val();
	datos['correo'] = $('#persPersonasAgEd_correo').val();
	datos['nacimiento'] = $('#persPersonasAgEd_nacimiento').val();
	datos['observacion'] = $('#persPersonasAgEd_observacion').val();
	
	if(datos['idProyecto']=='') {
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('personas','personaAgregarEditar',datos,'fn:posAgregarEditarPersonasPersonas();');
	}
}

function posAgregarEditarPersonasPersonas(){
	var row=rowRPC;
	if (valorCookiePersona == null) {	
		listarPersonasPersonas();
		var idPersonaEdit = $('#persPersonasAgEd_idPersonaEdit').val();
		if(idPersonaEdit!=''){
			cerrarVentana();
		}else{
			dialogo('Desea agregar otro registro','si:limpiarCamposPersonasPersonas();|no','pregunta');	
		}
	} else {
		$('#'+valorCookiePersona).val($('#persPersonasAgEd_persona').val());
		$('#'+valorCookiePersona+'Id').val(row['idPersona']);
		checkAutocompletar(valorCookiePersona);
		$('#'+valorCookiePersona).focus();
		cerrarVentana();
	}		
}

function limpiarCamposPersonasPersonas(){
	cerrarDialogo();
	
	$('#persPersonasAgEd_identificador').val('');
	$('#persPersonasAgEd_persona').val('');
	$('#persPersonasAgEd_direccion').val('');
	$('#persPersonasAgEd_telefono').val('');
	$('#persPersonasAgEd_correo').val('');
	$('#persPersonasAgEd_nacimiento').val('');
	$('#persPersonasAgEd_observacion').val('');
	$('#persPersonasAgEd_identificador').focus();
}