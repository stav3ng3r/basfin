var valorCookieRubroCategoria;

function inicializar_rubros_rubro_categoria_ae(){
	$('#rubrRubrosCategoriasAgEd_rubroCategoria').focus();
	
	if ($.cookie('valor')) {
		valorCookieRubroCategoria = $.cookie('valor');
		$.removeCookie('valor');
		$('#rubrRubrosCategoriasAgEd_rubroCategoria').val($('#'+valorCookieRubroCategoria).val());
	}	
}

function agregarEditarRubrosRubrosCategorias(){
	var datos = new Array();
	datos['idRubroCategoriaEdit'] = $('#rubrRubrosCategoriasAgEd_idRubroCategoriaEdit').val();
	datos['rubroCategoria'] = $('#rubrRubrosCategoriasAgEd_rubroCategoria').val();
	datos['descripcion'] = $('#rubrRubrosCategoriasAgEd_descripcion').val();
	
	if(datos['rubroCategoria']=='') {
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('rubros','rubroCategoriaAgregarEditar',datos,'fn:posAgregarEditarRubrosRubrosCategorias();');
	}
}

function posAgregarEditarRubrosRubrosCategorias(){
	var row=rowRPC;
	if (valorCookieRubroCategoria == null) {	
		listarRubrosRubrosCategorias();
		var idRubroCategoriaEdit = $('#rubrRubrosCategoriasAgEd_idRubroCategoriaEdit').val();
		if(idRubroCategoriaEdit!=''){
			cerrarVentana();
		}else{
			dialogo('Desea agregar otro registro','si:limpiarCamposRubrosRubrosCategorias();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
		}
	} else {
		$('#'+valorCookieRubroCategoria).val($('#rubrRubrosCategoriasAgEd_rubroCategoria').val()).focus();
		$('#'+valorCookieRubroCategoria+'Id').val(row['idRubroCategoria']);
		checkAutocompletar(valorCookieRubroCategoria);
		cerrarVentana();
	}		
}

function limpiarCamposRubrosRubrosCategorias(){
	$('#rubrRubrosCategoriasAgEd_rubroCategoria').val('');
	$('#rubrRubrosCategoriasAgEd_descripcion').val('');
	$('#rubrRubrosCategoriasAgEd_rubroCategoria').focus();
}