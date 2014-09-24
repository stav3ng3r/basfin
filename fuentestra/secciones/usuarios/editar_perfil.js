function validarEditarPerfil(){
	var nombre = $('#nombre').val();
	var correo = $('#correo').val();
	if((nombre=='')||(correo=='')){
		dialogo('Debes completar el nombre y la cuenta de e-mail');
	}else{
		var datos = new Array();
		datos['idUsuarioEditar'] = $('#idUsuarioEditar').val();
		datos['nombre'] = nombre;
		datos['correo'] = correo;
		rpcSeccion('usuarios','editarPerfil',datos,'fn:posEditarPerfil();');
	}
}

function validarCambiarClave(){
	var claveActual = $('#claveActual').val();
	var claveNueva = $('#claveNueva').val();
	var claveNuevaConfirm = $('#claveNuevaConfirm').val();
	if((claveActual=='')||(claveNueva=='')||(claveNuevaConfirm=='')){
		dialogo('Debes completar todos los campos');
	}else if(claveNueva!=claveNuevaConfirm){
		dialogo('La confirmación de la clave nueva no coincide con la clave nueva');
	}else{
		var datos = new Array();
		datos['idUsuarioEditar'] = $('#idUsuarioEditar').val();
		datos['claveActual'] = claveActual;
		datos['claveNueva'] = claveNueva;
		rpcSeccion('usuarios','cambiarClave',datos,'fn:posEditarPerfil();');	
	}
}

function posEditarPerfil(){
	var origen = $('#origen').val();
	cerrarVentana();
	dialogo('Los datos del perfil se han modificado con éxito');
	if(origen=='lista'){
		generarListaUsuarios();
	}
}