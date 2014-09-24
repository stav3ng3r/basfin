function inicializar_sistema_proyecto(){

}

function seleccionarSistemaProyecto() {
	var datos = new Array();
	datos['idProyecto'] = $('#sistProyecto_proyecto').val();

	if(datos['proyecto']=='') {
		dialogo('Seleccione un proyecto');	
	}else{
		rpcSeccion('sistema','seleccionarProyecto',datos,'fn:posSeleccionarSistemaProyecto();');
	}
}

function posSeleccionarSistemaProyecto() {
	cargarSeccion('menu','','','areaMenu');
	cargarSeccion('inicio','inicio','');
	cerrarVentana();
}