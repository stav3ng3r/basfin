function inicializar_noticias_agregar_editar(){
	cListaRelArchivos=0;
	cargarRelNoticiaCategorias($('#onLoadRelNoticiaCategorias').val());
	cargarListadoRelArchivos_desdeEditandoNoticia();
	cargarRelNoticiaNoticias($('#onLoadRelNoticiaNoticia').val());
	inicializarEditor();
}

function removerEditor(){
	tinyMCE.get('entradilla').remove();
	tinyMCE.get('cuerpo').remove();	
}

function inicializarEditor(){
	tinyMCE.init({
		mode : "exact",
		elements : "entradilla,cuerpo",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,forecolor,backcolor,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,sub,sup,charmap,separator,undo,redo,separator,link,unlink,separator,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		forced_root_block : ""
	});
}


function cargarListadoRelArchivos_desdeEditandoNoticia(){
	var idsArchivos = $('#onLoadRelNoticiaArchivos').val();
	if(idsArchivos!=''){
		var datos = new Array();
		datos['idsArchivos'] = idsArchivos;
		datos['cListaRelArchivos']=cListaRelArchivos;
		rpcSeccion('archivos','agregarListadoRelArchivos',datos,'fn:cargarListadoRelArchivos()');
	}
}

function cargarRelNoticiaCategorias(idsCategorias){
	var datos = new Array();
	datos['idsCategorias']=idsCategorias;
	rpcSeccion('noticias','cargarRelNoticiaCategorias',datos,'id:relNoticiaCategorias');	
}

function irCargarRelNoticiaCategorias(){
	var elementos = document.getElementsByName('idNoticiaCategoriaRelNoticia');
	var idsCategorias='';
	for (x=0;x<elementos.length;x++){
		if(idsCategorias!=''){idsCategorias+=',';}
		idsCategorias+=elementos[x].value;
	}
	cargarSeccion('noticias','lista_categorias','idsCategorias='+idsCategorias,'ventana');	
}

function desvincularNoticiaCategoria(idCategoria){
	var elementos = document.getElementsByName('idNoticiaCategoriaRelNoticia');
	var idsCategorias='';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].value!=idCategoria){
			if(idsCategorias!=''){idsCategorias+=',';}
			idsCategorias+=elementos[x].value;
		}
	}
	cargarRelNoticiaCategorias(idsCategorias);
}

function validarFormInsertarEditarNoticia(){
	var fechaHora = $('#fechaHora').val();
	var titular = $('#titular').val();
	var antetitulo = $('#antetitulo').val();
	var entradilla = tinyMCE.get('entradilla').getContent();
	var cuerpo = tinyMCE.get('cuerpo').getContent();
	var permitirComentar = document.getElementById('permitirComentar').checked;
	var publicado = document.getElementById('publicado').checked;
	if((fechaHora=='')||(titular=='')||(entradilla=='')){
		dialogo('Debe completar todos los campos marcados con asterisco');
	}else{
		var idsArchivos = obtenerIdsArchivosDeListadoRelArchivos();
		var elementos = document.getElementsByName('idNoticiaCategoriaRelNoticia');
		var idsCategorias='';
		for (x=0;x<elementos.length;x++){
			if(idsCategorias!=''){idsCategorias+=',';}
			idsCategorias+=elementos[x].value;
		}
		var elementos = document.getElementsByName('idNoticiasRelNoticia');
		var idsNoticiasRelacionadas='';
		for (x=0;x<elementos.length;x++){
			if(idsNoticiasRelacionadas!=''){idsNoticiasRelacionadas+=',';}
			idsNoticiasRelacionadas+=elementos[x].value;
		}
		var datos = new Array();
		datos['idNoticia'] = $('#idNoticiaEditando').val();
		datos['fechaHora'] = fechaHora;
		datos['titular'] = titular;
		datos['antetitulo'] = antetitulo;
		datos['entradilla'] = entradilla;
		datos['cuerpo'] = cuerpo;
		datos['permitirComentar'] = permitirComentar;
		datos['publicado'] = publicado;
		datos['idsArchivos'] = idsArchivos;
		datos['idsCategorias'] = idsCategorias;
		datos['idsNoticiasRelacionadas'] = idsNoticiasRelacionadas;
		if(datos['idNoticia']==''){
			rpcSeccion('noticias','insertarNoticia',datos,'fn:posInsertarNoticia();');
		}else{
			rpcSeccion('noticias','editarNoticia',datos,'fn:posEditarNoticia(' + datos['idNoticia'] + ');');	
		}
	}
}

