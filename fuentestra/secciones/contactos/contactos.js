function enviarInfoFormContacto(){
	var datos = new Array();	
	datos['nombre']=$('#nombre').val();
	datos['correo']=$('#correo').val();
	datos['telefono']=$('#telefono').val();
	datos['asunto']=$('#asunto').val();
	datos['mensaje']=$('#mensaje').val();
	if((datos['nombre']=='')||(datos['correo']=='')||(datos['mensaje']=='')){
		alert('Debe completar los campos marcados con asterisco');
	}else{
		rpcSeccion('contactos','enviarMensaje',datos,'');
	}
}