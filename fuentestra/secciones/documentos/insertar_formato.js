function insertarFormatoEnDocumento(idDocumentoFila){
    var idDocumento = $('#idDocumento').val();
    if(idDocumentoFila==null){idDocumentoFila='';}
    var formato = $('#formatoFilaDocumento').val();
    var permitirEditar = document.getElementById('permitirEditar').checked;
    var permitirOrdenar = document.getElementById('permitirOrdenar').checked;
    if(formato==''){
        dialogo('Debes seleccionar un tipo de formato');
    }else{
        
        cerrarVentana();
        if(idDocumentoFila==''){
            $('#contenedorDocumento').html('<div class="etiquetaDocumento" id="documentoEtiqueta1"><table align="center"><tr><td>insertando formato...</td><td><img src="fuentestra/imagenes/loader/ajax-loader-circ-c-gris.gif" /></td></tr></table></div>');
            vEtiquetasDocumento[0]=0;
        }else{
            $('#contenedorDocumento').html($('#contenedorDocumento').html()+'<div class="etiquetaDocumento" id="documentoEtiqueta' + (vEtiquetasDocumento.length + 1) + '"></div>');
            vEtiquetasDocumento[vEtiquetasDocumento.length]=0;
            for(i=vEtiquetasDocumento.length;i>=1;i--){
                if(vEtiquetasDocumento[i-1]!=idDocumentoFila){
                    $('#documentoEtiqueta' + i).html($('#documentoEtiqueta' + (i-1)).html());
                    vEtiquetasDocumento[i-1]=vEtiquetasDocumento[i-2];
                }else{
                    $('#documentoEtiqueta' + (i+1)).html('<table align="center"><tr><td>insertando formato...</td><td><img src="fuentestra/imagenes/loader/ajax-loader-circ-c-gris.gif" /></td></tr></table>');
                    i=0;
                }
            }
        }
		var datos = new Array();
		datos['idDocumento'] = idDocumento;
        datos['idDocumentoFila'] = idDocumentoFila;
		datos['formato'] = formato;
        datos['permitirEditar'] = permitirEditar;
        datos['permitirOrdenar'] = permitirOrdenar;
		rpcSeccion('documentos','insertarFormato',datos,'fn:insertarCodigoDeFormatoNuevoEnDocumento();');
    }
}

function insertarCodigoDeFormatoNuevoEnDocumento(){
    var row = rowRPC;
    $('#documentoEtiqueta' + row['orden']).html(row['htmlFormato']);
    vEtiquetasDocumento[row['orden']-1] = row['idDocumentoFila'];
    mostrarOcultarFlechasMovimiento();
    cargarSeccion('documentos','editar_' + row['formato'],'idFilaDocumento=' + row['idDocumentoFila'],'ventana');
}