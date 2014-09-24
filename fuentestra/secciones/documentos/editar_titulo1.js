function inicializar_documentos_editar_titulo1(){
    mostrarOcultarInputTitulos1();
}

function mostrarOcultarInputTitulos1(){
    var presentacion = $('#presentacionTitulo1').val();

    if(presentacion=='normal'){
        $('#tdColumna2').hide();
        $('#tdColumna3').hide();
        $('#titulo1Columna1Editando').css('width','400px');
    }
    if(presentacion=='2columnas'){
        $('#tdColumna2').show();
        $('#tdColumna3').hide();
        $('#titulo1Columna1Editando').css('width','300px');
        $('#titulo1Columna2Editando').css('width','300px');
    }
    if(presentacion=='3columnas'){
        $('#tdColumna2').show();
        $('#tdColumna3').show();
        $('#titulo1Columna1Editando').css('width','200px');
        $('#titulo1Columna2Editando').css('width','200px');
        $('#titulo1Columna3Editando').css('width','200px');
    }
}

function editarDocumentoTitulo1(){
    var idDocumentoFila = $('#idFilaDocumentoEditando').val();
    var presentacion = $('#presentacionTitulo1').val();
    var tituloCol1 = $('#titulo1Columna1Editando').val();
    var tituloCol2 = $('#titulo1Columna2Editando').val();
    var tituloCol3 = $('#titulo1Columna3Editando').val();
    
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
        rpcSeccion('documentos','editarInfosFilaDocumento',datos,'fn:posEditarDocumentoTitulo1();');
        cerrarVentana();
    }
}

function posEditarDocumentoTitulo1(){
    var row = rowRPC;
    $('#documentoEtiqueta' + row['orden']).html(row['html']);
}