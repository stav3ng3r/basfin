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
	rpcSeccion('movimientos','movimientosListar','','id:listaMovimiento');
}

function eliminarMovimiento(idMovimiento){
	var datos = new Array();
	datos['idMovimiento'] = idMovimiento;
	rpcSeccion('movimientos','movimientoEliminar',datos,'fn:posEliminarCategoria();');
}

function posEliminarCategoria(){
	var row=rowRPC;
	eliminarTrDeLista('listaMovimiento',row['id']);
	cerrarDialogo();
}