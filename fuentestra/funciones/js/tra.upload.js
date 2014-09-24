(function($){
	$.fn.traUpload = function(options, callback){
		var obj=this, v=false, archivo, input, attachment, name='archivo';
		
		var defaults = {
			seccion: '',
			rpc : '',
			name : '',
			formatos : '',
			adjuntos : [],
			multiple : false,
			previa : {},
			resultado : '',
			cargando : 'Cargando...',
			class : '',
			'img-class' : ''
		};
		
		var opcs = $.extend(defaults, options);
		var url = 'secciones/'+ opcs.seccion +'/rpc/'+ opcs.rpc +'.php';
						
		if(!$(obj).find('ul').length) {
			$(obj).addClass(opcs.class);
			var ul = $('<ul />').appendTo($(obj)).addClass('traUploadAdjuntos');
			var li_adj = $('<li />').appendTo(ul).addClass('traUploadAdjuntar');
			
			attachment = li_adj.html();		
			
			function traUploadEliminar() {
				$(this).parents('li').remove();

				if(opcs.multiple == false){
					$(li_adj).html(attachment).show();
				}
			}

			$(obj).off('click', '.traUploadEliminar', traUploadEliminar);
			$(obj).on('click', '.traUploadEliminar', traUploadEliminar);
	
			$('.traUploadAdjuntos').sortable({
				items: "li:not(.traUploadAdjuntar)"
			}).disableSelection();
			
			var html = !opcs.previa.html ? '' : opcs.previa.html;

			$(li_adj).css('cursor','pointer').html(html).addClass(opcs.previa.class);
			
			(opcs.previa.ancho) ? $(li_adj).css('width',opcs.previa.ancho) : null;
			(opcs.previa.alto) ? $(li_adj).css('height',opcs.previa.alto) : null;
			
			$(li_adj).on('click', function(){
	
				archivo = url;
	
				input = $('<input />', {
					type: 'file',
					name: name + '[]',
					multiple : opcs.multiple
				}).hide().appendTo('body');
				
				if(v==false){input.click()};
				
				attachment = $(li_adj).html();
				
				input.change(function(){
					var adjunto = $(this).val();				
					
					var extension = adjunto.substr((adjunto.lastIndexOf('.')+1)).toLowerCase();
					if(extension && eval('/^('+ opcs.formatos +')$/i').test(extension)){
	
						if(adjunto!=''){
							v = true;
							$(li_adj).html(opcs.cargando);
							
							$(li_adj).parents('form').find('button').prop('disabled', true);
						}
						
						$(this).upload(archivo, function(data){	
							var object = $.parseJSON(data);
							$.fn.mostrarAdjuntos(object, ul, opcs.name, opcs['img-class']);

							v = false;
							$(li_adj).html(attachment);
							
							if(opcs.multiple==false){
								$(li_adj).hide();	
							}
							
							$(li_adj).parents('form').find('button').prop('disabled', false);					
							
							setTimeout(function(){
								if(callback){
									callback.call(li_adj, data);							
								}
							}, 0);
						});			
	
					}else{
						$(li_adj).show();
						dialogo('El tipo de archivo no es valido');
					}
					
					input.remove();	
				});
			});
		}
		
		attachment = li_adj.html();
		
		if (opcs.adjuntos != '') {
			if(opcs.multiple == false){
				if(ul.children('li:not(.traUploadAdjuntar)').length > 0) {
					ul.children('li:not(.traUploadAdjuntar)').remove();
				}
			}
			
			$(li_adj).html(opcs.cargando);	
			
			$.fn.mostrarAdjuntos(opcs.adjuntos, ul, opcs.name, opcs['img-class']);

			$(li_adj).html(attachment);
						
			if(opcs.multiple == false){
				$(li_adj).hide();
			}
			
			setTimeout(function(){
				if(callback){
					callback.call(li_adj, opcs.adjuntos);							
				}
			}, 0);
		}
	}
	
	$.fn.traAdjuntos = function(){
		var valores = '';
		var c = 0;
		$(this).each(function(){
			c++;
			if(c>1){
				valores += '|';
			}				
			valores += $(this).val();
		});
		
		return valores;
	}
	
	$.fn.mostrarAdjuntos = function(object, ul, name, imgclass) {
		object.reverse();
		
		$(object).each(function(index, element) {
			var adj_archivo = object[index].nombre_temp;
			var extension = adj_archivo.substr((adj_archivo.lastIndexOf('.')+1)).toLowerCase();
			adj_archivo = adj_archivo.substr(0, adj_archivo.lastIndexOf('.')).replace('.','_') + '.' + extension;
			adj_archivo = adj_archivo.replace(' ','-');
			
			var adj_li = $('<li />', {id: adj_archivo})
			.addClass('traUploadImg');
			
			var adj_div = $('<div />').addClass('traUploadContenido').appendTo(adj_li);
			$('<div />').addClass('traUploadBorde').appendTo(adj_div);
			
			var adj_a = $('<a />').appendTo(adj_div);
			
			addAncho = object[index].ancho ? '&ancho='+ object[index].ancho : null;
			addAlto = object[index].ancho ? '&alto='+ object[index].alto : null;
			
			(object[index].ancho) ? adj_li.css('width',object[index].ancho) : null;
			(object[index].alto) ? adj_li.css('height',object[index].alto) : null;
			
			var adj_img = $('<img />', {
				src : 'index.php?o=ima&archivo=archivos/'+ object[index].ubicacion +'&tipo=3'+ addAncho + addAlto + '&alinear=o',
				class : imgclass
			}).appendTo(adj_a);
			
			var adj_nombre = (object[index].estado == true) ? adj_archivo : 'tmp/'+ adj_archivo;
			var nombre_original = (object[index].nombre_original.length > 18) ? object[index].nombre_original.substr(0,16) + '...' : object[index].nombre_original;
			var proporcion = (object[index].proporcion) ? '(' + object[index].proporcion[0] + 'x' + object[index].proporcion[1] + ')' : '';
			
			var adj_info = $('<div />').html(
				nombre_original
				+ '<br>'
				+ Math.round((object[index].peso / 1024)) + ' KB '
				+ proporcion		
				+ '<br><br>'
				+ '<a href="archivos/'+ object[index].ubicacion +'" target="_blank" class="btn btn-info"><i class="glyphicon glyphicon-cloud-download"></i></a> '
				+ '<a href="javascript:cargarSeccion(\'adjuntar\',\'vista_previa\',\'archivo='+ object[index].ubicacion +'\',\'ventana\');" class="btn btn-info"><i class="glyphicon glyphicon-fullscreen"></i></a> '
				+ '<a href="javascript:void(0);" class="btn btn-info traUploadEliminar"><i class="glyphicon glyphicon-remove"></i></a>'
			).addClass('traUploadInfo').appendTo(adj_a);
			
			var adj_input = $('<input />', {
				type : 'hidden',
				value : adj_nombre,
				name : name + '[]'
			}).addClass(name);
			
			$(adj_div).append(adj_input);			
			
			console.log('index.php?o=ima&archivo=archivos/'+ object[index].ubicacion +'&tipo=3'+ addAncho + addAlto + '&alinear=o');	
			
			$(ul).prepend(adj_li);
		});		
	}
})(jQuery);