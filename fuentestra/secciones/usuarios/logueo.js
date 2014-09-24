function inicializar_usuarios_logueo(){
	$('#usuario').focus();
	//cargarSeccion('menu','','','areaMenu');
}

function procesarLogueo(){
	var usuario = $('#usuario').val();
	var clave = $('#clave').val();	
	if((usuario=='')||(clave=='')){
		dialogo('Debes completar los campos');
	}else{
		var datos = new Array();
		datos['usuario'] = usuario;
		datos['clave'] = clave;
		rpcSeccion('usuarios','loguear',datos,'fn:posProcesarLogueo();');
	}
}

function posProcesarLogueo(){
	var row = rowRPC;
	//alert('1');
	if(row['mensaje']!=''){
		// NO LLEGA AQUI
		//$('.alert').html(row['mensaje']);
		//alert('A');
	}else{
		if($('#ventana').val()=='si'){
			cerrarVentana();
		}
		datosUsuario();
		/*cargarSeccion('menu','','','areaMenu');
		if($('#accionLogin').val()!=''){
			setTimeout($('#accionLogin').val(), 1);
		}*/
		cargarSeccion('entorno', 'entorno', '', 'cuerpo');
	}
}