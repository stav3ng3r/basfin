function inicializar_movimientos_movimiento_ae(){
	$('#moviMovimientosAgEd_fecha').focus();

	var adjuntos = $('#moviMovimientosAgEd_adjuntar').data('adjuntos');
	adjuntarMovimientos(adjuntos);
	
	$('#moviMovimientosAgEd_sincronizar').click(function(){
		sincronizarAdjuntarApp();
	});
	
	//sincronizarAdjuntarApp();
	
	autocompletarPersona();
	var cookie = $.cookie('movimientoDetalles');
	$.removeCookie('movimientoDetalles');
	inputDinamicoMovimientos(cookie);
	
	$('#moviMovimientosAgEd_correspondienteMes').mask('99/9999');
}

function agregarEditarMovimientosMovimientos(){
	var datos = new Array();
	datos['idMovimientoEdit'] = $('#moviMovimientosAgEd_idMovimientoEdit').val();
	
	datos['idCaja'] = $('#moviMovimientosAgEd_caja').val();
	datos['moneda'] = $('#moviMovimientosAgEd_moneda').val();
	datos['confirmado'] = $('#moviMovimientosAgEd_confirmado').prop('checked');
	datos['tipo'] = $('#moviMovimientosAgEd_tipo').val();
	datos['fechaIdeal'] = $('#moviMovimientosAgEd_fechaIdeal').val();
	datos['correspondienteMes'] = $('#moviMovimientosAgEd_correspondienteMes').val();
	
	datos['fecha'] = $('#moviMovimientosAgEd_fecha').val();
	datos['hora'] = $('#moviMovimientosAgEd_hora').val();
	datos['idPersona'] = $('#moviMovimientosAgEd_idPersonaId').val();
	datos['comprobanteNro'] = $('#moviMovimientosAgEd_comprobanteNro').val();
	
	var concepto = [];
	var c = 0;
	$("[name='concepto[]']").each(function(){
		concepto[c++] = $(this).val();
	});
	
	var rubro = [];
	var c = 0;
	$("[name='rubroId[]']").each(function(){
		rubro[c++] = $(this).val();
	});
	
	var rubroDenominacion = [];
	var c = 0;
	$("[name='rubro[]']").each(function(){
		rubroDenominacion[c++] = $(this).val();
	});	
	
	var ingreso = [];
	var egreso = [];
	
	var c = 0;
	$("[name='valor[]']").each(function(){
		if (datos['tipo'] == 'ingreso') {
			ingreso[c++] = $(this).val();
		} else {
			egreso[c++] = $(this).val();
		}
	});
	
	var verificarConcepto = $.inArray('', concepto);
	var verificarRubro = $.inArray('', rubro);
	var verificarRubroDenominacion = $.inArray('', rubroDenominacion);
	var verificarIngreso = $.inArray('', ingreso);
	var verificarEgreso = $.inArray('', egreso);
	
	datos['concepto'] = concepto.join('|');
	datos['rubro'] = rubro.join('|');
	datos['ingreso'] = ingreso.join('|');
	datos['egreso'] = egreso.join('|');

	datos['adjuntos'] = $("[name='logo[]']").traAdjuntos();

	if (datos['fecha']=='' || $('#moviMovimientosAgEd_idPersona').val()==''){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');
	} else if (verificarConcepto >= 0 || verificarRubroDenominacion >= 0 || verificarIngreso >= 0 || verificarEgreso >= 0){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');
		
		if (verificarConcepto >= 0) {
			$("[name='concepto[]']").eq(verificarConcepto).focus();
		} else if (verificarRubroDenominacion >= 0) {
			$("[name='rubro[]']").eq(verificarRubroDenominacion).focus();
		} else if  (verificarIngreso >= 0) {
			$("[name='ingreso[]']").eq(verificarIngreso).focus();
		} else if  (verificarEgreso >= 0) {
			$("[name='egreso[]']").eq(verificarEgreso).focus();
		}	
	} else if(datos['idPersona']=='') {
		var acPlus = $('#moviMovimientosAgEd_idPersona').siblings('div').find('.ac-plus');
		var js = acPlus.prop('href').replace('javascript:', '');
		dialogo('El cliente/proveedor no existe, deseas crearlo?','si:cerrarDialogo();'+ js +';|no','info');
	} else if(verificarRubro >= 0 && verificarRubroDenominacion != verificarRubro) {
		var acPlus = $("[name='rubro[]']").eq(verificarRubro).siblings('div').find('.ac-plus');
		var js = acPlus.prop('href').replace('javascript:', '');
		dialogo('El rubro ' + $("[name='rubro[]']").eq(verificarRubro).val() + ' no existe, deseas crearlo?','si:cerrarDialogo();'+ js +';|no','info');		
	} else {
		rpcSeccion('movimientos','movimientoAgregarEditar',datos,'fn:posAgregarEditarMovimientosMovimientos();');
	}
}

