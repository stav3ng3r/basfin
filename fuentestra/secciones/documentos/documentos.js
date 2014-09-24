function inicializar_documentos(){
    vEtiquetasDocumento=explotarCadena($('#idsDocumentoFila').val(),',');
    mostrarOcultarFlechasMovimiento();
}

function irCrearDocumento(documento,formato){
	cargarSeccion('documentos','crear_documento','documento=' + documento + '&formato=' + formato,'ventana');
}

function irEliminarFilaDocumento(idFilaDocumento){
    dialogo('Confirma que desea eliminar la fila','si:eliminarFilaDocumento(' + idFilaDocumento + ');|no','eliminar');
}

function eliminarFilaDocumento(idFilaDocumento){
    var datos = new Array();
    datos['idFilaDocumento']=idFilaDocumento;
    rpcSeccion('documentos','eliminarFilaDocumento',datos,'');
    var vAuxEtiquetasDocumento = new Array();
    var i = 0;
    var c = 0;
    var b = 0;
    for(i=0;i<vEtiquetasDocumento.length;i++){
        if(b==1){
            $('#documentoEtiqueta' + i).html($('#documentoEtiqueta' + (i+1)).html());
        }
        if(vEtiquetasDocumento[i]==idFilaDocumento){
            b = 1;
        }else{
            vAuxEtiquetasDocumento[c]=vEtiquetasDocumento[i];
            c++;
        }
    }
    document.getElementById('contenedorDocumento').removeChild(document.getElementById('documentoEtiqueta' + vEtiquetasDocumento.length));
    vEtiquetasDocumento=vAuxEtiquetasDocumento;
    mostrarOcultarFlechasMovimiento();
}

function ordenarFilaDocumento(idFilaDocumento,tipoMovimiento){    
    var datos = new Array();
    var i = 0;
    var orden = 0;
    for(i=0;i<vEtiquetasDocumento.length;i++){
        if(vEtiquetasDocumento[i]==idFilaDocumento){
            orden = i+1;
        }
    }
    
    var guardaIdFila = 0;
    var guardaHtmlFila = '';
    
    if(tipoMovimiento=='bajar'){
        orden++;
        tipoMovimiento='subir';
    }
    
    if(tipoMovimiento=='subir'){
        datos['idFilaDocumento']=vEtiquetasDocumento[orden-1];
        guardaIdFila = vEtiquetasDocumento[orden-2];
        guardaHtmlFila = $('#documentoEtiqueta' + (orden-1)).html();
 
        vEtiquetasDocumento[orden-2] = vEtiquetasDocumento[orden-1];
        $('#documentoEtiqueta' + (orden-1)).html($('#documentoEtiqueta' + orden).html());
        
        vEtiquetasDocumento[orden-1] = guardaIdFila; 
        $('#documentoEtiqueta' + orden).html(guardaHtmlFila); 
    }
    rpcSeccion('documentos','subirOrdenFilaDocumento',datos,'');
    mostrarOcultarFlechasMovimiento();
}

function mostrarOcultarFlechasMovimiento(){
    for(i=1;i<=vEtiquetasDocumento.length;i++){
        $('#documentoEtiqueta' + i + ' .bajar').show();
        $('#documentoEtiqueta' + i + ' .subir').show();
    }
    $('#documentoEtiqueta' + vEtiquetasDocumento.length + ' .bajar').hide();
    $('#documentoEtiqueta1 .subir').hide();
}

function obtenerOrdenetiquetaDocumento(idDocumentoFila){
    var i=0;
    for(i=0;i<vEtiquetasDocumento.length;i++){
        if(vEtiquetasDocumento[i]==idDocumentoFila){
            return i+1;
        }
    }
}

function valoresEtiquetas(){
    var i=0;
    var cadena = '';
    for(i=0;i<vEtiquetasDocumento.length;i++){
        if(cadena!=''){
            cadena+=',';
        }
        cadena += vEtiquetasDocumento[i];
    }
    alert(cadena);
} 