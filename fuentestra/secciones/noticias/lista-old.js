function inicializar_noticias_lista(){
	ocultar('botVerMasNoticias');
	mostrar('cargandoNoticias');
	rpcSeccion('noticias','listarNoticias','','fn:posCargarNoticia()');
}
function posCargarNoticia(){
	var row = new Array();
	row=rowRPC;
	$('#listadoNoticias').html($('#listadoNoticias').html() + row['html']);
	mostrar('botVerMasNoticias');
	ocultar('cargandoNoticias');
}