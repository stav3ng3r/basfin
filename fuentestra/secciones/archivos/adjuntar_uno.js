function inicializar_archivos_adjuntar(){
	onLoadListadoEdicionCategoriaArchivos();
	//agregarFuncionJs('fuentestra/funciones/js/AjaxUpload.2.0.min.js','iniciarMotorUpload();');
}

function iniciarMotorUploadAnt(){
	alert('1');
	var button = $('#upload_button'), interval;
	new AjaxUpload('#upload_button', {
		action: 'upload_file.php',
		onSubmit : function(file , ext){
			alert('2');
			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				// extensiones permitidas
				alert('Error: Solo se permiten imagenes');
				// cancela upload
				return false;
			} else {
				button.text('Adjuntando imágen...');
				this.disable();
			}
		},
		onComplete: function(file, response){
			alert('3');
			button.text('Adjuntar una imágen');
			if(response=='error'){
				alert('error al insertar la imagen, favor intente mas tarde');
			}else{
				nombreImgBanner = response;
			}
			// enable upload button
			this.enable();			
			// Agrega archivo a la lista
			alert('se subio ' + file);
		}
	});
	alert('4');
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
