function insertarEditarContacto(){
	var datos = new Array();
	datos['nombreContacto']=$('#nombreContacto').val();
	if(datos['nombreContacto']==''){
		dialogo('Debe completar todos los campos marcados con asterisco');
	}else{
		cerrarVentana(nivelVentana);
		rpcSeccion('contactos','insertarContacto',datos,'');
	}
}

function opcionSi(){
	alert('siiiiii');
}

function opcionNo(){
	alert('la verdad que nbo');	
}