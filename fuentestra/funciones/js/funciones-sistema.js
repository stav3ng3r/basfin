function invitarPorFacebook(idRed){
	$('#aHrefCompartirFacebook').click();
}
function inscribirloYoMismo(idRed){
	mostrar('cargando');
	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/red.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			ocultar('cargando');
			var row=procesarCadena(ajax.responseText);
			if(row['mensaje']=='ok'){
				ocultar('cargando');
				document.location = row['ir'];
			}else{
				alert('Ha ocurrido algún inconveniente, intenete nuevamente más tarde o pongase en contacto con el administrador del sitio');
			}
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send('accion=inscribirloYoMismo&idRed=' + idRed);		
}
function ventanaInvitarPorCorreo(idRed){
	mostrar('cargando');
	var ajax=nuevoAjax();
	ajax.open("POST", "ventana.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			$('#verMasContenido').html(ajax.responseText);
			ocultar('cargando');
			mostrar('ventanaVerMas');
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send('ventana=invitar&idRed=' + idRed);
}
function enviarEmailInvitar(idRed){
	var nombre = $('#invitarNombre').val();
	var correo = $('#invitarCorreo').val();
	var mensaje = new Array();
	var c = 0;
	
	if(nombre==''){
		mensaje[c]='debe ingresar el nombre';
		c++;
	}
	if(correo==''){
		mensaje[c]='debe ingresar el e-mail';
		c++;
	}
	
	if(mensaje.length>0){
		mostrarMensajeError(mensaje);
	}else{
		mostrar('cargando');
		var ajax=nuevoAjax();
		ajax.open("POST", "procesos/red.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				ocultar('cargando');
				var row=procesarCadena(ajax.responseText);
				if(row['mensaje']=='ok'){
					ocultar('ventanaVerMas');
					var vMens = new Array(row['mensaje2']);
					mostrarMensajeError(vMens);
				}else{
					alert('Ha ocurrido algún inconveniente, intenete nuevamente más tarde o pongase en contacto con el administrador del sitio');
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send('accion=enviarEmailInvitar&idRed=' + idRed + '&nombre=' + nombre + '&correo=' + correo);	
	}
}
function iniciarRed(tipo){
	var idRed = $('#idRed').val();
	if(tipo=='sin-invitacion'){
		idRed='';
	}
	mostrar('cargando');
	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/red.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			ocultar('cargando');
			var row=procesarCadena(ajax.responseText)
			if(row['mensaje']=='ok'){
				irSector('detalle-proceso&idProceso=' + row['idProceso']);
			}else{
				$('#mensajeErrorInvitacion').html(row['mensaje']);
			}
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send('accion=iniciar-red&idRed=' + idRed);
}
function utilizarMecanismoOficina(){
	mostrar('cargando');
	var idProceso = $('#idProceso').val();
	var ajax=nuevoAjax();
	ajax.open("POST", "procesos/red.php",true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			ocultar('cargando');
			var row=procesarCadena(ajax.responseText);
			if(row['mensaje']=='ok'){
				irSector('mensaje-final-nueva-red&idProceso=' + idProceso);
			}else{
				alert('Ha ocurrido algún inconveniente, intenete nuevamente más tarde o pongase en contacto con el administrador del sitio');
			}
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send('accion=modoDePago&idProceso=' + idProceso + '&modo=oficina');
}
function utilizarMecanismoMototaxi(){
	var idProceso = $('#idProceso').val();
	var direccion = $('#mecanismoMototaxiDireccion').val();
	var barrio = $('#mecanismoMototaxibBarrio').val();
	var ciudad = $('#mecanismoMototaxiCiudad').val();
	var telefono = $('#mecanismoMototaxiTelefono').val();
	var horario = $('#mecanismoMototaxiHorario').val();
	
	var mensaje = new Array();
	var c = 0;
	
	if(direccion==''){
		mensaje[c]='debe ingresar su dirección';
		c++;
	}
	if(barrio==''){
		mensaje[c]='debe ingresar su barrio';
		c++;
	}
	if(ciudad==''){
		mensaje[c]='debe ingresar la ciudad';
		c++;
	}
	if(telefono==''){
		mensaje[c]='debe ingresar su teléfono';
		c++;
	}
	if(horario==''){
		mensaje[c]='debe indicarnos a que horario le ubicamos en la dirección que indico';
		c++;
	}
	
	if(mensaje.length>0){
		mostrarMensajeError(mensaje);
	}else{
		mostrar('cargando');
		var ajax=nuevoAjax();
		ajax.open("POST", "procesos/red.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				ocultar('cargando');
				var row=procesarCadena(ajax.responseText);
				if(row['mensaje']=='ok'){
					irSector('mensaje-final-nueva-red&idProceso=' + idProceso);
				}else{
					alert('Ha ocurrido algún inconveniente, intenete nuevamente más tarde o pongase en contacto con el administrador del sitio');
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send('accion=modoDePago&idProceso=' + idProceso + '&modo=mototaxi&direccion=' + direccion + '&barrio=' + barrio + '&ciudad=' + ciudad + '&telefono=' + telefono + '&horario=' + horario);
	}
}

//--------------------------------------------------------------------------------------

function desloguear(){
	rpcSeccion('usuarios','desloguear','','fn:datosUsuario();');
	cargarSeccion('entorno', 'entorno', '', 'cuerpo');
}
function datosUsuario(){
	rpcSeccion('usuarios','datosUsuario','','id:datosUsuario');
}
function solicitarLogin(){
	rpcSeccion('usuarios','verificarEstadoLogueo','','fn:posSolicitarLogin();');
}
function posSolicitarLogin(){
	var row = rowRPC;
	if(row['estado']=='out'){
		cargarSeccion('usuarios','logueo','','ventana');
	}
}
function cargarListadoRelArchivos(){
	var row = rowRPC;
	for(i=(parseInt(cListaRelArchivos)+1);i<=row['cListaRelArchivos'];i++){
		$('#listadoRelArchivos').html($('#listadoRelArchivos').html() + row['htmlArchivo'+i]);
		vListaRelArchivos[i]=row['idArchivo' + i];
	}
	cListaRelArchivos=row['cListaRelArchivos'];
	
	for(i=1;i<=cListaRelArchivos;i++){
		$('#archivoRel' + i + ' .up').show();
		$('#archivoRel' + i + ' .down').show();
	}
	$('#archivoRel1 .up').hide();
	$('#archivoRel' + cListaRelArchivos + ' .down').hide();
}
function quitarArchivoDeListadoRelArchivos(idArchivo){
	var i=0;
	for(i=1;i<=cListaRelArchivos;i++){
		if(vListaRelArchivos[i]==idArchivo){
			orden=i;
		}
	}
	var html='';
	var c=0;
	var b=0;
	for(i=1;i<=cListaRelArchivos;i++){
		if(i!=orden){
			c++;
			html+='<div id="archivoRel' + c + '">' + $('#archivoRel' + i).html() + '</div>';
			if(b==1){
				vListaRelArchivos[c]=vListaRelArchivos[i];
			}
		}else{
			b=1;
		}
	}
	$('#listadoRelArchivos').html(html);
	cListaRelArchivos--;

	for(i=1;i<=cListaRelArchivos;i++){
		$('#archivoRel' + i + ' .up').show();
		$('#archivoRel' + i + ' .down').show();
	}	
	$('#archivoRel1 .up').hide();
	$('#archivoRel' + cListaRelArchivos + ' .down').hide();
}
function moverArchivoDeListadoRelArchivos(idArchivo,direccion){
	var i=0;
	var gId=0;
	var html = '';
	for(i=1;i<=cListaRelArchivos;i++){
		if(vListaRelArchivos[i]==idArchivo){
			orden=i;
		}
	}
	for(i=1;i<=cListaRelArchivos;i++){
		if(((direccion=='up')&&(i==orden-1))||((direccion=='down')&&(i==orden))){
			html+='<div id="archivoRel' + i + '">' + $('#archivoRel' + (i+1)).html() + '</div>';
			html+='<div id="archivoRel' + (i+1) + '">' + $('#archivoRel' + i).html() + '</div>';
			gId=vListaRelArchivos[i];
			vListaRelArchivos[i]=vListaRelArchivos[i+1];
			vListaRelArchivos[i+1]=gId;
			i=i+1
		}else{
			html+='<div id="archivoRel' + i + '">' + $('#archivoRel' + i).html() + '</div>';
		}
	}
	$('#listadoRelArchivos').html(html);
	
	for(i=1;i<=cListaRelArchivos;i++){
		$('#archivoRel' + i + ' .up').show();
		$('#archivoRel' + i + ' .down').show();
	}
	$('#archivoRel1 .up').hide();
	$('#archivoRel' + cListaRelArchivos + ' .down').hide();
}
function obtenerIdsArchivosDeListadoRelArchivos(){
	var cadena='';
	for(i=1;i<=cListaRelArchivos;i++){
		if(cadena!=''){cadena+=',';}
		cadena+=vListaRelArchivos[i];
	}
	return cadena;
}
function armarLista(){
	var row = rowRPC;
	if(row['html']==''){
		$('#' + row['contenedor'] + ' .inf').show();
		$('#' + row['contenedor'] + ' .cargandoMasRegistros').remove();
	}else{
		$('#' + row['contenedor'] + ' .inf').remove();		
		$('#' + row['contenedor'] + 'CantFilas').val(row['cantFilas']);
		$('#' + row['contenedor'] + ' .cargandoMasRegistros').remove();
		if(row['html'].substring(0,6)=='<table'){
			$('#' + row['contenedor']).html(row['html']);
		}else{
			$('#' + row['contenedor'] + ' table').html($('#' + row['contenedor'] + ' table').html() + row['html']);
		}
	}
}
function eliminarTrDeLista(elementoLista,id){
	$('#' + elementoLista + ' tbody tr').attr('data-id', function(i, v){
		if(v==id){
			$(this).fadeOut(500,function(){$(this).remove();});
			$('#' + elementoLista + ' #cantResultados').html(aNumero($('#' + elementoLista + ' #cantResultados').html())-1);
			$('#' + elementoLista + 'CantFilas').val(aNumero($('#' + elementoLista + 'CantFilas').val())-1);
		}
	});
}
function asignarValorTdLista(elementoLista,id,tdName,valor){
	$('#' + elementoLista + ' tr').attr('data-id', function(i, v){
		if(v==id){
			
			$(this).children('td').attr('data-name', function(i2, v2){
				if(v2==tdName){
					
					$(this).html(valor);
					
				}
			});
			
		}
	});
}
function existe_funcion(nombre_funcion){
	return eval('(typeof('+nombre_funcion+') == "function");') ? true : false;
}
function debug(proceso,bandera,resultado){
	if(resultado==undefined){
		resultado='';
	}
	var datos = new Array();
	datos['proceso']=proceso;
	datos['bandera']=bandera;
	datos['resultado']=resultado;
	rpcSeccion('debug','agregar',datos);
}
function seleccionarDeListado(prefijo,id,descripcion){
	if(!document.getElementById(prefijo + 'AccionPosSeleccionar')){
		alert('Debes crear el elemento input type hidden "' + prefijo + 'AccionPosSeleccionar' + '"');
	}else{
		var accionPosSeleccionar = $('#' + prefijo + 'AccionPosSeleccionar').val();
		cerrarVentana();
		
		
		if(accionPosSeleccionar.substring(0,3)=='fn:'){
			var funcion = accionPosSeleccionar.substring(3);
			var llamarFuncion = funcion + '(' + id + ');';
			setTimeout(llamarFuncion, 1);
		}else if(accionPosSeleccionar.substring(0,3)=='id:'){
			var vIds = new Array();
			vIds=explode(accionPosSeleccionar.substring(3), ',');
			if(vIds[0]!=undefined){
				if(!document.getElementById(vIds[0])){
					alert('No se encuentra el elemento ' + vIds[0]);
				}else{
					if($('#' + vIds[0]).is('input')==true){
						$('#' + vIds[0]).val(id);
						checkAutocompletar(vIds[0]);
					}else{
						$('#' + vIds[0]).html(id);
					}
				}
			}
			if(vIds[1]!=undefined){
				if(!document.getElementById(vIds[1])){
					alert('No se encuentra el elemento ' + vIds[1]);
				}else{
					if($('#' + vIds[1]).is('input')==true){
						$('#' + vIds[1]).val(descripcion);
						checkAutocompletar(vIds[1]);
					}else{
						$('#' + vIds[1]).html(descripcion);
					}
				}
			}
		}
	}
}
function reporte(alias){
	cargarSeccion('generador_reportes','filtro_reporte','alias=' + alias,'ventana');
}
function denominar(seccion,accionRPC,id,destinoDenominacion){
	if(id==''){
		$('#' + destinoDenominacion).html('&nbsp;');
	}else{
		cargando(destinoDenominacion,2);
		var datos = new Array();
		datos['id'] = id;
		rpcSeccion(seccion,accionRPC,datos,'id:' + destinoDenominacion);
	}
}