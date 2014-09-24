/**
*   jQuery Input Dinámico 2.0 - 06/06/2014
*   Copyright (C) 2012 - 2014  Silvio Valentín Báez
*
*   Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
*   bajo los términos de la Licencia Pública General GNU publicada 
*   por la Fundación para el Software Libre, ya sea la versión 3 
*   de la Licencia, o (a su elección) cualquier versión posterior.
*
*   Este programa se distribuye con la esperanza de que sea útil, pero 
*   SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita 
*   MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO. 
*   Consulte los detalles de la Licencia Pública General GNU para obtener 
*   una información más detallada. 
*
*   Debería haber recibido una copia de la Licencia Pública General GNU 
*   junto a este programa. 
*   En caso contrario, consulte <http://www.gnu.org/licenses/>.
*
*	Contactos:	silvioqql@hotmail.com	
*	Descargar:	http://www.webbae.net/proyectos/jquery-input-dinamico.rar
*			http://sourceforge.net/p/jqueryinputdinm
*
*	Versión Anterior: jQuery Input Dinámico 1.0 - 22/07/2012
*/

(function($){
	$.fn.inputDinamico = function(options, callback){
		var self = this, opcs, i, j, a, div, ac;
		var table, thead, tbody, tr, td;

		opcs = $.extend({
			fields	: {},
			values	: [],
			limit	: 5,
			element	: '',
			class	: '',
			deleteElement : 'x',
			addElement  : '+',
			sortable : false
		}, options);
		
		i = j = $('[data-inputdinamico-item]').length;
		
		table = $('<table />', {class : opcs.class}).appendTo(opcs.element);
		$(table).append(tr);
		
		thead = $('<thead />').appendTo(table);
		tr = $('<tr />').appendTo(thead);
		
		td = $('<td />').appendTo(tr);
		$('<span />').text('').appendTo(td);		
		
		for (var field in opcs.fields) {
			td = $('<td />').appendTo(tr);
			$('<label />').text(opcs.fields[field][0]).appendTo(td);
		}
		
		td = $('<td />').appendTo(tr);
		$('<span />').text('').appendTo(td);		
		
		tbody = $('<tbody />').appendTo(table);

		if (opcs.values.length > 0) {
			for (var value in opcs.values) {
				i++, j++;
				
				tr = $('<tr />').attr('data-inputdinamico-item', i).appendTo(tbody);
				td = $('<td />').appendTo(tr);
								
				a = $('<a />', {
					href : 'javascript:void(0);'
				}).appendTo(td);
				
				a.html(opcs.addElement).attr('data-inputdinamico-eliminar', i).html(opcs.deleteElement);

				for (var field in opcs.fields) {
					td = $('<td />').addClass('form-group').appendTo(tr);
					div = $('<div />').appendTo(td);
					
					var val = opcs.values[value][field];
					
					if($.isArray(val)){
						ac = val[0];
						val = val[1];
					}
					
					$('<input />', {
						name : field + '[]',
						type : opcs.fields[field][1],
						id : field + '_' + j,
						value : val
					}).addClass(opcs.fields[field][2]).appendTo(div);
				}
				
				td = $('<td />').appendTo(tr);
								
				a = $('<a />', {
					href : 'javascript:void(0);'
				}).appendTo(td);
				
				$(opcs.element).find('[data-inputdinamico-agregar]').hide();
				a.attr('data-inputdinamico-agregar', i).html(opcs.addElement);
			
				$(table).append(tr);
				
				if(callback){
					var cb = callback.call(self, j, ac);
				}			
				setTimeout(function(){cb;}, 0);
				
				count();
			}			
		} else {
			i++, j++;
			
			tr = $('<tr />').attr('data-inputdinamico-item', i).appendTo(tbody);
			td = $('<td />').appendTo(tr);
							
			a = $('<a />', {
				href : 'javascript:void(0);'
			}).appendTo(td);
			
			a.html(opcs.addElement).attr('data-inputdinamico-eliminar', i).html(opcs.deleteElement);
			
			for (var field in opcs.fields) {
				td = $('<td />').addClass('form-group').appendTo(tr);
				div = $('<div />').appendTo(td);
				
				$('<input />', {
					name : field + '[]',
					type : opcs.fields[field][1],
					id : field + '_' + j
				}).addClass(opcs.fields[field][2]).appendTo(div);
			}
			
			td = $('<td />').appendTo(tr);
			
			a = $('<a />', {
				href : 'javascript:void(0);'
			}).appendTo(td);
			
			$(opcs.element).find('[data-inputdinamico-agregar]').hide();
			a.attr('data-inputdinamico-agregar', i).html(opcs.addElement);		
	
			$(table).append(tr);
			
			setTimeout(function(){
				if(callback){
					callback.call(self, j);
				}
			}, 0);
			
			count();
		}
		
		$(opcs.element).on('click', '[data-inputdinamico-agregar]', function(){
			if (i < opcs.limit || opcs.limit == 0) {
				i++, j++;
					
				tr = $('<tr />').attr('data-inputdinamico-item', i).appendTo(tbody);
				td = $('<td />').appendTo(tr);
				
				a = $('<a />', {
					href : 'javascript:void(0);'
				}).html(opcs.deleteElement).appendTo(td)
				.attr('data-inputdinamico-eliminar', i);
				
				a.html(opcs.addElement).attr('data-inputdinamico-eliminar', i).html(opcs.deleteElement);							
				
				for (var field in opcs.fields) {
					td = $('<td />').addClass('form-group').appendTo(tr);
					div = $('<div />').appendTo(td);
					
					$('<input />', {
						name : field + '[]',
						type : opcs.fields[field][1],
						id : field + '_' + j
					}).addClass(opcs.fields[field][2]).appendTo(div);
				}
				
				
				
				td = $('<td />').appendTo(tr);
				
				a = $('<a />', {
					href : 'javascript:void(0);'
				}).html(opcs.deleteElement).appendTo(td);
				
				$(opcs.element).find('[data-inputdinamico-agregar]').hide();
				a.attr('data-inputdinamico-agregar', i).html(opcs.addElement);			
				
				$(table).append(tr);
				
				setTimeout(function(){
					if(callback){
						callback.call(self, j);
					}
				}, 0);
				
				count();
				
				tr.find('input:first').focus();
			}
		});
		
		$(opcs.element).on('click', '[data-inputdinamico-eliminar]', function(){
			var tr = $(this).parents('[data-inputdinamico-item]');
			tr.prev('tr').find('input:first').focus();
			tr.remove();
			i--;
			
			$(opcs.element).find('[data-inputdinamico-agregar]').hide();
			$(opcs.element).find('[data-inputdinamico-agregar]:last').show();
			
			count();		
		});
		
		if (opcs.sortable && $.ui) {
			$(opcs.element).sortable({
				update : function() {
					$(opcs.element).find('[data-inputdinamico-agregar]').hide();
					$(opcs.element).find('[data-inputdinamico-agregar]:last').show();				
				},
				items: 'tbody tr'
			});			
		}
		
		
		function count() {
			if (i == 1) {
				$(opcs.element).find('[data-inputdinamico-eliminar]').css('visibility', 'hidden');
			} else {
				$(opcs.element).find('[data-inputdinamico-eliminar]').css('visibility', 'visible');
			}
			
			if (i == opcs.limit) {
				$(opcs.element).find('[data-inputdinamico-agregar]').css('visibility', 'hidden');
			} else {
				$(opcs.element).find('[data-inputdinamico-agregar]').css('visibility', 'visible');
			}			
		}	
	}
})(jQuery);