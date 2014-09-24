function procesarPropiedadConfiguracion(){
	var campo = $('#campoPropiedad').val();
	var valor = $('#valorPropiedad').val();
	if(valor==''){
		dialogo('Debe ingresar una información');	
	}else{
		var datos = new Array();
		datos['campo'] = campo;
		datos['valor'] = valor;
		rpcSeccion('configuraciones','editarPropiedad',datos,'fn:posProcesarPropiedadConfiguracion();');
	}
}

function posProcesarPropiedadConfiguracion(){
	cerrarVentana();
	mostrarValoresConfiguraciones();
}