<?php
$idUsuario = recibir_dato('idUsuarioEditar');
$idSistema=recibir_dato('idSistema');

$sql="
	select
		usuario,
		estado
	from
		usuarios
	where
		id_usuario=$idUsuario
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();

$estadoActivo = '';
$estadoInactivo = '';

$usuario = $row['usuario'];
if ($row['estado']=='t') {
	$estadoActivo = 'checked';
} else {
	$estadoInactivo = 'checked';
}

$gruposDePermisos='';
$htmlPermisos='';

$colspan = $tra['id_usuario']==1 ? 4 : 2;

$sql="
	select
		trim(split_part(detalle, '-', 1)) as categoria
	from
		permisos
	where
		permiso != ''
	group by
		trim(split_part(detalle, '-', 1))
	order by
		trim(split_part(detalle, '-', 1)) asc
";
$db->set_query($sql);
$db->execute_query();
while ($row=$db->get_array()) {
	$sql2="
		select	
			p.permiso,
			trim(split_part(detalle, '-', 1)) as categoria,
			trim(split_part(detalle, '-', 2)) as titulo,
			case when up.id_usuario is null then ''::varchar else 'checked'::varchar end as checked
		from
			permisos p
			left join usuario_permisos up on (up.permiso=p.permiso and up.id_usuario=$idUsuario and up.id_sistema=$idSistema)	
		where
			trim(split_part(detalle, '-', 1)) = '{$row['categoria']}'
	";
	$db2->set_query($sql2);
	$db2->execute_query();
	
	$htmlPermisos.='
		<tr>
			<td colspan="'.$colspan.'" bgcolor="#EAEAEA" style="color:#333; font-weight:bold;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="16"><div style="width:16px; height:16px;"><a href="javascript:mostrarOcultarCategoriaPermisos(\''.md5($row['categoria']).'\');"><img src="fuentestra/imagenes/bot/16x16/zoom_in.png" /></a></div></td>
						<td width="5"><input type="checkbox" class="categoriaPermiso_checkTodos" value="'.md5($row['categoria']).'"></td>
						<td width="*">'.$row['categoria'].'</td>
					</tr>
				</table>
			</td>
		</tr>
	';
	
	while ($row2=$db2->get_array()) {
		$htmlPermisos.='
			<tr class="categoriaPermiso_'.md5($row['categoria']).'" style="display:none;">
				<td align="right"><input type="checkbox" name="checkPermiso" value="'.$row2['permiso'].'" '.$row2['checked'].'></td>
				<td title="'.$row2['permiso'].'">'.$row2['titulo'].' - '.$row2['permiso'].'</td>';
				
				if ($tra['id_usuario']==1) {
					$htmlPermisos.='
						<td width="5">&nbsp;</td>
						<td width="16"><div style="width:16px; height:16px;"><a href="javascript:preEliminarPermiso(\''.$row2['permiso'].'\');"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a></div></td>
					';
				}
		$htmlPermisos.='</tr>';
	}
}

$sql="
	select
		*,
		array_to_string(
			array(
				select
					permiso
				from
					roles_permisos
				where
					id_roles=r.id_roles
			)
		,',') as permisos
	from
		roles r
";
$option = '<option value="null" disabled>Seleccionar un Rol</option>';
$db->set_query($sql);
$db->execute_query();
while ($row = $db->get_array()) {
	$perm = empty($row['permisos']) ? 'null' : $row['permisos'];
	$option .= '<option value="'. $perm .'">'. $row['rol'] .'</option>';
}

$sql="
	select
		*
	from
		public.sistemas s
		join public.usuarios_sistemas us using (id_sistema)
	where
		id_usuario=$idUsuario
";
$db->set_query($sql);
$db->execute_query();
$administracion='';
while($row=$db->get_array()){
	$selected=($idSistema==$row['id_sistema']) ? 'selected' : NULL;
	$administracion.='<option value="'. $row['id_sistema'] .'" '. $selected .'>'. $row['titulo'] .'</option>';
}
?>