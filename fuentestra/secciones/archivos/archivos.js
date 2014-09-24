function inicializar_archivos(){
	listadoGralArchivos();
}

function listadoGralArchivos(){
	ocultar('cargarMasArchivosListadoGral');
	mostrar('cargandoMasArchivosListadoGral');
	var datos = new Array();
	datos['archivosPreSeleccionados']=obtenerIdsArchivosDeListadoRelArchivos();	
	datos['cadenaBuscar']=$('#cadenaBuscarArchivo').val();
	rpcSeccion('archivos','listadoGralArchivos',datos,'fn:mostrarListadoGralArchivos();');
	rpcSeccion('archivos','calcularEspacioUtilizado','','id:espacioUtilizado');
}

function mostrarListadoGralArchivos(){
	var row=rowRPC;
	if(row['masArchivos']=='SI'){
		mostrar('cargarMasArchivosListadoGral');
	}
	ocultar('cargandoMasArchivosListadoGral');
	$('#listadoGral').html(row['html']);
	$('#cantRegLista').val(row['cantRegLista']);
}

function agregarAlListadoGralArchivos(){
	ocultar('cargarMasArchivosListadoGral');
	mostrar('cargandoMasArchivosListadoGral');
	var datos = new Array();
	datos['archivosPreSeleccionados']=obtenerIdsArchivosDeListadoRelArchivos();
	datos['cantRegLista']=$('#cantRegLista').val();
	datos['cadenaBuscar']=$('#cadenaBuscarArchivo').val();
	rpcSeccion('archivos','listadoGralArchivos',datos,'fn:posAgregarAlListadoGralArchivos();');
}

function posAgregarAlListadoGralArchivos(){
	var row = rowRPC;
	$('#listadoGral table').html($('#listadoGral table').html() + row['html']);	
	$('#cantRegLista').val(row['cantRegLista']);
	ocultar('cargandoMasArchivosListadoGral');
	if(row['masArchivos']=='SI'){
		mostrar('cargarMasArchivosListadoGral');
	}
}

function irEditarArchivo(){
	var elementos = document.getElementsByName('idArchivoListaGral');
	var idArchivoListaGral='';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked==true){
			if(idArchivoListaGral!=''){idArchivoListaGral+=',';}
			idArchivoListaGral+=elementos[x].value;
		}
	}
	cargarSeccion('archivos','adjuntar','origenLlamada=listadoGral&idsArchivos=' + idArchivoListaGral,'ventana');
}

function irEliminarArchivo(){
	var elementos = document.getElementsByName('idArchivoListaGral');
	var idArchivoListaGral='';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked==true){
			if(idArchivoListaGral!=''){idArchivoListaGral+=',';}
			idArchivoListaGral+=elementos[x].value;
		}
	}
	if(idArchivoListaGral==''){
		dialogo('Debe seleccionar al menos un archivo');
	}else{
		var datos = new Array();
		datos['idsArchivos']=idArchivoListaGral;
		rpcSeccion('archivos','eliminarArchivos',datos,'fn:posEliminarArchivo();');
	}
}

function posEliminarArchivo(){
	var row = rowRPC;
	listadoGralArchivos();
	dialogo('Se han eliminado ' + row['cantEliminados'] + ' archivos','aceptar','ok');
}

function irAceptarSeleccion(){
	var elementos = document.getElementsByName('idArchivoListaGral');
	var idArchivoListaGral='';
	for (x=0;x<elementos.length;x++){
		if(elementos[x].checked==true){
			if(idArchivoListaGral!=''){idArchivoListaGral+=',';}
			idArchivoListaGral+=elementos[x].value;
		}
	}
	var datos = new Array();
	datos['idsArchivos']=idArchivoListaGral;
	datos['cListaRelArchivos']=cListaRelArchivos;
	rpcSeccion('archivos','agregarListadoRelArchivos',datos,'fn:cargarListadoRelArchivos()');
	cerrarVentana(nivelVentana);
}