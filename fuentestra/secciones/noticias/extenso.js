function inicializar_noticias_extenso(){
	iniciarSliderImagenesNoticiaCarousel();
	cargarSeccion('comentarios','','','sectorComentarios');
}

function iniciarSliderImagenesNoticiaCarousel(){
	cantArchivosMultimedia=$('#cantArchivosMultimedia').val();
	if(cantArchivosMultimedia>1){
		$(function() {
			mostrar('sliderImagenesNoticia');
			$('.botNavDer').show();
			$('.botNavIzq').show();
			$(".sliderImagenesNoticiaCarousel").jCarouselLite({
				btnNext: ".botNavDer",
				btnPrev: ".botNavIzq",
				vertical: false,
				hoverPause:true,
				visible:1,
				auto:3000,
				speed:1000
			});		
		});
	}else if(cantArchivosMultimedia==1){
		$(function() {
			mostrar('sliderImagenesNoticia');
			$('.botNavDer').hide();
			$('.botNavIzq').hide();
			$(".sliderImagenesNoticiaCarousel").jCarouselLite({
				btnNext: ".botNavDer",
				btnPrev: ".botNavIzq",
				vertical: false,
				hoverPause:true,
				visible:1,
				auto:0,
				speed:1000
			});		
		});	
	}else{
		ocultar('sliderImagenesNoticia');
		$('.botNavDer').hide();
		$('.botNavIzq').hide();
	}
}

function irEliminarNoticia(idNoticia){
	dialogo('Esta seguro que desea aliminar la noticia?','si:eliminarNoticia(' + idNoticia + ');|no','eliminar');
}

function eliminarNoticia(idNoticia){
	var datos = new Array();
	datos['idNoticia'] = idNoticia;
	rpcSeccion('noticias','eliminarNoticia',datos,"fn:posEliminarNoticia();");
}

function posEliminarNoticia(){
	cerrarVentana();
	cargarSeccion('noticias');
}