function inicializar_archivos_propiedades(){
	mostrarOcultarPropiedadesValidas();
	mostrarOcultarInputEnlaces();
}

function mostrarOcultarPropiedadesValidas(){	
	$('#propiedadFilaVistaPrevia').hide();
	$('#propiedadFilaEnlace').hide();
	$('#propiedadFilaPermitirDescargar').hide();
	$('#propiedadFilaAmpliar').hide();
	$('#propiedadFilaFirma').hide();

	var tipo = $('#editPropiedad_tipo').val();
	if(tipo=='flv'){
		$('#propiedadFilaVistaPrevia').show();
		$('#propiedadFilaPermitirDescargar').show();
		mostrarVistaPreviaDeArchivoVinculado();
	}else if((tipo=='jpg')||(tipo=='gif')||(tipo=='png')){
		$('#propiedadFilaEnlace').show();
		$('#propiedadFilaPermitirDescargar').show();
		$('#propiedadFilaAmpliar').show();
		$('#propiedadFilaFirma').show();
	}else if(tipo=='pdf'){
		$('#propiedadFilaVistaPrevia').show();
		mostrarVistaPreviaDeArchivoVinculado();
	}else if(tipo=='mp3'){
		$('#propiedadFilaVistaPrevia').show();
		$('#propiedadFilaPermitirDescargar').show();
		mostrarVistaPreviaDeArchivoVinculado();
	}
}

function mostrarOcultarInputEnlaces(){
	var checkEnlace = document.getElementById('checkEnlace').checked;
	if(checkEnlace==true){
		$('#propiedadEnlace').show();	
	}else{
		$('#propiedadEnlace').hide();
	}
}

function aplicarPropiedadesArchivo(){
	var checkEnlace = document.getElementById('checkEnlace').checked;
	var datos = new Array();
	datos['idArchivo'] = $('#editPropiedad_idArchivo').val();
	datos['idArchivoVistaPrevia'] = $('#propiedadVistaPreviaIdArchivo').val();
	datos['enlace'] = $('#propiedadEnlace').val();
	datos['permitirDescargar'] = document.getElementById('propiedadPermitirDescargar').checked;
	datos['ampliar'] = $('#propiedadAmpliar').val();
	datos['firma'] = $('#propiedadFirma').val();
	if(checkEnlace==false){
		datos['enlace'] = '';
	}
	rpcSeccion('archivos','aplicarPropiedadesArchivo',datos,'fn:cerrarVentana();');
}

function mostrarVistaPreviaDeArchivoVinculado(){
	var datos = new Array();
	datos['idArchivo'] = $('#propiedadVistaPreviaIdArchivo').val();
	rpcSeccion('archivos','mostrarVistaPreviaDeArchivoVinculado',datos,'id:vistaArchVinc');
}

function mostrarVistaAmpliadaDeArchivoVinculado(){
	var idArchivo = $('#propiedadVistaPreviaIdArchivo').val();
	cargarSeccion('archivos','ampliar_multimedia','idArchivo=' + idArchivo,'ventana');
}

function desvincularImagenVistaPrevia(){
	$('#propiedadVistaPreviaIdArchivo').val('');
	$('#vistaArchVinc').html('');
}