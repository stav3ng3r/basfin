function inicializar_generador_abm_ae(){
	$("#genABM_tituloT1").keyup(function(){
		$("#genABM_seccion").val($(this).val().toLowerCase().replace(/ /gi,'_'));
		$("#genABM_aplicacionT1").val($(this).val().toLowerCase().replace(/ /gi,'_'));
	});
	
	$("[id*='genABM']").blur(function(){
		existeAplicacion();
	});
	
	$("#genABM_tipo").change(function(){
		if($(this).val()=='2'){
			$("#genABM_mostrarOcultarTitulo2").show();
			$("#genABM_mostrarOcultarAplicacion2").show();
			$("#genABM_mostrarOcultarTabla2").show();
			$("#genABM_mostrarOcultarCamposTablaT2").hide();
			if($("#genABM_tablaT2")!=''){
				$("#genABM_mostrarOcultarCamposTablaT2").show();
			}
			if($("#genABM_tablaT1")!=''){
				opcionTabla2();
			}
			
			campoAdjuntarTabla1();
		}else{
			$("#genABM_mostrarOcultarTitulo2").hide();
			$("#genABM_mostrarOcultarAplicacion2").hide();
			$("#genABM_mostrarOcultarTabla2").hide();
			$("#genABM_mostrarOcultarCamposTablaT2").hide();
		}
	});

	$("#genABM_permiso").change(function(){
		if($(this).val()=='nuevo'){
			$("#genABM_mostrarOcultarNuevoPermiso").show();
		}else{
			$("#genABM_mostrarOcultarNuevoPermiso").hide();
		}
	});
	
	$("#genABM_tablaT1").change(function(){
		if($(this).val()==''){
			$("#genABM_mostrarOcultarCamposTablaT1").hide();
		}else{
			$("#genABM_mostrarOcultarCamposTablaT1").show();
			listarCamposTabla(1);
			if($("#genABM_tipo").val()==2){
				opcionTabla2();
			}
			campoAdjuntarTabla1();
		}
	});
	
	$("#genABM_tablaT2").change(function(){
		if($(this).val()==''){
			$("#genABM_mostrarOcultarCamposTablaT2").hide();
		}else{
			$("#genABM_mostrarOcultarCamposTablaT2").show();
			listarCamposTabla(2);
		}
	});
}

function procesarGeneradorABM(){
	var datos = new Array();
	datos['seccionAplicacion'] = $('#genABM_seccion').val();
	datos['tipo'] = $('#genABM_tipo').val();
	datos['tituloT1'] = $('#genABM_tituloT1').val();
	datos['aplicacionT1']=$("#genABM_aplicacionT1").val();
	datos['tablaT1']=$("#genABM_tablaT1").val();
	datos['adjuntarT1']=$("#genABM_adjuntarT1").prop('checked');
	datos['adjuntarDirectorioT1']=$("#genABM_adjuntarDirectorioT1").val();
	datos['adjuntarCampoT1']=$("#genABM_adjuntarCampoT1").val();
	datos['tituloT2'] = $('#genABM_tituloT2').val();
	datos['aplicacionT2']=$("#genABM_aplicacionT2").val();
	datos['tablaT2']=$("#genABM_tablaT2").val();
	datos['permiso'] = $('#genABM_permiso').val();
	datos['nuevoPermiso'] = $('#genABM_nuevoPermiso').val();
	datos['nombreCampoT1'] = inputText('genABM_nombreCampoT1');
	datos['camposListarT1'] = valoresSeleccionadosCheckbox('genABM_selCamposListarT1');
	datos['camposAgregarEditarT1'] = valoresSeleccionadosCheckbox('genABM_selCamposAgregarEditarT1');

	datos['nombreCampoT2'] = inputText('genABM_nombreCampoT2');
	datos['camposListarT2'] = valoresSeleccionadosCheckbox('genABM_selCamposListarT2');
	datos['camposAgregarEditarT2'] = valoresSeleccionadosCheckbox('genABM_selCamposAgregarEditarT2');
	
	if(datos['seccionAplicacion']=='' || datos['tipo']=='' || datos['tituloT1']=='' ||  datos['permiso']=='' || (datos['tipo']=='2' && (datos['tituloT2']=='' || datos['aplicacionT2']=='')) || (datos['permiso']=='nuevo' && datos['nuevoPermiso']=='')){
		dialogo('Los campos indicados con asterisco son de carácter obligatorio');	
	}else{
		rpcSeccion('generador_abm','generarABM',datos,'fn:posCrearAplicacion();');
	}
}

function posCrearAplicacion(){
	var row=rowRPC;
	//alert('aplicacion creada exitósamente');
	cerrarVentana();
	cargarSeccion(row['abrir_seccion'],row['abrir_aplicacion'] + '_lista');
}

function existeAplicacion(){
	var datos = Array();
	datos['seccionAplicacion']=$("#genABM_seccion").val();
	datos['aplicacionT1']=$("#genABM_aplicacionT1").val();
	datos['aplicacionT2']=$("#genABM_aplicacionT2").val();
	rpcSeccion('generador_abm','existeAplicacion',datos,'fn:posExisteAplicacion();');	
}

function posExisteAplicacion(){
	var row = rowRPC;
	if(row['existeAplicacionT1']==true){
		$("#genABM_trueT1").show();
		$("#genABM_falseT1").hide();
	}else
	if(row['existeAplicacionT1']==false){
		$("#genABM_falseT1").show();
		$("#genABM_trueT1").hide();
	}else{
		$("#genABM_falseT1").hide();
		$("#genABM_trueT1").hide();		
	}
	
	if(row['existeAplicacionT2']==true){
		$("#genABM_trueT2").show();
		$("#genABM_falseT2").hide();
	}else
	if(row['existeAplicacionT2']==false){
		$("#genABM_falseT2").show();
		$("#genABM_trueT2").hide();
	}else{
		$("#genABM_falseT2").hide();
		$("#genABM_trueT2").hide();		
	}
}

function listarCamposTabla(idTabla){
	cargando('listarCamposT'+idTabla,2);
	var datos = Array();
	datos['tabla'] = $("#genABM_tablaT" + idTabla).val();
	datos['idTabla'] = idTabla;
	if(datos['tabla']!=''){
		rpcSeccion('generador_abm','listarCamposTabla',datos,'idfn:listarCamposT'+idTabla+';mostrarTituloTabla();');
	}
}

function mostrarTituloTabla(){
	var row = rowRPC;
	$('#genABM_tituloTablaT'+row['idTabla']).html(row['titulo']);
}

function inputText(idInputText){
	var valores = '';
	var c = 0;
	$("[id^="+idInputText+"]").each(function(){
		c++;
		if(c>1){
			valores += ',';
		}				
		valores += $(this).prop('class')+':'+$(this).val();
	});
	return valores;
}

function opcionTabla2(){
	var datos = Array();
	datos['tabla1'] = $("#genABM_tablaT1").val();
	rpcSeccion('generador_abm','opcionTabla2',datos,'fn:posOpcionTabla2();');
}

function posOpcionTabla2(){
	var row = rowRPC;
	$('#genABM_tablaT2').html(row['opcionTabla2']);
}

function campoAdjuntarTabla1(){
	var datos = Array();
	datos['tablax'] = $("#genABM_tablaT1").val();
	rpcSeccion('generador_abm','campoAdjuntar',datos,'fn:posCampoAdjuntarTabla1();');
}

function posCampoAdjuntarTabla1(){
	var row = rowRPC;
	$('#genABM_adjuntarCampoT1').html(row['campoAdjuntar']);
}