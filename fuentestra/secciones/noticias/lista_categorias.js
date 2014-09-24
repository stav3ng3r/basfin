function inicializar_noticias_lista_categorias(){
	listarNoticiaCategorias();
}

function listarNoticiaCategorias(){
	var datos = new Array();
	datos['idsCategorias']=$('#onLoadPreSeleccionarCategorias').val();
	rpcSeccion('noticias','listarCategorias',datos,'id:listaNoticiaCategorias');
}

function irEliminarCategoriaNoticia(idCategoria){
	dialogo('Esta seguro que desea eliminar la categoría seleccionada?','si:eliminarCategoriaNoticia(' + idCategoria + ');|no','eliminar');
}

function eliminarCategoriaNoticia(idCategoria){
	var datos = new Array();
	datos['idCategoria']=idCategoria;
	rpcSeccion('noticias','eliminarCategoria',datos,'fn:listarNoticiaCategorias();');
}

function aceptarSeleccionNoticiaCategoria(){
	var elementos = document.getElementsByName('idCategoriaNoticiaLista');
	var idsCategorias='';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked==true){
			if(idsCategorias!=''){idsCategorias+=',';}
			idsCategorias+=elementos[x].value;	
		}
	}
	cargarRelNoticiaCategorias(idsCategorias);
	cerrarVentana(nivelVentana);
}