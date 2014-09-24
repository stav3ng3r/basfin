function inicializar_movimientos_movimientos_lista(){
	listarMovimientosMovimientos();
	
	var grafico = $('#rcks').data('grafico');
	
	var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'rcks',
			type: 'line',
			animation: true
		},
		title: {
			text: 'Movimientos'
		},
		xAxis: {
			categories: grafico.fechas,
			labels: {
				enabled:false
			}
		},
		yAxis: {
			title: {
				text: ''
			},
			min: 0,
			allowDecimals: false
		},
		tooltip: {
			shared: true,
			crosshairs: true
		},
		legend: {
			layout: 'horizontal',
			align: 'center',
			verticalAlign: 'bottom',
			borderWidth: 0
		},
		series: grafico.datos,
		credits: {
			enabled: false
		}
	});
}

function listarMovimientosMovimientos(){
	cargando('listaMovimiento',4,'cargando');
	var datos = new Array();
	datos['cadenaBuscar'] = $('#listaMovimientoCadenaBuscar').val();
	datos['accionPosSeleccionar'] = $('#listaMovimientoAccionPosSeleccionar').val();
	rpcSeccion('movimientos','movimientosListar',datos,'id:listaMovimiento');
}

function eliminarMovimiento(idMovimiento){
	var datos = new Array();
	datos['idMovimiento'] = idMovimiento;
	rpcSeccion('movimientos','movimientoEliminar',datos,'fn:listarMovimientosMovimientos();cerrarDialogo();');
}

function volverListado(){
	$("#listaMovimientoContenido").fadeIn();
	$("#deslizar_contenido").fadeOut();
}

function salirListado(){
	$("#listaMovimientoContenido").fadeOut();
	$("#deslizar_contenido").fadeIn();
}