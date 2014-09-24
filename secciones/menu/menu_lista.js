function inicializar_menu_menu_lista(){
	listarMenuMenu();
}

function listarMenuMenu(){
	cargando('listaMenu',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaMenuCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaMenuAccionPosSeleccionar').val();
	datos['idMenu'] = $('#menuMenuLista_idMenu').val();
	rpcSeccion('menu','menuListar',datos,'id:listaMenu');
}

function eliminarMenu(idMenu){
	var datos = new Array();
	datos['idMenu'] = idMenu;
	rpcSeccion('menu','menuEliminar',datos,'fn:listarMenuMenu();');
}