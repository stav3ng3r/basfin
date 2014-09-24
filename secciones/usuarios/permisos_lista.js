var permiso;

function inicializar_usuarios_permisos_lista() {
	checkTodos();
	seleccionarRol();
}

function procesarPermisosUsuario() {
	var datos = new Array();
	var check = new Array();

	$('[name=checkPermiso]:checked').each(function(index, element) {
		check.push($(this).val());
    });
	
	datos['permisos'] = check.join(',');
	datos['idUsuario'] = $('#usuaPermisos_idUsuario').val();
	datos['estado'] = $('[name=estadoUsuario]').prop('checked');
	datos['idSistema'] = $('#usuaPermisos_administracion').val();
	
	rpcSeccion('usuarios','permisosAgregarEditar',datos,'fn:posProcesarPermisosUsuario();');
}

function posProcesarPermisosUsuario() {
	dialogo('Los cambios se realizarón con exito!');
}

function preEliminarPermiso(perm){
	permiso = perm;
	dialogo('Confirma que desea eliminar este registro','si:eliminarPermiso();|no','eliminar');
}

function eliminarPermiso(){
	var datos = new Array();
	datos['permiso'] = permiso;
	rpcSeccion('usuarios','permisosEliminar',datos,'fn:posProcesarPermisosUsuario();');
}

function mostrarOcultarCategoriaPermisos(categoria) {
	$('.categoriaPermiso_' + categoria).toggle();
}

function checkTodos() {
	$('.categoriaPermiso_checkTodos').click(function(e) {
        var checked = $(this).prop('checked');
		var checkbox = $('.categoriaPermiso_' + $(this).val()).find('input:checkbox');
		
		if (checked === true) {
			$(checkbox).each(function(index, element) {
				checkbox.prop('checked', true);
			});
		} else {		
			$(checkbox).each(function(index, element) {
				checkbox.prop('checked', false);
			});			
		}
	});
}

function seleccionarRol() {
	$('#usuaPermisos_rolesPermisos').change(function(e) {
		var checkbox = $('[class^=categoriaPermiso_').find('input:checkbox');
		var permisos = $(this).val();
		
		permisos = permisos.split(',');
		
		checkbox.prop('checked', false);
		
		if (permisos != 'null') {
			$(checkbox).each(function(index, element) {
				var check = $(this);
				
				if ($.inArray($(this).val(), permisos) >= 0) {
					check.prop('checked', true);
				}
			});
		}
    });
}

function cambiarAdministracionPermiso(idUsuarioEditar){
	var idSistema = $('#usuaPermisos_administracion').val();
	cerrarVentana();
	cargarSeccion('usuarios','permisos_lista','idUsuarioEditar='+ idUsuarioEditar +'&idSistema='+ idSistema,'ventana');
}