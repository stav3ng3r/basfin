function inicializar_rubros_rubros_categorias_lista(){
	listarRubrosRubrosCategorias();
}

function listarRubrosRubrosCategorias(){
	cargando('listaRubroCategoria',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaRubroCategoriaCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaRubroCategoriaAccionPosSeleccionar').val();
	rpcSeccion('rubros','rubrosCategoriasListar',datos,'id:listaRubroCategoria');
}

function eliminarRubroCategoria(idRubroCategoria){
	cerrarDialogo();
	var datos = new Array();
	datos['idRubroCategoria'] = idRubroCategoria;
	rpcSeccion('rubros','rubroCategoriaEliminar',datos,'fn:listarRubrosRubrosCategorias();');
}