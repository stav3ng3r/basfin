function inicializar_torneo_editar_puntos(){
	cargarTablaPuntosEdicion();
}

function editarPuntos(idPunto){
	var datos = new Array();
	datos['idPunto'] = idPunto;
	datos['puntos'] = $('#ptos_' + idPunto).val();
	datos['pj'] = $('#pj_' + idPunto).val();
	datos['pg'] = $('#pg_' + idPunto).val();
	datos['pp'] = $('#pp_' + idPunto).val();
	datos['pe'] = $('#pe_' + idPunto).val();
	datos['gf'] = $('#gf_' + idPunto).val();
	datos['gc'] = $('#gc_' + idPunto).val();
	rpcSeccion('torneo','editarPuntos',datos,'fn:cargarTablaPuntosEdicion();');
}

function cargarTablaPuntosEdicion(){
	var datos = new Array();
	datos['idTorneo'] = $('#idTorneoEditandoPuntos').val();
	rpcSeccion('torneo','cargarTablaPuntosEdicion',datos,'fn:posCargarTablaPuntosEdicion();');
}

function posCargarTablaPuntosEdicion(){
	var row = rowRPC;
	$('#tablaEditarPuntos').html(row['html']);
	if($('#refrescarEn').val()!=''){
		
		var datos = new Array();
		datos['idTorneo'] = $('#idTorneoEditandoPuntos').val();
		datos['refrescarEn'] = 'tabla1PosicionesPuntos';
		rpcSeccion('torneo','cargarTablaPuntos',datos,'id:' + $('#refrescarEn').val());
	}
}