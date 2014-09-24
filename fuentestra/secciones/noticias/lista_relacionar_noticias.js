function inicializar_noticias_lista_relacionar_noticias(){
	listaNoticiasParaRelacionar();
}

function listaNoticiasParaRelacionar(){
	var datos = new Array();
	datos['idNoticia']=$('#idNoticiaPadre').val();
	datos['idsNoticiasRelacionadas']=$('#onLoadPreSeleccionarNoticias').val();
	rpcSeccion('noticias','listarNoticiasParaRelacionar',datos,'id:listaNoticiasParaRelacionar');
}

function aceptarSeleccionNoticiaRelacionadas(){
	var elementos = document.getElementsByName('idNoticiaParaRelacionar');
	var idsNoticias='';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked==true){
			if(idsNoticias!=''){idsNoticias+=',';}
			idsNoticias+=elementos[x].value;	
		}
	}
	cargarRelNoticiaNoticias(idsNoticias);
	cerrarVentana();
}