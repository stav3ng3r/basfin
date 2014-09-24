<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistProyectos';
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistProyectos';
$c++;	$matriz[0][$c]['html']='&nbsp;';			$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistProyectos';
$c++;	$matriz[0][$c]['html']='Proyecto*';	 		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Teléfono*';	 		$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Email*';	 		$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Dirección*';	 	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Firmantes*';	 	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Categoria*';		$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.proyectos',null,'delete');;		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(p.proyecto) ilike sp_ascii('%{text}%') or
	sp_ascii(telefono) ilike sp_ascii('%{text}%') or
	sp_ascii(email) ilike sp_ascii('%{text}%') or
	sp_ascii(direccion) ilike sp_ascii('%{text}%') or
	sp_ascii(zona_horaria) ilike sp_ascii('%{text}%')
");

$sql="
	select
		p.rowid,
		p.id_proyecto,
		p.proyecto,
		p.telefono,
		p.email,
		p.direccion,
		p.id_ciudad,
		p.logo,
		p.firmantes,
		p.coordenadas,
		p.id_categoria,
		p.zona_horaria,
		p.lenguaje,
		c.categoria
	from
		sistema.proyectos p
		join sistema.categorias c using (id_categoria)
	where
		1=1
		$whereFiltro
	order by
		id_proyecto desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_proyecto'],$row['proyecto']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'sistema\',\'proyecto_ae\',\'idProyecto='.$row['id_proyecto'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarProyecto('.$row['id_proyecto'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'sistema\',\'proyecto_usuario\',\'idProyecto='.$row['id_proyecto'].'\',\'ventana\');" title="usuarios"><i class="glyphicon glyphicon-user"></i></a>';
	$matriz[$c][]['html']=$row['proyecto'];
	$matriz[$c][]['html']=empty($row['telefono']) ? '' : $row['telefono'];
	$matriz[$c][]['html']=empty($row['email']) ? '' : $row['email'];
	$matriz[$c][]['html']=empty($row['direccion']) ? '' : $row['direccion'];
	$matriz[$c][]['html']=empty($row['firmantes']) ? '' : $row['firmantes'];
	$matriz[$c][]['html']=$row['categoria'];
	$matriz[$c][]['html']=infoAuditoria('sistema.proyectos',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>