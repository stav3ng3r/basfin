function crearDocumento(documento,formato){
	var titulo = $('#tituloDocumento').val();
	var permitirEditar = document.getElementById('permitirEditar').checked;
	var permitirOrdenar = document.getElementById('permitirOrdenar').checked;
	if(titulo==''){
		dialogo('Debes ingresar el título del documento');
	}else{
		var datos = new Array();
		datos['documento'] = documento;
		datos['formato'] = formato;
		datos['titulo'] = titulo;
        datos['permitirEditar'] = permitirEditar;
        datos['permitirOrdenar'] = permitirOrdenar;
		rpcSeccion('documentos','crearDocumento',datos,'fn:cargarDocumentoNuevo();');
	}
}
function cargarDocumentoNuevo(){
	var row = rowRPC;
	cargarSeccion('documentos','','documento=' + row['documento']);
    cerrarVentana();
}