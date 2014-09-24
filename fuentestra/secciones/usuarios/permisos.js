var estadoGrupoPermisoMostrar = new Array();

function inicializar_usuarios_permisos(){
	var c = 0;
	var grupos = new Array();
	grupos = explode($('#gruposDePermisos').val(), ',');
	while(grupos[c]){
		estadoGrupoPermisoMostrar[grupos[c]]=0;
		c++;
	}
}

function procesarPermisosUsuario(idUsuarioEditar){
	var estado='';
	if(document.getElementById('estadoActivo').checked==true){
		estado='true';
	}else{
		estado='false';
	}
	var checkPermisos = valoresSeleccionadosCheckbox('checkPermiso');
	var datos = new Array();
	datos['idUsuarioEditar'] = idUsuarioEditar;
	datos['estado'] = estado;
	datos['checkPermisos'] = checkPermisos;
	rpcSeccion('usuarios','modificarPermisos',datos,"fn:alert(hola)");
	cargarSeccion('menu','','','areaMenu');
}

function mostrarOcultarGrupoPermisos(grupo){
	if(estadoGrupoPermisoMostrar[grupo]==0){
		estadoGrupoPermisoMostrar[grupo]=1;
		$('.permisoGrupo_' + grupo).show();
	}else{
		estadoGrupoPermisoMostrar[grupo]=0;
		$('.permisoGrupo_' + grupo).hide();
	}
}

var auxElimPerm='';
function preEliminarPermiso(permiso){
	auxElimPerm=permiso;
	dialogo('Confirmas que deseas quitar este permiso de la lista de permisos y así quitar los permisos a todos los usuarios vinculados a estepermiso','si:eliminarPermiso();|no','eliminar');
}

function eliminarPermiso(){
	var datos = new Array();
	datos['permiso']=auxElimPerm;
	rpcSeccion('usuarios','eliminarPermiso',datos,'fn:posEliminarPermiso();');	
}

function posEliminarPermiso(){
	dialogo('El permiso se ha eliminado');	
}