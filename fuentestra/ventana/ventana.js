function cerrarVentana(nivel){
	if(nivel==null){
		nivel=nivelVentana;
	}
	if(nivelVentana>0){
		
		if(guardaSeccionVentana[nivelVentana]=='segui_docum_documento_vista'){
			if(existe_funcion('finalizar_' + guardaSeccionVentana[nivelVentana])==true){
				setTimeout('finalizar_' + guardaSeccionVentana[nivelVentana] + '();', 10);
			}
		}
		
		nivelVentana--;
		ocultar('ventana' + nivel);
		$('#ventana' + (nivelVentana+1) + '_contenido').html('');
	}
}