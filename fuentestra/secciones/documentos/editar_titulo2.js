function inicializar_documentos_editar_titulo2(){
    mostrarOcultarInputTitulos2();
}

function mostrarOcultarInputTitulos2(){
    var presentacion = $('#presentacionTitulo2').val();

    if(presentacion=='normal'){
        $('#tdColumna2').hide();
        $('#tdColumna3').hide();
        $('#titulo2Columna1Editando').css('width','400px');
    }
    if(presentacion=='2columnas'){
        $('#tdColumna2').show();
        $('#tdColumna3').hide();
        $('#titulo2Columna1Editando').css('width','300px');
        $('#titulo2Columna2Editando').css('width','300px');
    }
    if(presentacion=='3columnas'){
        $('#tdColumna2').show();
        $('#tdColumna3').show();
        $('#titulo2Columna1Editando').css('width','200px');
        $('#titulo2Columna2Editando').css('width','200px');
        $('#titulo2Columna3Editando').css('width','200px');
    }
}

function editarDocumentoTitulo2(){
    var idDocumentoFila = $('#idFilaDocumentoEditando').val();
    var presentacion = $('#presentacionTitulo2').val();
    var tituloCol1 = $('#titulo2Columna1Editando').val();
    var tituloCol2 = $('#titulo2Columna2Editando').val();
    var tituloCol3 = $('#titulo2Columna3Editando').val();
    
    var mensajeDialogo = '';
    if(presentacion=='normal'){
        if(tituloCol1==''){
            mensajeDialogo='Debes insertar el titulo';
        }
    }
    if(presentacion=='2columnas'){
        if((tituloCol1=='')||(tituloCol2=='')){
            mensajeDialogo='Debes insertar los 2 titulos';
        }
    }
    if(presentacion=='3columnas'){
        if((tituloCol1=='')||(tituloCol2=='')||(tituloCol3=='')){
            mensajeDialogo='Debes insertar los 3 titulos';
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
        rpcSeccion('documentos','editarInfosFilaDocumento',datos,'fn:posEditarDocumentoTitulo2();');
        cerrarVentana();
    }
}

function posEditarDocumentoTitulo2(){
    var row = rowRPC;
    $('#documentoEtiqueta' + row['orden']).html(row['html']);
}