function agregarFuncionJs(funciones, llamarFuncion) {
	var vFunciones = new Array();
	vFunciones = explotarCadena(funciones, ',');

	cCargaFuncion++;
	acCargaFuncion[cCargaFuncion] = vFunciones.length;
	acCargandoFuncion[cCargaFuncion] = 0;
	//alert(funciones + ',' + llamarFuncion + '->' + acCargaFuncion[cCargaFuncion]);
	for ( k = 0; k < vFunciones.length; k++) {
		funcion = vFunciones[k];
		var i = 0;
		var b = 0;
		for ( i = 0; i < funcionesJsCargadas.length; i++) {
			if (funcionesJsCargadas[i] == funcion) {
				b = 1;
				i = funcionesJsCargadas.length;
			}
		}
		if (b == 0) {
			var elemento = document.createElement('script');
			elemento.setAttribute('type', 'text/javascript');
			elemento.setAttribute('src', funcion);
			if (llamarFuncion != '') {
				elemento.setAttribute('onLoad', "llamadaFuncionPosAgregarFuncionJs(" + cCargaFuncion + ",'" + llamarFuncion + "');");
				elemento.onreadystatechange = function() {
					if (this.readyState == 'loaded' || this.readyState == 'complete') {
						llamadaFuncionPosAgregarFuncionJs(cCargaFuncion, llamarFuncion);
					}
				}
			}
			document.getElementsByTagName('head')[0].appendChild(elemento);
			funcionesJsCargadas[funcionesJsCargadas.length] = funcion;
		} else {
			llamadaFuncionPosAgregarFuncionJs(cCargaFuncion, llamarFuncion);
		}
	}
}

function llamadaFuncionPosAgregarFuncionJs(cCargaFuncion, llamarFuncion) {
	acCargandoFuncion[cCargaFuncion]++;
	//alert(acCargaFuncion[cCargaFuncion] + '=' + acCargandoFuncion[cCargaFuncion]);
	if (acCargaFuncion[cCargaFuncion] == acCargandoFuncion[cCargaFuncion]) {
		if (llamarFuncion != '') {
			//alert(llamarFuncion);
			setTimeout(llamarFuncion, 1);
		}
	}
}

function agregarEstiloCss(estilo) {
	var i = 0;
	var b = 0;
	for ( i = 0; i < estilosCssCargados.length; i++) {
		if (estilosCssCargados[i] == estilo) {
			b = 1;
		}
	}
	if (b == 0) {
		var elemento = document.createElement('link');
		elemento.setAttribute('rel', 'stylesheet');
		elemento.setAttribute('href', estilo);
		elemento.setAttribute('type', 'text/css');
		document.getElementsByTagName('head')[0].appendChild(elemento);
		estilosCssCargados[estilosCssCargados.length] = estilo;
	}
}

