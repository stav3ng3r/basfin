function inicializar_menu_menu_ae(){
	denominar('menu','menuDenominar',$('#menuMenuAgEd_cabIdItem').val(),'menuMenuAgEd_cabIdItemHtml');
	mostrarOcultarTrTipoItem();
	if($('#menuMenuAgEd_usutra').val()==1){
		$('.trTipo_itemDeSistema').show();
	}
	$('#menuMenuAgEd_item').focus();
}

function agregarEditarMenuMenu(){
	var datos = new Array();
	datos['item'] = $('#menuMenuAgEd_item').val();
	datos['cabIdItem'] = $('#menuMenuAgEd_cabIdItem').val();
	datos['orden'] = $('#menuMenuAgEd_orden').val();
	datos['tipo'] = $('#menuMenuAgEd_tipo').val();
	datos['itemSeccion'] = $('#menuMenuAgEd_seccion').val();
	datos['itemAplicacion'] = $('#menuMenuAgEd_aplicacion').val();
	datos['itemParametro'] = $('#menuMenuAgEd_parametros').val();
	datos['itemPermiso'] = $('#menuMenuAgEd_permiso').val();
	datos['itemDocumento'] = $('#menuMenuAgEd_documento').val();
	datos['itemHref'] = $('#menuMenuAgEd_href').val();
	datos['mostrarEn'] = $('#menuMenuAgEd_mostrarEn').val();
	datos['visibleMenu'] = document.getElementById('menuMenuAgEd_visibleMenu').checked;
	datos['requiereLogin'] = document.getElementById('menuMenuAgEd_requiereLogin').checked;
	datos['itemDeSistema'] = document.getElementById('menuMenuAgEd_itemDeSistema').checked;
	datos['idItemEdit'] = $('#menuMenuAgEd_idItemEdit').val();
	
	if(datos['item']==''){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('menu','menuAgregarEditar',datos,'fn:posAgregarEditarMenuMenu();');
	}
}

function posAgregarEditarMenuMenu(){
	listarMenuMenu();
	var idMenuEdit = $('#menuMenuAgEd_idItemEdit').val();
	if(idMenuEdit!=''){
		cerrarVentana();
	}else{
		dialogo('Desea agregar otro item','si:limpiarCamposMenuMenu();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
	}
}

function limpiarCamposMenuMenu(){
	$('#menuMenuAgEd_item').val('');
	$('#menuMenuAgEd_orden').val('');
	$('#menuMenuAgEd_seccion').val('');
	$('#menuMenuAgEd_aplicacion').val('');
	$('#menuMenuAgEd_parametros').val('');
	$('#menuMenuAgEd_permiso').val('');
	$('#menuMenuAgEd_documento').val('');
	$('#menuMenuAgEd_href').val('');
	$('#menuMenuAgEd_item').focus();
}

function mostrarOcultarTrTipoItem(){
	var tipo = $('#menuMenuAgEd_tipo').val();	
	$('.trTipo_mostrarEn').hide();
	$('.trTipo_aplicacion').hide();
	$('.trTipo_documento').hide();
	$('.trTipo_href').hide();
	$('.trTipo_permiso').hide();

	if(tipo=='aplicacion' || tipo=='documento' || tipo=='href'){
		$('.trTipo_' + tipo).show();
	}
	
	if(tipo=='aplicacion' || tipo=='documento'){
		$('.trTipo_mostrarEn').show();
	}
	
	if(tipo=='aplicacion' || tipo=='href'){
		$('.trTipo_permiso').show();
	}
}

function limpiarCabIdItem(){
	$('#menuMenuAgEd_cabIdItem').val('');
	$('#menuMenuAgEd_cabIdItemHtml').html('');
}