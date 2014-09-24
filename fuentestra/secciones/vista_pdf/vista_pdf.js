function inicializar_vista_pdf(){
	if($('#mostrarDetallePdf').val()=='1'){
		$('#detallePdf').show();
		cargarSeccion($('#secPdf').val(),$('#aplPdf').val(),$('#paramsPdf').val(),'detallePdf');
	}
}
function datos_enviar_correo(){
	$('#enviarCorreoPdf').show();
	$('#botPdfCancelarEnviarEmail').show();
	$('#botPdfEnviarEmail').hide();
	
	$('#enviarCorreoPdf_formulario').show();
	$('#enviarCorreoPdf_enviando').hide();
	$('#enviarCorreoPdf_enviado').hide();
	
	$('#paraCorreoPdf').focus();
}
function cancelar_datos_enviar_correo(){
	$('#enviarCorreoPdf').hide();
	$('#botPdfCancelarEnviarEmail').hide();
	$('#botPdfEnviarEmail').show();
	$('#asuntoCorreoPdf').val('');
	$('#paraCorreoPdf').val('');
	$('#mensajeCorreoPdf').val('');
}
function enviarCorreoPdf(){
	var datos = new Array();
	datos['asunto'] = $('#asuntoCorreoPdf').val();
	datos['para'] = $('#paraCorreoPdf').val();
	datos['mensaje'] = $('#mensajeCorreoPdf').val();
	if(datos['asunto']==''){
		alert('Debes indicar el asunto del mensaje');
	}else if(datos['para']==''){
		alert('Debes indicar el e-mail del destinatario');
	}else if(datos['mensaje']==''){
		alert('Debes introducir un mensaje');
	}else{
		
		$('#enviandoParaCorreoPdf').html(datos['para']);
		$('#enviadoParaCorreoPdf').html(datos['para']);
	
		$('#botPdfCancelarEnviarEmail').hide();
		$('#enviarCorreoPdf_formulario').hide();
		$('#enviarCorreoPdf_enviando').show();
		$('#enviarCorreoPdf_enviado').hide();
		
		datos['urlPDF']=$('#urlPDF').val();
		rpcSeccion('vista_pdf','enviarPorCorreo',datos,'fn:posEnviarCorreoPdf();');
	}
}

function posEnviarCorreoPdf(){
	$('#enviarCorreoPdf_formulario').hide();
	$('#enviarCorreoPdf_enviando').hide();
	$('#enviarCorreoPdf_enviado').show();
	$('#paraCorreoPdf').val('');
}