var guardaSeccionVentana = new Array();
function cargarSeccion(seccion, aplicacion, parametros, elementoDest, aplicarSiempre) {

	if (aplicacion == null) {
		aplicacion = '';
	}
	if (parametros == null) {
		parametros = '';
	}
	if (elementoDest == null) {
		elementoDest = 'entorno_contenido';
	}
	if (aplicarSiempre == null) {
		aplicarSiempre = true;
	}

	if (elementoDest == 'entorno_contenido') {
		document.location.href = '#cuerpo';
	}

	//-- obtener valor de CadenaBuscar
	var cadenaBuscar = '';
	id = '';
	$('#entorno_contenido input[type=text]').each(function() {
		var text = this.id;
		if (text.indexOf("CadenaBuscar") != -1) {
			cadenaBuscar = $('#' + text).val();
		}
	});
	if (cadenaBuscar != '') {
		if (parametros != '') {
			parametros += '&';
		}
		parametros += 'cadenaBuscarAnt=' + cadenaBuscar;
	}

	var procesar = 0;
	if (elementoDest == 'ventana') {
		$('#cargandoVentana').show();
		nivelVentana++;

		guardaSeccionVentana[nivelVentana] = seccion + '_' + aplicacion;

		if (ventanasCargadas < nivelVentana) {
			// cargar ventana al final del body
			var onLoad = "cargarSeccion('" + seccion + "','" + aplicacion + "','" + codificarParametros(parametros) + "','ventana" + nivelVentana + "_contenido');";
			cargarVentana(onLoad);

			elemento = $("#ventana" + nivelVentana);
		} else {
			//$("#ventana" + nivelVentana).draggable();

			$("#ventana" + nivelVentana).css('top', '0px');
			$("#ventana" + nivelVentana).css('left', '0px');
			if (posClickY <= 300) {
				$("#ventanaRecuadro" + nivelVentana).css('top', (posClickY) + 'px');
			} else {
				$("#ventanaRecuadro" + nivelVentana).css('top', (posClickY - 150) + 'px');
			}

			mostrar('ventana' + nivelVentana);
			elementoDest = 'ventana' + nivelVentana + '_contenido';
			procesar = 1;
		}

		elemento = $("#ventana" + nivelVentana);

		var titulo = '';
		var setTitle = function() {
			titulo = elemento.find('h1').text();
			elemento.find('.modal-title').text(titulo);

			if (titulo == '') {
				setTimeout(function() {
					setTitle();
				}, 100);
			} else {
				elemento.find('h1').hide();
			}
		}
		setTitle();

	} else {
		if ($('#' + elementoDest).length) {
			if (seccionesCargadas[elementoDest] != seccion + ',' + aplicacion + ',' + parametros + ',' + aplicarSiempre) {
				seccionesCargadas[elementoDest] = seccion + ',' + aplicacion + ',' + parametros + ',' + aplicarSiempre;
				procesar = 1;
			} else {
				if (aplicarSiempre == true) {
					procesar = 1;
				}
			}
		} else {
			alert('El elemento div id="' + elementoDest + '" no se encuentra en el documento');
		}
	}
	if (procesar == 1) {
		if (elementoDest != 'cuerpo') {
			cargando(elementoDest, 1);
		}

		var ajax = nuevoAjax();
		ajax.open("POST", "index.php?o=secciones", true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				var row = procesarCadena(ajax.responseText);
				if (ajax.responseText.substr(0, 12) != 'esq#->#ok#*#') {
					if (ajax.responseText == '') {
						alert('Se ha perdido la conección con el servidor, vuelva a intentarlo o consulte con el administrador de la red (cargarSeccion)');
					} else {
						var htmlRespuesta = ajax.responseText;
						htmlRespuesta = replaceAll(htmlRespuesta, 'esq#->', '<hr>' + row['html'] + '<hr><a href="javascript:mostrarOcultar(\'esqResp\');">ver respuesta del servidor</a><br><div id="esqResp" style="display:none;">esq#=>') + '</div>';
						$('#' + row['elementoDest']).html(htmlRespuesta);
					}
				} else {
					cargarEnlaceDirecto();
					$('#' + row['elementoDest']).html(row['html']);
					mostrarOcultarSegunPermisos(row['permisosHabilitados'], row['permisosNoHabilitados']);

					if ((row['exigir_login'] == 't') && (row['estado_login'] == 'f')) {
						//setTimeout('irLoginUsuario()', 1000);
						setTimeout(function() {
							irLoginUsuario();
						}, 1000);
					}

					if (row['onLoad'] != '') {
						setTimeout(row['onLoad'], 1);
					}
				}
				$('#cargandoVentana').hide();
				$('input[type=text]:first').focus();
			}
			if (ajax.readyState < 4) {
				//alert('ajax respuesta: cargarSeccion(' + seccion + ',' + aplicacion + ',' + parametros + ',' + elementoDest + ') -> ' + ajax.readyState);
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		if (parametros != '') {
			parametros = descodificarParametros(parametros);
			parametros = '&' + parametros;
		}
		ajax.send('seccion=' + seccion + '&aplicacion=' + aplicacion + '&elementoDest=' + elementoDest + parametros);
	}
}

function irLoginUsuario() {
	var accionLogin = "cargarSeccion(\'inicio\');";
	cargarSeccion('usuarios', 'logueo', 'ventana=no&accionLogin=' + accionLogin, 'entorno_contenido', false);
}

function cargarPDF(seccion, aplicacion, parametros, elementoDest) {
	if (aplicacion == null) {
		aplicacion = seccion;
	}
	if (parametros == null) {
		parametros = '';
	} else {
		parametros = '&' + parametros;
	}

	var url = 'index.php?o=pdf&s=' + seccion + '&a=' + aplicacion + parametros + '&cache=' + parseInt(Math.random() * 10000);
	OpenWin(url);
}

function OpenWin(url) {
	var win = window.open(url, '_blank');
	win.focus();
}

function cargarVentana(onLoad) {
	var ajax = $.ajax({
		type : 'post',
		url : 'index.php?o=ventana',
		data : {
			nivelVentana : nivelVentana,
			onLoad : onLoad,
			posClickX : posClickX,
			posClickY : posClickY
		},
		beforeSend : function(objeto) {
			if (posClickY < 100) {
				posClickY = 100;
			}
		}
	});

	ajax.done(function(data, textStatus, jqXHR) {

		var row = procesarCadena(data);

		var elemento = $('<div />', {
			id : 'ventana' + row['nivelVentana'],
		}).html(row['html']).prependTo('#ventanas');

		if (row['onLoad'] != '') {
			setTimeout(row['onLoad'], 1);
		}

		elemento.draggable({
			disabled : true
		});

		var titulo = '';
		var setTitle = function() {
			titulo = elemento.find('h1').text();
			elemento.find('.modal-title').text(titulo);

			if (titulo == '') {
				setTimeout(function() {
					setTitle();
				}, 100);
			} else {
				elemento.find('h1').hide();
			}
		}
		setTitle();

		ventanasCargadas++;

	}).always(function(data, textStatus, errorThrown) {
		if (textStatus == 'error') {

		}
	});
}

function dragVentana() {
	$("#ventana" + nivelVentana).draggable("option", "disabled", false);
}

function noDragVentana() {
	$("#ventana" + nivelVentana).draggable("option", "disabled", true);
}

var rowRPC1 = new Array();
var rowRPC2 = new Array();
var rowRPC3 = new Array();
var rowRPC4 = new Array();
var rowRPC5 = new Array();
var punteroRowRPC = 1;
var gPunteroRowRPC = new Array();
function cargarRespuestaRPC(nombreFuncion, row) {
	gPunteroRowRPC[nombreFuncion] = punteroRowRPC;
	if (punteroRowRPC == 1) {
		rowRPC1 = row;
		punteroRowRPC++;
	} else if (punteroRowRPC == 2) {
		rowRPC2 = row;
		punteroRowRPC++;
	} else if (punteroRowRPC == 3) {
		rowRPC3 = row;
		punteroRowRPC++;
	} else if (punteroRowRPC == 4) {
		rowRPC4 = row;
		punteroRowRPC++;
	} else if (punteroRowRPC == 5) {
		rowRPC5 = row;
		punteroRowRPC = 1;
	}
}

function resp() {//-- devuelve el valor asignado en cargarRespuestaRPC, la funcion se denomina resp para coincidir con la variable $resp[]
	var row = new Array();
	nombreFuncion = arguments.callee.caller.name + '();';
	if (gPunteroRowRPC[nombreFuncion] == 1) {
		row = rowRPC1;
	} else if (gPunteroRowRPC[nombreFuncion] == 2) {
		row = rowRPC2;
	} else if (gPunteroRowRPC[nombreFuncion] == 3) {
		row = rowRPC3;
	} else if (gPunteroRowRPC[nombreFuncion] == 4) {
		row = rowRPC4;
	} else if (gPunteroRowRPC[nombreFuncion] == 5) {
		row = rowRPC5;
	}
	return row;
}

var bandProcesandoRPC = new Array();

function rpcSeccion(seccion,accion,vParametros,accionSiguiente){
	var vParametros2 = new Array;
	
	//-- Si vParametros se recibi con el formato get lo transforma a un Array -------------
	if(Object.prototype.toString.call(vParametros) === '[object Array]'){
		vParametros2=vParametros;
	}else{
		if(vParametros!='' && vParametros!=undefined){
			var auxConvertDatos1 = new Array;
			var auxConvertDatos2 = new Array;
			var auxConvertDatosC = new Array;
			var aux2vParametros = vParametros;
			delete vParametros;
			var vParametros = new Array();
			auxConvertDatos1=explode(aux2vParametros,'&',false);
			for(auxConvertDatosC=0;auxConvertDatosC<auxConvertDatos1.length;auxConvertDatosC++){
				auxConvertDatos2=explode(auxConvertDatos1[auxConvertDatosC],'=',false);
				vParametros2[auxConvertDatos2[0]]=auxConvertDatos2[1];
			}
		}
	}
	
	//-- Verifica si existe el elemento ___________CadenaBuscar, en el caso que exista busca otros datos correspondientes a los listados  -----------
	if(accionSiguiente.substr(0,3)=='id:'){
		var contenedor = accionSiguiente.substr(3);
		if($('#' + contenedor + 'CadenaBuscar').val()!=undefined){
			
			vParametros2['contenedor']=contenedor;
			accionSiguiente='fn:armarLista();';

			vParametros2['cadenaBuscar'] = $('#' + contenedor + 'CadenaBuscar').val();
			
			if(vParametros2['orderBy']==undefined){
				if($('#' + contenedor + 'OrderBy').val()==undefined){				vParametros2['orderBy'] = '';					}else{	vParametros2['orderBy'] = $('#' + contenedor + 'OrderBy').val();}
			}
			
			if($('#' + contenedor + 'AccionPosSeleccionar').val()==undefined){	vParametros2['accionPosSeleccionar'] = '';		}else{	vParametros2['accionPosSeleccionar'] = $('#' + contenedor + 'AccionPosSeleccionar').val();}
			
			if(vParametros2['cantFilas']==undefined){
				if($('#' + contenedor + 'CantFilas').val()==undefined){				vParametros2['cantElementosExistentes'] = 0;	}else{	vParametros2['cantElementosExistentes'] = $('#' + contenedor + 'CantFilas').val();}
			}
			
			if($('#' + contenedor + 'CantElementosNuevos').val()==undefined){	vParametros2['cantElementosNuevos'] = 10;		}else{	vParametros2['cantElementosNuevos'] = $('#' + contenedor + 'CantElementosNuevos').val();}

			if(vParametros2['masFilas']=='true'){
				if(vParametros2['cantElementosExistentes']==0){
					cargando(contenedor,4,'cargando');
				}else{
					$('#' + contenedor + ' .cargandoMasRegistros').show();
					$('#' + contenedor + ' .verMasRegistros').remove();
					$('#' + contenedor + ' .inf').remove();
				}
			}else{
				vParametros2['cantElementosExistentes']=0;
				cargando(contenedor,4,'cargando');
			}
			
			//-- obtiene valores correspondientes a otros inputs dentro del form que se encentra contenedorCadenaBuscar
			var form = $('#' + contenedor + 'CadenaBuscar').parents('form');
			form.find('input,select').each(function(index, element){
				if($(element).prop('type')=='text' || $(element).prop('type')=='hidden' || $(element).prop('type')=='select-one'){
					if($(element).prop('id')!=contenedor + 'CadenaBuscar'){
						if($(element).prop('id').indexOf("_")!=-1){
							vParametros2[$(element).prop('id').substr($(element).prop('id').indexOf("_")+1)] = $('#'+$(element).prop('id')).val();
						}else{
							vParametros2[$(element).prop('id')] = $('#'+$(element).prop('id')).val();
						}
					}
				}
			});
			
			//-- obtiene valores indicador en contenedorOtrosDatos
			if($('#' + contenedor + 'OtrosDatos').val()!=undefined){
				var otrosDatos = $('#' + contenedor + 'OtrosDatos').val();
				if(otrosDatos!=''){
					var vOtrosDatos = new Array();
					var vAux = new Array();
					vOtrosDatos=explotarCadena(otrosDatos,',');
					for(i=0;i<vOtrosDatos.length;i++){
						vAux=explotarCadena(vOtrosDatos[i],'=');
						if(vAux[1]==undefined){vAux[1]=vAux[0];}
						vParametros2[vAux[0]] = $('#' + vAux[1]).val();
					}
				}
			}
		}
	}
	
	var identRPC = seccion + '-' + accion + '-' + accionSiguiente;
	if(bandProcesandoRPC[identRPC]==undefined){
		bandProcesandoRPC[identRPC]=0;
	}
	
	if(identRPC=='debug-agregar-undefined'){
		bandProcesandoRPC[identRPC]=0;
	}
	
	if(bandProcesandoRPC[identRPC]==0){
		bandProcesandoRPC[identRPC]=1;
		var ajax=nuevoAjax();
		ajax.open("POST", "index.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				var row = procesarCadena(ajax.responseText);

				if($('#submit_' + row['seccion'] + '_' + row['accionRPC']).length==1){
					//$('#submit_' + row['seccion'] + '_' + row['accionRPC']).val('aceptar');
					//$('#submit_' + row['seccion'] + '_' + row['accionRPC']).attr('style','');
					$('#submit_' + seccion + '_' + accion).button('reset');
				}
				
				//setTimeout(desactivarRPC(row['seccion'] + '-' + row['accionRPC'] + '-' + row['accionSiguiente']), 3000);
				desactivarRPC(row['seccion'] + '-' + row['accionRPC'] + '-' + row['accionSiguiente']);
				
				setTimeout(function(){
					desactivarRPC(row['seccion'] + '-' + row['accionRPC'] + '-' + row['accionSiguiente']);
				}, 3000);	
				
				if(ajax.responseText.substr(0,12)!='esq#->#ok#*#'){					
					if(ajax.responseText==''){
						alert('Se ha perdido la conección con el servidor, vuelva a intentarlo o consulte con el administrador de la red (rpcSeccion)');
					}else{
						var htmlRespuesta = ajax.responseText;
						var auxMensaje = row['mensaje'];
						auxMensaje=replaceAll(auxMensaje,"#chr10#",'\n');
						
						htmlRespuesta=replaceAll(htmlRespuesta,'esq#->','<hr>' + auxMensaje + '<hr><a href="javascript:mostrarOcultar(\'esqResp\');">ver respuesta del servidor</a><br><div id="esqResp" style="display:none;">esq#=>')+'</div>';
						
						$('#vistaErrorFueraEsquema').show();
						$('#vistaErrorFueraEsquema_contenido').html(htmlRespuesta);
					}
				}else{
					if(row['mensaje']!=''){
						dialogo(row['mensaje'],row['mensajeBotones']);
					}else{
						if(row['accionSiguiente']!=''){
							
							if(row['accionSiguiente'].substr(0,3)=='id:'){
								var idElemento = row['accionSiguiente'].substr(3,row['accionSiguiente'].length-3);
								if(document.getElementById(idElemento)=='[object HTMLInputElement]'){
									$('#' + idElemento).val(row['html']);
								}else{
									$('#' + idElemento).html(row['html']);
								}
							}else if(row['accionSiguiente'].substr(0,4)=='id.:'){
								var idElemento = row['accionSiguiente'].substr(4,row['accionSiguiente'].length-4);
								if(document.getElementById(idElemento)=='[object HTMLInputElement]'){
									$('#' + idElemento).val($('#' + idElemento).val() + row['html']);
								}else{
									$('#' + idElemento).html($('#' + idElemento).html() + row['html']);
								}
							}else if(row['accionSiguiente'].substr(0,3)=='fn:'){
								var nombreFuncion = row['accionSiguiente'].substr(3,row['accionSiguiente'].length-3);
								rowRPC = row;
								cargarRespuestaRPC(nombreFuncion,row);
								setTimeout(nombreFuncion, 1); 
							}else if(row['accionSiguiente'].substr(0,5)=='idfn:'){
								var idElemento = row['accionSiguiente'].substr(5,row['accionSiguiente'].indexOf(';')-5);
								var nombreFuncion = row['accionSiguiente'].substr(row['accionSiguiente'].indexOf(';')+1,row['accionSiguiente'].length-row['accionSiguiente'].indexOf(';')-1);
								
								if(document.getElementById(idElemento)=='[object HTMLInputElement]'){
									$('#' + idElemento).val(row['html']);
								}else{
									$('#' + idElemento).html(row['html']);
								}
								
								rowRPC = row;
								setTimeout(nombreFuncion, 1);
							}
						}
					}
					
					if((row['exigir_login']=='t')&&(row['estado_login']=='f')){
						setTimeout('irLoginUsuario()', 1000);
					}
					
					mostrarOcultarSegunPermisos(row['permisosHabilitados'],row['permisosNoHabilitados']);
				}
			}
			if(ajax.readyState<4){
				//alert('ajax respuesta: rpcSeccion(' + seccion + ',' + accion + ') -> ' + ajax.readyState);
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var cparametros='';
		var auxValor='';
		cparametros+='o=secciones';
		cparametros+='&seccion=' + seccion;
		cparametros+='&accionRPC=' + accion;
		cparametros+='&accionSiguiente=' + accionSiguiente;
		for(name in vParametros2){
			auxValor = vParametros2[name];
			if((auxValor!=true)&&(auxValor!=false)&&(auxValor!=undefined)){
				auxValor=auxValor.toString();
				auxValor=replaceAll(auxValor,'&','746t985otroParametro746t985');
			}
			cparametros+='&' + name + '=' + auxValor;
		}
		cparametros=replaceAll(cparametros,"+",'|signomas|');
		ajax.send(cparametros);	
		
		if($('#submit_' + seccion + '_' + accion).length==1){
			/*$('#submit_' + seccion + '_' + accion).val('  procesando');
			$('#submit_' + seccion + '_' + accion).css('background-image','url(fuentestra/imagenes/loader/ajax-loader-horiz-c-gris.gif)');
			$('#submit_' + seccion + '_' + accion).css('background-position','0px 8px');*/
			$('#submit_' + seccion + '_' + accion).data('loading-text', '<i class="glyphicon glyphicon-refresh spin"></i> Espere...').button('loading');
		}
		
	}
}

function desactivarRPC(accion) {
	bandProcesandoRPC[accion] = 0;
}

function mostrarOcultarSegunPermisos(permisosHabilitados, permisosNoHabilitados) {
	var i = 0;
	if (permisosHabilitados != '') {
		var vPermisosHabilitados = new Array();
		vPermisosHabilitados = explotarCadena(permisosHabilitados, ',');
		for ( i = 0; i < vPermisosHabilitados.length; i++) {
			//alert( 'show: ' + '.permiso_' + vPermisosHabilitados[i]);
			$('.permiso_' + vPermisosHabilitados[i]).show();
		}
	}

	if (permisosNoHabilitados != '') {
		var vPermisosNoHabilitados = new Array();
		vPermisosNoHabilitados = explotarCadena(permisosNoHabilitados, ',');
		for ( i = 0; i < vPermisosNoHabilitados.length; i++) {
			//alert( 'hide: ' + '.permiso_' + vPermisosNoHabilitados[i]);
			$('.permiso_' + vPermisosNoHabilitados[i]).hide();
		}
	}
}

function nuevoAjax() {
	var xmlhttp = false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function procesarCadena(cadena) {
	var v1 = new Array();
	var v2 = new Array();
	var row = new Array();

	separadorAsignacion = '#->#';
	separadorCampo = '#*#' + String.fromCharCode(13) + String.fromCharCode(10);
	v1 = explotarCadena(cadena, separadorCampo);
	for ( i = 0; i < v1.length; i++) {
		v2 = explotarCadena(v1[i], separadorAsignacion);
		row[v2[0]] = v2[1];
	}
	return row;
}

function explotarCadena(cadena, separador) {
	return cadena.split(separador);
}

function cargando(elementoId, tipo, detalle) {
	var imagen = '';
	if (detalle == null) {
		detalle = '';
	} else {
		detalle = '<td>' + detalle + '</td>';
	}

	if (tipo == null) {
		tipo = 1;
	}
	if (tipo == 1) {
		imagen = 'ajax-loader-circ-c-gris.gif';
	}
	if (tipo == 2) {
		imagen = 'ajax-loader-horiz-c-gris.gif';
	}
	if (tipo == 3) {
		imagen = 'ajax-loader-horiz-g-gris.gif';
	}
	if (tipo == 4) {
		imagen = 'ajax-loader-horiz-m-gris.gif';
	}
	//$('#' + elementoId).html('<table><tr>' + detalle + '<td><img src="fuentestra/imagenes/loader/' + imagen + '"></td></tr></table>');
	//$('#' + elementoId).html('<div class="col-md-2 col-md-offset-5" style="font-size: 32px; text-align: center"> <span class="glyphicon glyphicon-refresh spin"></span></div>');

	$('#' + elementoId).html($('<div />').addClass('text-center').css('font-size', 32).html('<div class="text-center" style="font-size: 32px;"><i class="glyphicon glyphicon-refresh spin"></i></div>'));
}

function codificarParametros(cadena) {
	cadena = replaceAll(cadena, '=', '746t985esIgual746t985');
	cadena = replaceAll(cadena, '&', '746t985otroParametro746t985');
	cadena = replaceAll(cadena, "'", '746t985comillaSimple746t985');
	return cadena;
}

function descodificarParametros(cadena) {
	cadena = replaceAll(cadena, '746t985esIgual746t985', '=');
	cadena = replaceAll(cadena, '746t985otroParametro746t985', '&');
	cadena = replaceAll(cadena, '746t985comillaSimple746t985', "'");
	return cadena;
}

function dialogo(texto, botones, imagen) {
	if (imagen == null) {
		imagen = 'advertencia';
	}
	if (botones == null) {
		botones = 'aceptar';
	}

	var dialogo = $('#dialogo:last');

	dialogo.find('.modal-body p').html(texto);

	var opciones = botones.split('|');
	var boton;
	var style;
	var btnFunction;
	var button = '';

	for (var i = 0; i < opciones.length; i++) {
		boton = opciones[i].split(':');
		style = (i == 0) ? 'btn btn-primary' : 'btn btn-default';

		btnFunction = (boton[1] == null) ? '' : boton[1];

		button += '<button data-dialogo="' + boton[0] + '" onclick="' + btnFunction + '" class="' + style + '">' + boton[0] + '</button>\n';
	}

	dialogo.find('#dialogo-botones').html(button);
	dialogo.fadeIn();
	$('#panel-bloqueado').addClass('bloqueado');

	dialogo.on('click', 'button', function() {
		if ($(this).attr('onclick') != '') {
			$(this).data('loading-text', '<i class="glyphicon glyphicon-refresh spin"></i>').button('loading');
		} else {
			cerrarDialogo();
		}
	});
}

function cerrarDialogo() {
	var dialogo = $('#dialogo:last');

	dialogo.fadeOut();
	$('#panel-bloqueado').removeClass('bloqueado');
}

function replaceAll(text, stringToFind, stringToReplace) {
	if (text == null) {
		return '';
	}
	if (text == '') {
		return '';
	}
	var index = text.indexOf(stringToFind);
	while (index != -1) {
		text = text.replace(stringToFind, stringToReplace);
		index = text.indexOf(stringToFind);
	}
	return text;
}

function cerrarVistaFueraDeEsquema() {
	$('#vistaErrorFueraEsquema').hide();
}

/** CODIGO EXTERNO **/

// jQuery formatted selector to search for focusable items
var focusableElementsString = "a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]";

// store the item that has focus before opening the modal window
var focusedElementBeforeModal;

setInitialFocusModal($('#dialogo'));

$('#dialogo').keydown(function(event) {
	trapTabKey($(this), event);
});

$(window).keydown(function(event) {
	setInitialFocusModal($('#dialogo'));
});

function trapTabKey(obj, evt) {
	// if tab or shift-tab pressed
	if (evt.which == 9) {

		// get list of all children elements in given object
		var o = obj.find('*');

		// get list of focusable items
		var focusableItems;
		focusableItems = o.filter(focusableElementsString).filter(':visible')

		// get currently focused item
		var focusedItem;
		focusedItem = jQuery(':focus');

		// get the number of focusable items
		var numberOfFocusableItems;
		numberOfFocusableItems = focusableItems.length

		// get the index of the currently focused item
		var focusedItemIndex;
		focusedItemIndex = focusableItems.index(focusedItem);

		if (evt.shiftKey) {
			//back tab
			// if focused on first item and user preses back-tab, go to the last focusable item
			if (focusedItemIndex == 0) {
				focusableItems.get(numberOfFocusableItems - 1).focus();
				evt.preventDefault();
			}

		} else {
			//forward tab
			// if focused on the last item and user preses tab, go to the first focusable item
			if (focusedItemIndex == numberOfFocusableItems - 1) {
				focusableItems.get(0).focus();
				evt.preventDefault();
			}
		}
	}

}

function setInitialFocusModal(obj) {
	// get list of all children elements in given object
	var o = obj.find('*');

	// set focus to first focusable item
	var focusableItems;
	focusableItems = o.filter(focusableElementsString).filter(':visible').first().focus();

}

var acDependiente = [];
var valoresSeleccionados = [];
function autocompletar(seccion, elemento, lista, ae, param) {
	var cache = [], rpc, nameId;

	var str = elemento;
	var n = str.search(/_[0-9]/i);

	if (n >= 0) {
		rpc = elemento.substr(0, n);
		nameId = elemento.substr(0, n) + 'Id[]';
	} else {
		rpc = elemento;
		nameId = elemento + 'Id';
	}

	var input = $('#' + elemento);

	var div = input.parent('div');

	var accion = $('<div />');

	if (div.parent().is('td')) {
		div.addClass('has-feedback')
	} else {
		if (div.parent('div').hasClass('form-group')) {
			div.parent('div').addClass('has-feedback');
		}
	}

	var cLista, cAe, sLista, sAe, aLista, aAe;

	cLista = lista.split('|');
	cAe = ae.split('|');

	if (cLista.length > 1) {
		sLista = cLista[0];
		aLista = cLista[1];
	} else {
		sLista = seccion;
		aLista = cLista[0];
	}

	if (cAe.length > 1) {
		sAe = cAe[0];
		aAe = cAe[1];
	} else {
		sAe = seccion;
		aAe = cAe[0];
	}

	var search = $('<span />');
	if (lista!=''){	
		var search = $('<a />', {
			class : 'form-control-feedback ac-search',
			href : 'javascript:cargarSeccion(\''+ sLista +'\',\''+ aLista +'\',\'accionPosSeleccionar=id:'+elemento+'Id,'+elemento+'\',\'ventana\');'
		}).html('<i class="glyphicon glyphicon-search"></i>').appendTo(accion);
	}
	
	var plus = $('<span />');
	if (ae!=''){
		var plus = $('<a />', {
			class : 'form-control-feedback ac-plus hidden',
			href : 'javascript:cargarSeccion(\''+ sAe +'\',\''+ aAe +'\',\'valor='+ elemento +'\',\'ventana\');'
		}).html('<i class="glyphicon glyphicon-plus-sign"></i>').appendTo(accion);
	}

	var check = $('<span />', {
		class : 'form-control-feedback ac-check hidden'
	}).html('<i class="glyphicon glyphicon-ok"></i>').appendTo(accion);

	var loading = $('<span />', {
		class : 'form-control-feedback ac-loading hidden'
	}).html('<i class="glyphicon glyphicon-refresh spin"></i>').appendTo(accion);

	//div.append(accion);
	accion.appendTo(div);

	var id = $('<input />', {
		type : 'hidden',
		name : nameId,
		id : elemento + 'Id'
	}).appendTo(div).ready(function() {
		cache = new Array();
		acDependiente[elemento] = [];
	}).val(input.data('id'));

	if (param != null) {
		var params = param.split(',');
		for (var i = 0; i < params.length; i++) {

			accion.find('a,span').addClass('hidden');
			if ($('#' + params[i] + 'Id').val() == '') {
				input.prop('disabled', true);
			}

			acDependiente[params[i]].push(elemento);
		}
	}

	var valorSeleccionado;

	input.autocomplete({
		open : function() {
			$(this).autocomplete('widget').css('z-index', 99999);
			return false;
		},
		create : function(event, ui) {
			var valor = this;
			setTimeout(function() {
				if (id.val() != '') {
					valorSeleccionado = valor.value;
					accion.find('a,span').addClass('hidden');
					check.removeClass('hidden');
				}
			});

		},
		source : function(request, response) {
			var term = request.term;

			if ( term in cache) {
				response(cache[term]);
				return;
			}

			accion.find('a,span').addClass('hidden');
			loading.removeClass('hidden');

			var p = [];

			if (param != null) {
				var params = param.split(',');
				var key;
				for (var i = 0; i < params.length; i++) {
					if ($('#' + params[i] + 'Id').val() != null) {
						key = params[i].split('_');
						p[i] = key[1] + '=' + $('#' + params[i] + 'Id').val();
					}
				}
			}

			$.getJSON('index.php?o=secciones&seccion=' + seccion + '&accionRPC=' + rpc + '&' + p.join('&'), request, function(data, status, xhr) {
				cache[term] = data;
				response(data);

				accion.find('a,span').addClass('hidden');
				if (input.value == '') {
					search.removeClass('hidden');
				} else {
					plus.removeClass('hidden');
				}
			});
		},
		autoFocus : true,
		search : function(event, ui) {
			if (ui.content) {
				accion.find('a,span').addClass('hidden');
				search.removeClass('hidden');
			}
		},
		change : function(event, ui) {
			$.getJSON('index.php?o=secciones&seccion=' + seccion + '&accionRPC=' + rpc + '&term=' + this.value, function(data, status, xhr) {
				$(data).each(function(index, element) {
					if (data[index].valor.toLowerCase() == input.val().toLowerCase().trim()) {
						id.val(data[index].id);
						input.val(data[index].valor);

						valorSeleccionado = data[index].valor;

						$(acDependiente[elemento]).each(function(index, element) {
							inputDependiente = $('#' + element);
							inputDependiente.siblings('div').find('a:eq(0)').removeClass('hidden');
							inputDependiente.prop('disabled', false);
						});

						accion.find('a,span').addClass('hidden');
						check.removeClass('hidden');

						return false;
					}
				});

			});
		},
		select : function(event, ui) {
			if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
				event.preventDefault();
			} else {
				id.val(ui.item.id);
				$(this).val(ui.item.valor);

				valorSeleccionado = ui.item.valor;

				accion.find('a,span').addClass('hidden');
				check.removeClass('hidden');
				return false;
			}
		}
	})
	.bind("focus", function() {		
		if (!valoresSeleccionados[elemento]) {
			valorSeleccionado = valoresSeleccionados[elemento];
		}
		//alert(valorSeleccionado +'=='+ this.value);
	})
	.bind("change", function(e) {
		accion.find('a,span').addClass('hidden');
		var inputDependiente;

		if(this.value == ''){
			$(acDependiente[elemento]).each(function(index, element) {
				inputDependiente = $('#'+ element);
				inputDependiente.siblings('div').find('a,span').addClass('hidden');
            	inputDependiente.val(null).prop('disabled', true);
				$('#'+ element + 'Id').val(null);
            });			
			
			id.val('');
			valorSeleccionado = null;
			search.removeClass('hidden');
		}else if(valorSeleccionado == this.value) {
			$(acDependiente[elemento]).each(function(index, element) {
				inputDependiente = $('#'+ element);
				inputDependiente.siblings('div').find('a:eq(0)').removeClass('hidden');
            	inputDependiente.prop('disabled', false);
            });
			
			check.removeClass('hidden');			
		}else{
			$(acDependiente[elemento]).each(function(index, element) {
				inputDependiente = $('#'+ element);
				inputDependiente.siblings('div').find('a,span').addClass('hidden');
            	inputDependiente.val(null).prop('disabled', true);
				$('#'+ element + 'Id').val(null);
            });	
						
			id.val('');
			valorSeleccionado = null;
			plus.removeClass('hidden');
		}
	})
	.data("ui-autocomplete")._renderItem = function(ul, item) {
		return $('<li>').append('<a>' + item.valor + '</a>').appendTo(ul);
	};
}

function checkAutocompletar(elemento) {
	var input = $('#' + elemento);
	valoresSeleccionados[elemento] = $('#' + elemento + 'Id').val();

	var accion = input.next('div');
	accion.find('a,span').addClass('hidden');
	accion.children('.ac-check').removeClass('hidden');
}

function clearCheckAutocompletar(elemento) {
	var input = $(elemento);
	valoresSeleccionados[elemento] = '';
	
	input.val('');
	input.siblings('input').val('');

	var accion = input.next('div');
	accion.find('a,span').addClass('hidden');
	accion.children('.ac-search').removeClass('hidden');
}