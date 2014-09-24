function inicializar_generador_tipo2_vista(){
	listarGenT2Vista();
}

function listarGenT2Vista(){
	cargando('listaGenT2Vista',4,'cargando');
	var datos = new Array();
	datos['idT2']=$('#genT2Vista_idT2').val();
	datos['cadenaBuscar'] = $('#listaGenT2VistaCadenaBuscar').val();
	rpcSeccion('generador_tipo2','t2VistaListar',datos,'idfn:listaGenT2Vista;mostrarOcultarBotGenT2Vista();');
}

function mostrarOcultarBotGenT2Vista(){
	var estado=$('#genT2Vista_estado').val();
	var bloquear=$('#genT2Vista_confirmado').val();
	
	$('.botEditarGenT2Bot').hide();
	$('.botEliminarGenT2Bot').hide();
	$('.botAnularGenT2Bot').hide();
	$('.botActivarGenT2Bot').hide();
	$('.botConfirmarGenT2Bot').hide();
	$('.botDesbloquearGenT2Bot').hide();
	$('.botAgregarGenT2Vista').hide();
	$('.botComprobanteGenT2Bot').hide();
	
	if(estado=='t' && bloquear=='f'){
		$('.botEditarGenT2Bot').show();
		$('.botEliminarGenT2Bot').show();
		$('.botAnularGenT2Bot').hide();
		$('.botActivarGenT2Bot').hide();
		$('.botConfirmarGenT2Bot').show();
		$('.botDesbloquearGenT2Bot').hide();
		$('.botAgregarGenT2Vista').show();
	}
	
	if(bloquear=='t'){
		$('.botEditarGenT2Bot').hide();
		$('.botEliminarGenT2Bot').hide();
		$('.botAnularGenT2Bot').show();
		$('.botActivarGenT2Bot').hide();
		$('.botConfirmarGenT2Bot').hide();
		$('.botDesbloquearGenT2Bot').show();
		$('.botAgregarGenT2Vista').hide();
		$('.botComprobanteGenT2Bot').show();
	}
	
	if(estado=='f'){
		$('.botEditarGenT2Bot').hide();
		$('.botEliminarGenT2Bot').hide();
		$('.botAnularGenT2Bot').hide();
		$('.botActivarGenT2Bot').show();
		$('.botConfirmarGenT2Bot').hide();
		$('.botDesbloquearGenT2Bot').hide();
		$('.botAgregarGenT2Vista').hide();
		$('.botComprobanteGenT2Bot').hide();
		$('#avisoAnuladoGenT2Bot').show();
	}
}

function eliminarT2(){
	var datos = new Array();
	datos['idT2'] = $('#genT2Vista_idT2').val();
	rpcSeccion('generador_tipo2','t2Eliminar',datos,'fn:posEliminarT2();');
}

function posEliminarT2(){
	cargarSeccion('generador_tipo2','lista');
}

function eliminarT2Vista(idT2Vista){
	var datos = new Array();
	datos['idT2Vista'] = idT2Vista;
	rpcSeccion('generador_tipo2','t2VistaEliminar',datos,'fn:listarGenT2Vista();');
}

function confirmarDesconfirmarT2(tipo){
	var datos = new Array();
	datos['idT2']=$('#genT2Vista_idT2').val();
	
	if(tipo==0){
		tipo='f';
	}else{
		tipo='t';
	}
	
	datos['tipo']=tipo;
	rpcSeccion('generador_tipo2','t2ConfirmarDesconfirmar',datos,'fn:posConfirmarDesconfirmarT2();');	
}

function posConfirmarDesconfirmarT2(){
	var idT2 = $('#genT2Vista_idT2').val();
	var row=rowRPC;
	$('#genT2Vista_estado').val(row['estado']);
	$('#genT2Vista_confirmado').val(row['confirmado']);
	cargarSeccion('generador_tipo2','vista','idT2=' + idT2);
}

function anularActivarT2(tipo) {
	var datos = new Array();
	datos['idT2']=$('#genT2Vista_idT2').val();
	
	if(tipo==0){
		tipo='f';
	}else{
		tipo='t';
	}
	
	datos['tipo']=tipo;
	rpcSeccion('generador_tipo2','t2AnularActivar',datos,'fn:posAnularActivarT2();');
}

function posAnularActivarT2(tipo){
	var idT2 = $('#genT2Vista_idT2').val();
	cargarSeccion('generador_tipo2','vista','idT2=' + idT2);
}