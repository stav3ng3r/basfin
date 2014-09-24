function inicializar_archivos_categorias(){
	listarCategoriasArchivo()	
}
function agregarEditarCategoriaArchivo(id){
	if(id==null){id='';}
	cargarSeccion('archivos','agregar_editar_categoria','id=' + id,'ventana');
}
function listarCategoriasArchivo(){
	rpcSeccion('archivos','listarCategorias','','id:listaCategoriasArchivo');
}
function eliminarCategoriaArchivo(id){
	rpcSeccion('archivos','cargarSelectCategoriasArchivo','','id:idArchivoCategoria');
	dialogo('Estas seguro de eliminar esta categoria?','si:eliminarCategoriaArchivoSi(' + id + ');|no','eliminar');
}
function eliminarCategoriaArchivoSi(id){
	var datos = new Array();
	datos['id']=id;
	rpcSeccion('archivos','eliminarCategoria',datos,'fn:listarCategoriasArchivo();');	
}