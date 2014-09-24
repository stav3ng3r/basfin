function inicializar_documentos_editar_parrafo(){
    mostrarOcultarTextAreaParrafos();
}

function mostrarOcultarTextAreaParrafos(){
    var presentacion = $('#presentacionParrafo').val();

    if(presentacion=='normal'){
        $('#tdColumna2').hide();
        $('#tdColumna3').hide();
        $('#parrafoColumna1Editando').css('width','400px');
    }
    if(presentacion=='2columnas'){
        $('#tdColumna2').show();
        $('#tdColumna3').hide();
        $('#parrafoColumna1Editando').css('width','300px');
        $('#parrafoColumna2Editando').css('width','300px');
    }
    if(presentacion=='3columnas'){
        $('#tdColumna2').show();
        $('#tdColumna3').show();
        $('#parrafoColumna1Editando').css('width','200px');
        $('#parrafoColumna2Editando').css('width','200px');
        $('#parrafoColumna3Editando').css('width','200px');
    }
}

function editarDocumentoParrafo(){
    var idDocumentoFila = $('#idFilaDocumentoEditando').val();
    var presentacion = $('#presentacionParrafo').val();
    var tituloCol1 = $('#parrafoColumna1Editando').val();
    var tituloCol2 = $('#parrafoColumna2Editando').val();
    var tituloCol3 = $('#parrafoColumna3Editando').val();
    
    var mensajeDialogo = '';
    if(presentacion=='normal'){
        if(tituloCol1==''){
            mensajeDialogo='Debes insertar el contenido';
        }
    }
    if(presentacion=='2columnas'){
        if((tituloCol1=='')||(tituloCol2=='')){
            mensajeDialogo='Debes insertar los 2 contenidos';
        }
    }
    if(presentacion=='3columnas'){
        if((tituloCol1=='')||(tituloCol2=='')||(tituloCol3=='')){
            mensajeDialogo='Debes insertar los 3 contenidos';
        }
    }
    if(mensajeDialogo!=''){
        dialogo(mensajeDialogo);
    }else{
        $('#documentoEtiqueta' + obtenerOrdenetiquetaDocumento(idDocumentoFila)).html('<table align="center"><tr><td>actualizando información...</td><td><img src="fuentestra/imagenes/loader/ajax-loader-circ-c-gris.gif" /></td></tr></table>');
        var datos = new Array();
        datos['idDocumentoFila'] = idDocumentoFila;
        datos['presentacion'] = presentacion;
        datos['textoCol1'] = tituloCol1;
        datos['textoCol2'] = tituloCol2;
        datos['textoCol3'] = tituloCol3;
        rpcSeccion('documentos','editarInfosFilaDocumento',datos,'fn:posEditarDocumentoParrafo();');
        cerrarVentana();
    }
}

function posEditarDocumentoParrafo(){
    var row = rowRPC;
    $('#documentoEtiqueta' + row['orden']).html(row['html']);
}