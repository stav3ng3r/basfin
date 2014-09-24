<?
$idUsuarioEditar=recibir_dato('idUsuarioEditar');

$sql="select usuario, estado from usuarios where id_usuario=$idUsuarioEditar";
$db->set_query($sql);
$db->execute_query();
$rowUsuario=$db->get_array();

$gruposDePermisos='';
$htmlPermisos='';
$sql="
	select
		p.permiso,
		p.detalle,
		up.permiso as permiso_usuario
	from
		permisos p
		left join usuario_permisos up on (up.permiso=p.permiso and up.id_usuario=$idUsuarioEditar)
	order by
		p.detalle asc

";
$db->set_query($sql);
$db->execute_query();
$gCab='';
if($tra['id_usuario']==1){
	$auxCols=4;
}else{
	$auxCols=2;	
}
while($row=$db->get_array()){
	list($cab,$det)=explode(' - ',$row['detalle']);
	if($gCab!=$cab){
		$gCab=$cab;
		$htmlPermisos.='
		<tr>
			<td colspan="'.$auxCols.'" bgcolor="#EAEAEA" style="color:#333; font-weight:bold;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="16"><div style="width:16px; height:16px;"><a href="javascript:mostrarOcultarGrupoPermisos(\''.str_replace(' ','',$cab).'\');"><img src="fuentestra/imagenes/bot/16x16/zoom_in.png" /></a></div></td>
						<td width="5">&nbsp;</td>
						<td width="*">'.$cab.'</td>
					</tr>
				</table>
			</td>
		</tr>
		';
		if($gruposDePermisos!=''){
			$gruposDePermisos.=',';
		}
		$gruposDePermisos.=str_replace(' ','',$cab);
	}
	
	if($row['permiso_usuario']!=''){
		$auxchecked='checked';		
	}else{
		$auxchecked='';	
	}
	
	if($tra['id_usuario']==1){
		$auxElimPerm='
			<td width="5">&nbsp;</td>
			<td width="16"><div style="width:16px; height:16px;"><a href="javascript:preEliminarPermiso(\''.$row['permiso'].'\');"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a></div></td>		
		';
	}else{
		$auxElimPerm='';
	}
	
	$htmlPermisos.='
	<tr class="permisoGrupo_'.str_replace(' ','',$cab).'" style="display:none;">
		<td align="right"><input type="checkbox" name="checkPermiso" value="'.$row['permiso'].'" '.$auxchecked.'></td>
		<td title="'.$row['permiso'].'">'.$det.' - '.$row['permiso'].'</td>
		'.$auxElimPerm.'
	</tr>
	';
}

$resp['html']=str_replace('{idUsuarioEditar}',$idUsuarioEditar,$resp['html']);
$resp['html']=str_replace('{usuario}',$rowUsuario['usuario'],$resp['html']);
$resp['html']=str_replace('{permisos}',$htmlPermisos,$resp['html']);
$resp['html']=str_replace('{gruposDePermisos}',$gruposDePermisos,$resp['html']);

if($rowUsuario['estado']=='t'){
	$resp['html']=str_replace('id="estadoActivo"','id="estadoActivo" checked ',$resp['html']);
}else{
	$resp['html']=str_replace('id="estadoInactivo"','id="estadoInactivo" checked ',$resp['html']);	
}
?>