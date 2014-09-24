<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistUsuariosProyectos';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistUsuariosProyectos';
$c++;	$matriz[0][$c]['html']='Usuario*';	 	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Proyecto*';		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Activo';		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.usuarios_proyectos',null,'delete');;		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	text(id_usuario)='{text}' or
	text(id_proyecto)='{text}'
");

$sql="
	select
		up.rowid,
		u.id_usuario,
		p.id_proyecto,
		u.usuario,
		p.proyecto,
		up.activo
	from
		sistema.usuarios_proyectos up
		join sistema.proyectos p using (id_proyecto)
		join usuarios u using (id_usuario)
	where
		1=1
		$whereFiltro
	order by
		id_usuario desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_usuario'],$row['']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'sistema\',\'usuario_proyecto_ae\',\'idUsuarioProyecto='.$row['id_usuario'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarUsuarioProyecto('.$row['id_usuario'].','.$row['id_proyecto'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']=$row['usuario'];
	$matriz[$c][]['html']=$row['proyecto'];
	$matriz[$c][]['html']=$row['activo']=='t' ? '<i class="glyphicon glyphicon-ok" style="color:green;"></i>' : '<i class="glyphicon glyphicon-ok" style="color:grey;"></i>';
	$matriz[$c][]['html']=infoAuditoria('sistema.usuarios_proyectos',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>