function inicializar_archivos_adjuntar(){
	agregarEstiloCss('fuentestra/funciones/js/adjuntar/uploadify.css');
	agregarFuncionJs('fuentestra/funciones/js/adjuntar/jquery.uploadify.js','iniciarElementoAdjuntar();');
	onLoadListadoEdicionCategoriaArchivos();
}

function iniciarElementoAdjuntar(){
	$("#fileUpload").fileUpload({
		'uploader': 'fuentestra/secciones/archivos/uploader.swf',
		'cancelImg': 'fuentestra/secciones/archivos/cancel.png',
		'folder': 'archivos',
		'buttonText': 'Seleccionar',
		'script': 'index.php',
		'multi': true,
		'simUploadLimit': 2,
		'auto' : true,
		'onComplete'  : function(event, ID, fileObj, response, data) {
			var row = procesarCadena(response);
			agregarListadoEdicionCategoriaArchivos(row['nombreArchivo']);
		}
	});
}

function agregarListadoEdicionCategoriaArchivos(referencias){
	var datos = new Array();
	datos['referencias']=referencias;
	rpcSeccion('archivos','mostrarArchivoEnEdicionCategoria',datos,'id.:listadoArchivos');
}

function onLoadListadoEdicionCategoriaArchivos(){
	var datos = new Array();
	datos['referencias']=$('#preCargarArchivos').val();
	if(datos['referencias']!=''){
		rpcSeccion('archivos','preCargarArchivoEnEdicionCategoria',datos,'id.:listadoArchivos');
	}
}

function administrarCategoriasArchivo(){
	cargarSeccion('archivos','categorias','','ventana');	
}

function cargarSelectCategoriasArchivo(){
	rpcSeccion('archivos','cargarSelectCategoriasArchivo','','id:idArchivoCategoria');	
}

function quitarDeListaArchivos(idArchivo){
	dialogo('Seguro que desea quitar de la lista al archivo seleccionado?','si:quitarDeListaArchivosSi(' + idArchivo + ');|no','eliminar');
}
function quitarDeListaArchivosSi(idArchivo){
	var d = document.getElementById('listadoArchivos');
	var olddiv = document.getElementById('recuadroArchivo' + idArchivo);
	d.removeChild(olddiv);
}

function procesarFormArchivo(){
	var elementos = document.getElementsByName('idArchivo');
	var idArchivos='';
	for (x=0;x<elementos.length;x++){
		if(x>0){idArchivos+=',';}
		idArchivos+=elementos[x].value;
	}
	if(idArchivos==''){
		dialogo('Debes adjuntar al menos un archivo');
	}else{
		var datos = new Array();
		datos['idArchivos']=idArchivos;
		datos['idArchivoCategoria']=$('#idArchivoCategoria').val();
		datos['aplicarCategoria']=document.getElementById('aplicarCategoria').checked;
		datos['nombre']=$('#nombre').val();
		datos['aplicarNombre']=document.getElementById('aplicarNombre').checked;
		datos['descripcion']=$('#descripcion').val();
		datos['aplicarDescripcion']=document.getElementById('aplicarDescripcion').checked;
		datos['fecha']=$('#fecha').val();
		datos['aplicarFecha']=document.getElementById('aplicarFecha').checked;
		datos['palabrasClaves']=$('#palabrasClaves').val();
		datos['aplicarPalabrasClaves']=document.getElementById('aplicarPalabrasClaves').checked;
		datos['firma']=document.getElementById('firma').checked;
		datos['aplicarFirma']=document.getElementById('aplicarFirma').checked;
		rpcSeccion('archivos','editarCategorizacionArchivo',datos,'fn:posProcesarFormArchivo();');
	}
}

function posProcesarFormArchivo(){
	var origenLlamada = $('#origenLlamada_archivos_adjuntar').val();
	if(origenLlamada=='listadoGral'){
		listadoGralArchivos();
	}else if(origenLlamada!=''){
		cargarListadoRelArchivos_desdeAdjuntarArchivo();
	}
	cerrarVentana(nivelVentana);
}

function cargarListadoRelArchivos_desdeAdjuntarArchivo(){
	var elementos = document.getElementsByName('idArchivo');
	var idArchivos='';
	for (x=0;x<elementos.length;x++){
		if(x>0){idArchivos+=',';}
		idArchivos+=elementos[x].value;
	}
	var datos = new Array();
	datos['idsArchivos']=idArchivos;
	datos['cListaRelArchivos']=cListaRelArchivos;
	rpcSeccion('archivos','agregarListadoRelArchivos',datos,'fn:cargarListadoRelArchivos()');
}
