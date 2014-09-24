function inicializar_movimientos_movimiento_vista(){
	listarMovimientoDetalles();
	salirListado();
}

function listarMovimientoDetalles(){
	cargando('listaMovimientoVista',4,'cargando');
	var datos = new Array();
	datos['idMovimiento']=$('#moviMovimientoVista_idMovimiento').val();
	datos['cadenaBuscar']=$('#listaSistemaCiudadesCadenaBuscar').val();
	rpcSeccion('movimientos','movimientoDetallesListar',datos,'id:listaMovimientoVista');
}

function mostrarOcultarBotSistemaCiudades(){
	var estado=$('#sistCiudades_estado').val();
	var bloquear=$('#sistCiudades_confirmado').val();
	
	$('.botEditarPais').hide();
	$('.botEliminarPais').hide();
	$('.botAnularPais').hide();
	$('.botActivarPais').hide();
	$('.botConfirmarPais').hide();
	$('.botDesbloquearPais').hide();
	$('.botAgregarSistemaCiudades').hide();
	$('.botComprobantePais').hide();
	
	if(estado=='t' && bloquear=='f'){
		$('.botEditarPais').show();
		$('.botEliminarPais').show();
		$('.botAnularPais').hide();
		$('.botActivarPais').hide();
		$('.botConfirmarPais').show();
		$('.botDesbloquearPais').hide();
		$('.botAgregarSistemaCiudades').show();
	}
	
	if(bloquear=='t'){
		$('.botEditarPais').hide();
		$('.botEliminarPais').hide();
		$('.botAnularPais').show();
		$('.botActivarPais').hide();
		$('.botConfirmarPais').hide();
		$('.botDesbloquearPais').show();
		$('.botAgregarSistemaCiudades').hide();
		$('.botComprobantePais').show();
	}
	
	if(estado=='f'){
		$('.botEditarPais').hide();
		$('.botEliminarPais').hide();
		$('.botAnularPais').hide();
		$('.botActivarPais').show();
		$('.botConfirmarPais').hide();
		$('.botDesbloquearPais').hide();
		$('.botAgregarSistemaCiudades').hide();
		$('.botComprobantePais').hide();
		$('#avisoAnuladoPais').show();
	}
}

function eliminarMovimiento(){
	var datos = new Array();
	datos['idMovimiento'] = $('#moviMovimientoVista_idMovimiento').val();
	rpcSeccion('movimientos','movimientoEliminar',datos,'fn:posEliminarMovimiento();');
}

function posEliminarMovimiento(){
	cargarSeccion('movimientos','movimientos_lista');
}

function confirmarDesconfirmarPais(tipo){
	var datos = new Array();
	datos['idPais']=$('#sistCiudades_idPais').val();
	
	if(tipo==0){
		tipo='f';
	}else{
		tipo='t';
	}
	
	datos['tipo']=tipo;
	rpcSeccion('sistema','paisConfirmarDesconfirmar',datos,'fn:posConfirmarDesconfirmarPais();');	
}

function posConfirmarDesconfirmarPais(){
	var idPais = $('#sistCiudades_idPais').val();
	var row=rowRPC;
	$('#sistCiudades_estado').val(row['estado']);
	$('#sistCiudades_confirmado').val(row['confirmado']);
	cargarSeccion('sistema','pais_vista','idPais=' + idPais);
}

function anularActivarPais(tipo) {
	var datos = new Array();
	datos['idPais']=$('#sistCiudades_idPais').val();
	
	if(tipo==0){
		tipo='f';
	}else{
		tipo='t';
	}
	
	datos['tipo']=tipo;
	rpcSeccion('sistema','paisAnularActivar',datos,'fn:posAnularActivarPais();');
}

function posAnularActivarPais(tipo){
	var idPais = $('#sistCiudades_idPais').val();
	cargarSeccion('sistema','pais_vista','idPais=' + idPais);
}