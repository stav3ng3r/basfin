function inicializar_adjuntar_vista_previa(){
	$('#cropBoxActive').on('click',function(){
		$('#cropbox').Jcrop({
			aspectRatio: 1,
			onSelect: updateCoords
		});
	});
	
	$('#cropBoxSave').on('click',function(){
		guardarCorteImagen();
	});
	
	$('#cropBoxLeftRotate').on('click',function(){
		guardarRotarImagen(1);
	});
	
	$('#cropBoxRightRotate').on('click',function(){
		guardarRotarImagen(2);
	});			
}

function updateCoords(c){
	$('#vistaPrevia_x').val(c.x);
	$('#vistaPrevia_y').val(c.y);
	$('#vistaPrevia_w').val(c.w);
	$('#vistaPrevia_h').val(c.h);
};

function guardarCorteImagen(){
	var datos = new Array();

	datos['x']=$('#vistaPrevia_x').val();
	datos['y']=$('#vistaPrevia_y').val();
	datos['w']=$('#vistaPrevia_w').val();
	datos['h']=$('#vistaPrevia_h').val();
	
	datos['archivo']=$('#vistaPrevia_archivo').val();
	
	rpcSeccion('adjuntar','recortarImagenVistaPrevia',datos,'fn:posGuardarCorteImagen();');
}

function posGuardarCorteImagen(){
	var archivo = $('#vistaPrevia_archivo').val();
	var nombre = $('#vistaPrevia_nombre').val();
	var imagen = archivo.replace(/\//g,'@');
	imagen = imagen.replace('secciones@','');

	$(nombre).children('.traUploadContenido').html('<img class="img-thumbnail" src="index.php?o=ima&archivo='+ imagen +'&tipo=3&ancho=100&alto=100&alinear=o" />');
	
	cerrarVentana();
	cargarSeccion('adjuntar','vista_previa','archivo='+archivo,'ventana');
}

function guardarRotarImagen(lado){
	var datos = new Array();

	datos['archivo']=$('#vistaPrevia_archivo').val();
	datos['lado']=lado;
	
	rpcSeccion('adjuntar','rotarImagenVistaPrevia',datos,'fn:posGuardarRotarImagen();');
}

function posGuardarRotarImagen(){
	var archivo = $('#vistaPrevia_archivo').val();
	var nombre = $('#vistaPrevia_nombre').val();
	var imagen = archivo.replace(/\//g,'@');
	imagen = imagen.replace('secciones@','');

	$(nombre).children('.traUploadContenido').html('<img class="img-thumbnail" src="index.php?o=ima&archivo='+ imagen +'&tipo=3&ancho=100&alto=100&alinear=o" />');
	
	cerrarVentana();
	cargarSeccion('adjuntar','vista_previa','archivo='+archivo,'ventana');
}