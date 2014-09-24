function inicializar_usuarios(){
	listarUsuarios();
}

function generarListaUsuarios(){
	listarUsuarios();
}

function listarUsuarios(){
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listadoUsuariosCadenaBuscar').val();
	rpcSeccion('usuarios','listarUsuarios',datos,'id:listadoUsuarios');
}

function eliminarUsuario(idUsuarioEliminar){
	dialogo('Seguro que desea eliminar el usuario?','si:procesoEliminarUsuario(' + idUsuarioEliminar + ');|no','eliminar');
}

function procesoEliminarUsuario(idUsuarioEliminar){
	var datos = new Array();
	datos['idUsuarioEliminar'] = idUsuarioEliminar;
	rpcSeccion('usuarios','eliminarUsuario',datos,'fn:listarUsuarios();');	
}