function inicializar_documentos_editar_editor_formato(){
    agregarFuncionJs('fuentestra/funciones/js/editor/ckeditor/ckeditor.js','aplicarEditor();');
}

function aplicarEditor(){
    
    removerEditor();
    
	if ( editor )
		return;

	var html = document.getElementById( 'editorcontents' ).innerHTML;

	// Create a new editor inside the <div id="editor">, setting its value to html
	var config = {};
	editor = CKEDITOR.appendTo( 'documentoCodigoFormatoEditando', config, html );
}

function editarDocumentoEditorFormato(){
	var codigoHtml = editor.getData();
    if(codigoHtml==''){
        dialogo('Debe ingresar alguna información');
    }else{
        var idDocumentoFila = $('#idFilaDocumentoEditando').val();
        $('#documentoEtiqueta' + obtenerOrdenetiquetaDocumento(idDocumentoFila)).html('<table align="center"><tr><td>actualizando información...</td><td><img src="fuentestra/imagenes/loader/ajax-loader-circ-c-gris.gif" /></td></tr></table>');
        var datos = new Array();
        datos['idDocumentoFila'] = idDocumentoFila; 
        datos['textoCol1'] = codigoHtml;
        rpcSeccion('documentos','editarInfosFilaDocumento',datos,'fn:posEditarDocumentoEditorFormato();');
        removerEditor();
        cerrarVentana();
    }
}

function posEditarDocumentoEditorFormato(){
    var row = rowRPC;
    $('#documentoEtiqueta' + row['orden']).html(row['html']);
}

function removerEditor(){
	if ( !editor )
		return;

	// Retrieve the editor contents. In an Ajax application, this data would be
	// sent to the server or used in any other way.
	document.getElementById( 'editorcontents' ).innerHTML = editor.getData();
	//document.getElementById( 'contents' ).style.display = '';

	// Destroy the editor.
	editor.destroy();
	editor = null;
}