var valorCookieCategoria;

function inicializar_sistema_categoria_ae(){
	$('#sistCategoriasAgEd_categoria').focus();
	
	if ($.cookie('valor')) {
		valorCookieCategoria = $.cookie('valor');
		$.removeCookie('valor');
		$('#sistCategoriasAgEd_categoria').val($('#'+valorCookieCategoria).val());
	}	
}

function agregarEditarSistemaCategorias(){
	var datos = new Array();
	datos['idCategoriaEdit'] = $('#sistCategoriasAgEd_idCategoriaEdit').val();
	datos['categoria'] = $('#sistCategoriasAgEd_categoria').val();
	
	if(datos['categoria']=='') {
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('sistema','categoriaAgregarEditar',datos,'fn:posAgregarEditarSistemaCategorias();');
	}
}

function posAgregarEditarSistemaCategorias(){
	var row=rowRPC;
	if (valorCookieCategoria == null) {	
		listarSistemaCategorias();
		var idCategoriaEdit = $('#sistCategoriasAgEd_idCategoriaEdit').val();
		if(idCategoriaEdit!=''){
			cerrarVentana();
		}else{
			dialogo('Desea agregar otro registro','si:limpiarCamposSistemaCategorias();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
		}
	} else {
		$('#'+valorCookieCategoria).val($('#sistCategoriasAgEd_categoria').val()).focus();
		$('#'+valorCookieCategoria+'Id').val(row['idCategoria']);
		checkAutocompletar(valorCookieCategoria);
		cerrarVentana();
	}		
}

function limpiarCamposSistemaCategorias(){
	$('#sistCategoriasAgEd_categoria').val('');
	$('#sistCategoriasAgEd_categoria').focus();
}