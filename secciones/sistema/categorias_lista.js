function inicializar_sistema_categorias_lista(){
	listarSistemaCategorias();
}

function listarSistemaCategorias(){
	cargando('listaCategoria',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaCategoriaCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaCategoriaAccionPosSeleccionar').val();
	rpcSeccion('sistema','categoriasListar',datos,'id:listaCategoria');
}

function eliminarCategoria(idCategoria){
	cerrarDialogo();
	var datos = new Array();
	datos['idCategoria'] = idCategoria;
	rpcSeccion('sistema','categoriaEliminar',datos,'fn:listarSistemaCategorias();');
}