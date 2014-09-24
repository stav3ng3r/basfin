function inicializar_archivos_seleccionar_una_imagen(){
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listadoImagenesSeleccionarUnaImagenCadenaBuscar').val();
	rpcSeccion('archivos','listarImagenesSeleccionarUnaImagen',datos,'id:listadoImagenesSeleccionarUnaImagen');
}

function seleccionarArchivoParaVistaPrevia(idArchivo){
	cerrarVentana();
	$('#propiedadVistaPreviaIdArchivo').val(idArchivo);
	mostrarVistaPreviaDeArchivoVinculado();
}