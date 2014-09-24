var valorCookieProyecto;

function inicializar_sistema_proyecto_ae(){
	$('#sistProyectosAgEd_proyecto').focus();
	
	autocompletar('sistema', 'sistProyectosAgEd_pais', '', '');
	autocompletar('sistema', 'sistProyectosAgEd_ciudad', '', '', 'sistProyectosAgEd_pais');
	autocompletar('sistema', 'sistProyectosAgEd_categoria', 'categorias_lista', 'categoria_ae');

	adjuntarProyectos();
	
	if ($.cookie('valor')) {
		valorCookieProyecto = $.cookie('valor');
		$.removeCookie('valor');
		$('#sistProyectosAgEd_proyecto').val($('#'+valorCookieProyecto).val());	
	}
}

function agregarEditarSistemaProyectos(){
	var datos = new Array();
	datos['idProyectoEdit'] = $('#sistProyectosAgEd_idProyectoEdit').val();
	datos['proyecto'] = $('#sistProyectosAgEd_proyecto').val();
	datos['telefono'] = $('#sistProyectosAgEd_telefono').val();
	datos['email'] = $('#sistProyectosAgEd_email').val();
	datos['direccion'] = $('#sistProyectosAgEd_direccion').val();
	
	datos['idPais'] = $('#sistProyectosAgEd_paisId').val();
	datos['idCiudad'] = $('#sistProyectosAgEd_ciudadId').val();
	datos['firmantes'] = $('#sistProyectosAgEd_firmantes').val();
	datos['coordenadas'] = $('#sistProyectosAgEd_coordenadas').val();
	datos['idCategoria'] = $('#sistProyectosAgEd_categoriaId').val();
	datos['zonaHoraria'] = $('#sistProyectosAgEd_zonaHoraria').val();
	datos['lenguaje'] = $('#sistProyectosAgEd_lenguaje').val();
	datos['plantilla'] = $('#sistProyectosAgEd_plantilla').val();
	
	datos['logo'] = $("[name='proyectoLogo[]']").traAdjuntos();
		
	if(datos['proyecto']==''){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('sistema','proyectoAgregarEditar',datos,'fn:posAgregarEditarSistemaProyectos();');
	}
}

function posAgregarEditarSistemaProyectos(){
	var row=rowRPC;
	if (valorCookieProyecto == null) {
		listarSistemaProyectos();
		var idProyectoEdit = $('#sistProyectosAgEd_idProyectoEdit').val();
		if(idProyectoEdit!=''){
			cerrarVentana();
		}else{
			dialogo('Desea agregar otro registro','si:limpiarCamposSistemaProyectos();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
		}
	} else {
		$('#'+valorCookieProyecto).val($('#sistProyectosAgEd_proyecto').val());
		$('#'+valorCookieProyecto+'Id').val(row['idProyecto']);
		checkAutocompletar(valorCookieProyecto);
		cerrarVentana();	
	}
}

function limpiarCamposSistemaProyectos(){
	$('#sistProyectosAgEd_proyecto').val('');
	$('#sistProyectosAgEd_telefono').val('');
	$('#sistProyectosAgEd_email').val('');
	$('#sistProyectosAgEd_direccion').val('');
	$('#sistProyectosAgEd_idCiudad').val('');
	$('#sistProyectosAgEd_logo').val('');
	$('#sistProyectosAgEd_firmantes').val('');
	$('#sistProyectosAgEd_coordenadas').val('');
	$('#sistProyectosAgEd_idCategoria').val('');
	$('#sistProyectosAgEd_zonaHoraria').val('');
	$('#sistProyectosAgEd_lenguaje').val('');
	$('#sistProyectosAgEd_proyecto').focus();
}

function adjuntarProyectos() {
	var adjuntos = $('#sistProyectosAgEd_adjuntar').data('adjuntos');
	
	$('#sistProyectosAgEd_adjuntar').traUpload({
		seccion : 'sistema',
		rpc : 'proyectoAdjuntar',
		name : 'proyectoLogo',
		formatos : 'jpg|jpeg|png|gif|pdf',
		adjuntos : adjuntos,
		previa : {
			alto : '150px',
			ancho : '150px',
			class : 'jumbotron text-center',
			html : '<i style="font-size: 50px;" class="glyphicon glyphicon-picture text-success"></i>'
		},
		'img-class' : '', 
		multiple : false,
		cargando : '<i style="font-size: 50px;" class="glyphicon glyphicon-refresh spin"></i>'
	});	
}