function posAgregarEditarMovimientosMovimientos(){
	var row=rowRPC;
	var idMovimientoEdit = $('#moviMovimientosAgEd_idMovimientoEdit').val();
	if(idMovimientoEdit!=''){
		asignarValorTdLista('listaMovimiento',row['id'],'fecha',row['fecha']);
		asignarValorTdLista('listaMovimiento',row['id'],'persona',row['persona']);
		asignarValorTdLista('listaMovimiento',row['id'],'comprobante_nro',row['comprobante_nro']);
		asignarValorTdLista('listaMovimiento',row['id'],'valor',row['valor']);
		cerrarVentana();
	}else{
		$('#listaMovimiento table tbody').html(row['trNuevo'] + $('#listaMovimiento table tbody').html());
		$('#listaMovimiento #cantResultados').html(aNumero($('#listaMovimiento #cantResultados').html())+1);
		$('#listaMovimientoCantFilas').val(aNumero($('#listaMovimientoCantFilas').val())+1);		
		
		dialogo('Desea agregar otro registro','si:limpiarCamposMovimientosMovimientos();cerrarDialogo();|no:cerrarVentana();cerrarDialogo();','pregunta');	
	}
}

function limpiarCamposMovimientosMovimientos(){
	$('#moviMovimientosAgEd_comprobanteNro').val('');

	clearCheckAutocompletar('#moviMovimientosAgEd_idPersona');
	clearCheckAutocompletar("[name='rubro[]']");
	
	$("[name='concepto[]']").val('');
	$("[name='valor[]']").val('');
	
	$('#moviMovimientosAgEd_idPersona').focus();
}

function inputDinamicoMovimientos(cookie) {
	var values = (cookie==null) ? [] : $.parseJSON(cookie); 
	
	$(document).inputDinamico({
		fields : { 
			concepto : ['Concepto *', 'text', 'form-control'],
			rubro : ['Rubro *', 'text', 'form-control'],
			valor : ['Valor *' ,'text', 'form-control inputDecimal text-right']
		},
		limit	: 0,
		values	: values,
		element	: '#nuevosCampos',
		sortable : true,
		class : 'table-input-dinamico',
		deleteElement : '<i class="glyphicon glyphicon-remove"></i>',
		addElement : '<i class="glyphicon glyphicon-plus"></i>'
	}, function(i, ac) {
		agregarFuncionJs('fuentestra/funciones/js/funciones-numericas.js','initInputSeparadorMiles();');
		autocompletar('movimientos', 'rubro_'+i, 'rubros|rubros_lista', 'rubros|rubro_ae');
		$('#rubro_'+i+'Id').val(ac);
	});
}

function autocompletarPersona() {
	autocompletar('movimientos', 'moviMovimientosAgEd_idPersona', 'personas|personas_lista', 'personas|persona_ae');	
	
	var personas = $.cookie('autocompletar_persona');
	$.removeCookie('autocompletar_persona');
	
	personas = (personas==null) ? [] : $.parseJSON(personas); 
	
	$('#moviMovimientosAgEd_idPersona').val(personas[1]);
	$('#moviMovimientosAgEd_idPersonaId').val(personas[0]);	
}

function adjuntarMovimientos(adjuntos) {
	$('#moviMovimientosAgEd_adjuntar').traUpload({
		seccion : 'movimientos',
		rpc : 'movimientoAdjuntar',
		name : 'logo',
		formatos : 'jpg|jpeg',
		adjuntos : adjuntos,
		previa : {
			class : 'jumbotron text-center',
			html : '<i style="font-size: 50px;" class="glyphicon glyphicon-cloud-upload"></i>'
		},
		class : 'movimiento-adjuntar',
		multiple : true,
		cargando : '<i style="font-size: 50px;" class="glyphicon glyphicon-refresh spin"></i>'
	});
}

function sincronizarAdjuntarApp() {
	var tiempo = 0;
	$.ajax({
		url : "fuentestra/tracam/sincronizar.php",
		dataType : "json",
		type : "get",
		data : {},
		beforeSend: function(xhr){
		
		}
	})
	.done(function(data) {
		console.log(data);
		if(data) {
			adjuntarMovimientos(data);
		}
		
		//sincronizarAdjuntarApp();
	});
}