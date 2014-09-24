function inicializar_entorno(){
	cargarSeccion('menu','','','areaMenu');
	rpcSeccion('entorno', 'comprobarSesion', '', 'fn:posComprobarSesion()');
}

function posComprobarSesion(){
	var row = rowRPC;
	
	if(row['sesionIniciada'] == 't'){
		cargarSeccion('inicio');
	}
	
	reloj($('#hora').html());
}


