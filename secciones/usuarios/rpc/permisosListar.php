<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='';
$c++;	$matriz[0][$c]['html']='usuario*';		$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='nombre*';		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='e-mail*';		$matriz[0][$c]['width']=250;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='creado';		$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='ultima acción';	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
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
		to_char(fecha_usuario_creo, 'DD/MM/YYYY HH24:MI') as fecha_usuario_creo,
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
	$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'usuarios\',\'usuario_ae\',\'idUsuario='.$row['id_usuario'].'\',\'ventana\');" title="editar"><img src="fuentestra/imagenes/bot/16x16/edit.png" /></a></div>';
	$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarUsuario('.$row['id_usuario'].');|no\',\'eliminar\');" title="eliminar"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a></div>';
	$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'usuarios\',\'permisos\',\'idUsuarioEditar='.$row['id_usuario'].'\',\'ventana\');" title="asignar permiso"><img src="fuentestra/imagenes/bot/16x16/key.png" /></a></div>';
	$matriz[$c][]['html']=$row['usuario'];
	$matriz[$c][]['html']=$row['nombre'];
	$matriz[$c][]['html']=$row['correo'];
	$matriz[$c][]['html']=empty($row['fecha_usuario_creo']) ? '' : $row['fecha_usuario_creo'];
	$matriz[$c][]['html']=empty($row['fecha_ultima_accion']) ? '' : $row['fecha_ultima_accion'];
	$matriz[$c][]['html']=$row['estado_login']=='t' ? '<img title="en linea" src="fuentestra/imagenes/bot/16x16/green_button.png" />' : '<img title="desconectado" src="fuentestra/imagenes/bot/16x16/red_button.png" />';
	$matriz[$c][]['html']=$row['estado']=='t' ? '' : '<img title="inactivo" src="fuentestra/imagenes/bot/16x16/block.png" />';
	$matriz[$c][]['html']=infoAuditoria('public.usuarios',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>