function posInsertarNoticia(){
	var row = rowRPC;
	idNoticia=row['idNoticia'];
	cargarSeccion('noticias');
	dialogo('La noticia fue insertada con éxito, desea insertar otra noticia','si:setFormInsertarEditarNoticia();|no:posInsertarNoticiaNo(' + idNoticia + ');','ok');
}

function posInsertarNoticiaNo(idNoticia){
	removerEditor();
	cerrarVentana();
	if(nivelVentana==1){
		cargarSeccion('noticias','extenso','idNoticia=' + idNoticia,'ventana' + nivelVentana + '_contenido');
	}else{
		cargarSeccion('noticias','extenso','idNoticia=' + idNoticia,'ventana');
	}	
}

function posEditarNoticia(idNoticia){
	cargarSeccion('noticias');
	cerrarVentana();
	cargarSeccion('noticias','extenso','idNoticia=' + idNoticia,'ventana' + nivelVentana + '_contenido')
	dialogo('La noticia fue editada con éxito','','ok');	
}

function setFormInsertarEditarNoticia(){
	cListaRelArchivos=0;
	cargarRelNoticiaCategorias('');
	$('#listadoRelArchivos').html('');
	$('#titular').val('');
	$('#antetitulo').val('');
	$('#entradilla').val('');
	$('#cuerpo').val('');
	document.getElementById('permitirComentar').checked=false;
	document.getElementById('publicado').checked=false;
}

function cargarRelNoticiaNoticias(idsNoticiasNuevas){
	if(idsNoticiasNuevas!=''){
		var elementos = document.getElementsByName('idNoticiasRelNoticia');
		var idsNoticiasActuales='';
		for (x=0;x<elementos.length;x++){
			if(idsNoticiasActuales!=''){idsNoticiasActuales+=',';}
			idsNoticiasActuales+=elementos[x].value;
		}
		
		var datos = new Array();
		datos['idsNoticiasActuales'] = idsNoticiasActuales;
		datos['idsNoticiasNuevas'] = idsNoticiasNuevas;
		rpcSeccion('noticias','generarListaNoticiasRelacionadas',datos,'id:listaNoticiasRelacionadas');
	}
}

function irSeleccionarNoticiasRelacionadas(){
	var idNoticia = $('#idNoticiaEditando').val();
	var elementos = document.getElementsByName('idNoticiasRelNoticia');
	var idsNoticiasActuales='';
	for (x=0;x<elementos.length;x++){
		if(idsNoticiasActuales!=''){idsNoticiasActuales+=',';}
		idsNoticiasActuales+=elementos[x].value;
	}
	cargarSeccion('noticias','lista_relacionar_noticias','idNoticia=' + idNoticia + '&idsNoticiasActuales=' + idsNoticiasActuales,'ventana');
}

function irDesvincularNoticiaRelacionada(idNoticiaRelacionada){
	dialogo('Esta seguro que desea desvincular la noticia seleccionada?','si:desvincularNoticiaRelacionada(' + idNoticiaRelacionada + ');|no','pregunta');
}

function desvincularNoticiaRelacionada(idNoticiaRelacionada){
	$('#datosNoticiaVinculaId' + idNoticiaRelacionada).html('');
}