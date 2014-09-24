function inicializar_noticias(){
	cargarListadoDeNoticias();
}

function cargarListadoDeNoticias(){
	$('#listadoNoticias').html('');
	ocultar('botVerMasNoticias');
	mostrar('cargandoNoticias');

	var datos = new Array();
	datos['cadenaBuscar'] = $('#noticiaFiltro_cadenaBuscar').val();
	datos['idCat'] = $('#noticiaFiltro_idCat').val();
	datos['desde'] = $('#noticiaFiltro_desde').val();
	datos['hasta'] = $('#noticiaFiltro_hasta').val();
	
	rpcSeccion('noticias','listarNoticias',datos,'fn:posCargarListadoDeNoticias()');
}

function posCargarListadoDeNoticias(){
	var row = new Array();
	row=rowRPC;
	$('#listadoNoticias').html($('#listadoNoticias').html() + row['html']);
	$('#cantRegListaNoticias').val(row['cantReg']);
	if(row['mostrarMas']=='SI'){
		mostrar('botVerMasNoticias');
	}
	ocultar('cargandoNoticias');
}

function agregarAlListadoDeNoticias(){
	ocultar('botVerMasNoticias');
	mostrar('cargandoNoticias');
	
	var datos = new Array();
	datos['cadenaBuscar'] = $('#noticiaFiltro_cadenaBuscar').val();
	datos['idCat'] = $('#noticiaFiltro_idCat').val();
	datos['desde'] = $('#noticiaFiltro_desde').val();
	datos['hasta'] = $('#noticiaFiltro_hasta').val();
	datos['cantReg'] = $('#cantRegListaNoticias').val();
	rpcSeccion('noticias','listarNoticias',datos,'fn:posCargarListadoDeNoticias()');
}

function posAgregarAlListadoDeNoticias(){
	var row=rowRPC;
	$('#listadoDeNoticias table').html($('#listadoDeNoticias table').html() + row['html']);
	$('#cantRegListaNoticias').val(row['cantReg']);
	
	if(row['mostrarMas']=='SI'){
		mostrar('botVerMasNoticias');
	}
	ocultar('cargandoNoticias');
}

function mostrarOpcionesAvanzadasDeBusqueda(){
	$('.filaBuscarAvanzada').show("slow");
	$('.filaBuscarOcultarAvanzada').show();
	$('.filaBuscarMostrarAvanzada').hide();
}

function ocultarOpcionesAvanzadasDeBusqueda(){
	$('.filaBuscarAvanzada').hide("slow");
	$('.filaBuscarOcultarAvanzada').hide();
	$('.filaBuscarMostrarAvanzada').show();
}