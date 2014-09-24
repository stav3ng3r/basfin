<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='';
$c++;	$matriz[0][$c]['html']='Usuario*';		$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Nombre*';		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='e-mail*';		$matriz[0][$c]['width']=250;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Ultima Acción';	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.cajas',null,'delete');;		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(usuario) ilike sp_ascii('%{text}%') or 
	sp_ascii(nombre) ilike sp_ascii('%{text}%') or 
	sp_ascii(correo) ilike sp_ascii('%{text}%')	
");

$sql="
	select
		*,
		to_char(fecha_ultima_accion, 'DD/MM/YYYY HH24:MI') as fecha_ultima_accion
	from
		usuarios u
	where
		1=1
		$whereFiltro
	order by
		u.usuario
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_usuario'],$row['usuario']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'usuarios\',\'usuario_ae\',\'idUsuario='.$row['id_usuario'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarUsuario('.$row['id_usuario'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'usuarios\',\'permisos_lista\',\'idUsuarioEditar='.$row['id_usuario'].'\',\'ventana\');" title="permisos"><i class="glyphicon glyphicon-lock"></i></a>';
	$matriz[$c][]['html']=$row['usuario'];
	$matriz[$c][]['html']=$row['nombre'];
	$matriz[$c][]['html']=$row['correo'];
	$matriz[$c][]['html']=empty($row['fecha_ultima_accion']) ? '' : $row['fecha_ultima_accion'];
	$matriz[$c][]['html']=$row['estado_login']=='t' ? '<i title="Conectado" class="glyphicon glyphicon-user" style="color:green;"></i>' : '<i title="Desconectado" class="glyphicon glyphicon-user" style="color:grey;"></i>';
	$matriz[$c][]['html']=$row['estado']=='t' ? '<i title="Activo" class="glyphicon glyphicon-ok-circle" style="color:green;"></i>' : '<i title="Inactivo" class="glyphicon glyphicon-ban-circle" style="color:red;"></i>';
	$matriz[$c][]['html']=infoAuditoria('public.usuarios',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>