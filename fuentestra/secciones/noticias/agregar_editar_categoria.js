function validarFormCategoriaNoticia(){
	var idCategoria = $('#idCategoria').val();
	var categoria = $('#categoria').val();
	if(categoria==''){
		dialogo('Debe ingresar el nombre de la categoría');
	}else{
		var datos = new Array();
		datos['idCategoria']=idCategoria;
		datos['categoria']=categoria;
		if(idCategoria==''){
			rpcSeccion('noticias','insertarCategoria',datos,'fn:posInsertarCategoriaNoticia();');
		}else{
			rpcSeccion('noticias','editarCategoria',datos,'fn:listarNoticiaCategorias();cerrarVentana(' + nivelVentana + ');');
		}
	}
}

function posInsertarCategoriaNoticia(){
	listarNoticiaCategorias();
	dialogo('La categoría se ha sagregado exitósamente, desea agregar otra categoria','si:limpiarFormularioCategoriaNoticia();|no:cerrarVentana(' + nivelVentana + ');','ok');	
}

function limpiarFormularioCategoriaNoticia(){
	$('#categoria').val('');
}