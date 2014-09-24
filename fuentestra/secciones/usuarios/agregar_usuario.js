function validarAgregarUsuario(){
	var usuario = $('#usuarioNuevo').val();
	var nombre = $('#nombre').val();
	var correo = $('#correo').val();
	var clave = $('#claveUsuarioNuevo').val();
	var claveConfirm = $('#claveConfirm').val();
	
	if((usuario=='')||(nombre=='')||(correo=='')||(clave=='')||(claveConfirm=='')){
		dialogo('debes completar todos los camposmarcados con asterisco');
	}else if(clave!=claveConfirm){
		dialogo('La confirmación de la clave no coincide con la clave');
	}else{
		var datos = new Array();
		datos['usuario'] = usuario;
		datos['nombre'] = nombre;
		datos['correo'] = correo;
		datos['clave'] = clave;
		rpcSeccion('usuarios','agregarUsuario',datos,'fn:posAgregarUsuario();');	
	}
}

function posAgregarUsuario(){
	var row=rowRPC;
	var origen = $('#origen').val();
	cerrarVentana();
	if(origen=='lista'){
		generarListaUsuarios();
		dialogo('El usuario se ha insertado con éxito, desea asignarle permisos de acceso?','si:irAsignarPermisosPosNuevoUsuario(' + row['idUsuarioNuevo'] + ');|no','ok');
	}
}

function irAsignarPermisosPosNuevoUsuario(idUsuarioNuevo){
	cargarSeccion('usuarios','permisos','idUsuarioEditar=' + idUsuarioNuevo,'ventana');
}