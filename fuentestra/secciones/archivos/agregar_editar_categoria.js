function insertarEditarCategoriaArchivo(id){
	if(id==null){id='';}
	var datos = new Array();
	datos['id']=id;
	datos['nombreCategoria']=$('#nombreCategoria').val();
	if(datos['nombreCategoria']==''){
		dialogo('Debe completar todos los campos marcados con asterisco');
	}else{
		if(id==''){
			rpcSeccion('archivos','insertarCategoria',datos,'fn:posteriorInsertarCategoriaArchivo();');
		}else{
			rpcSeccion('archivos','editarCategoria',datos,'fn:posteriorEditarCategoriaArchivo();');
		}
	}
}

function posteriorInsertarCategoriaArchivo(){
	listarCategoriasArchivo();
	cargarSelectCategoriasArchivoVisibles();
	dialogo('La categoría se ha agregado exitósomante, desea agregar otra?','si:posteriorInsertarCategoriaArchivoSi();|no:posteriorInsertarCategoriaArchivoNo();','ok');
}
function posteriorInsertarCategoriaArchivoSi(){
	$('#nombreCategoria').val('');
}
function posteriorInsertarCategoriaArchivoNo(){
	cerrarVentana(nivelVentana-1);
}
function posteriorEditarCategoriaArchivo(){
	cerrarVentana(nivelVentana);
	listarCategoriasArchivo();
	cargarSelectCategoriasArchivoVisibles();
	dialogo('La categoría se ha editado exitósomante','aceptar','ok');
}
function cargarSelectCategoriasArchivoVisibles(){
	rpcSeccion('archivos','cargarSelectCategoriasArchivo','','id:idArchivoCategoria');
}