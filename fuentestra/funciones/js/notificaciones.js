var tiempoEspera = 5;
var esperar = false;
var inicioVerificacion = null;


function initNotificaciones() {
	$("body").mousemove(function(event) {
	
		if (esperar) {
			return;
		}
		verificarNotificaciones();
	
	});
}

function verificarNotificaciones() {
	var curTiempo = new Date();
	if (esperar == false && (inicioVerificacion == null || (curTiempo - inicioVerificacion) >= (tiempoEspera * 1000))) {
		esperar = true;
		inicioVerificacion = new Date();
		rpcSeccion('notificacion', 'verficiarNotificaciones', '', 'fn:obtenerNotificaiones()');
	}

}

function obtenerNotificaiones() {
	var respuesta = rowRPC;
	console.log(rowRPC);

	if (respuesta['tiempoEspera'] == 'f') {
		esperar = false;
		return;
	}

	if (respuesta['nuevasNotificaciones'] == 't' && respuesta['notificaciones'] != '') {
		$('#notificaciones').prepend(respuesta['notificaciones']);
		setTimeout(mostrarNotificaciones, 500);
	}

	//setTimeout(verificarNotificaciones, respuesta['tiempoEspera']);
}

function mostrarNotificaciones() {
	$('.alert').addClass('in');
	esperar = false;
}
