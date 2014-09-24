function insertarEditarConcepto(){
	var datos = new Array();
	datos['nombreConcepto']=$('#nombreConcepto').val();
	if(datos['nombreConcepto']==''){
		dialogo('Debes completar todos los campos marcados con asterisco');
	}else{
		cerrarVentana(nivelVentana);
		rpcSeccion('conceptos','insertarConcepto',datos,'');
	}
}