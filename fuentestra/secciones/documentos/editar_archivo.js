function inicializar_documentos_editar_archivo(){
    cListaRelArchivos=0;
    cargarListadoRelArchivos_desdeDocumentoArchivo();
}

function procesarEditarDocumentoArchivo(){
    var idDocumentoFila = $('#idFilaDocumentoEditando').val();
    var presentacion = $('#presentacionArchivo').val();
    var idsArchivos = obtenerIdsArchivosDeListadoRelArchivos();
    if(idsArchivos==''){
        dialogo='Debe seleccionar al menos un archivo';
    }else{
        $('#documentoEtiqueta' + obtenerOrdenetiquetaDocumento(idDocumentoFila)).html('<table align="center"><tr><td>actualizando información...</td><td><img src="fuentestra/imagenes/loader/ajax-loader-circ-c-gris.gif" /></td></tr></table>');
        var datos = new Array();
        datos['idDocumentoFila'] = idDocumentoFila;
        datos['presentacion'] = presentacion;
        datos['idsArchivos'] = idsArchivos;
        rpcSeccion('documentos','editarInfosFilaDocumento',datos,'fn:posEditarDocumentoArchivo();');
        cerrarVentana();
    }
}

function posEditarDocumentoArchivo(){
    var row = rowRPC;
    $('#documentoEtiqueta' + row['orden']).html(row['html']);
}

function cargarListadoRelArchivos_desdeDocumentoArchivo(){
	var idsArchivos = $('#onLoadRelFilaArchivos').val();
	if(idsArchivos!=''){
		var datos = new Array();
		datos['idsArchivos'] = idsArchivos;
		datos['cListaRelArchivos']=cListaRelArchivos;
		rpcSeccion('archivos','agregarListadoRelArchivos',datos,'fn:cargarListadoRelArchivos()');
	}
}