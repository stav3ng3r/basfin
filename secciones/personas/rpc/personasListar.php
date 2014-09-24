<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';				$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';				$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='persPersonas';
$c++;	$matriz[0][$c]['html']='&nbsp;';				$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='persPersonas';
$c++;	$matriz[0][$c]['html']='CI/RUC*';	 			$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Persona*';	 			$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Dirección*';	 		$matriz[0][$c]['width']=200;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Telefono*';	 			$matriz[0][$c]['width']=100;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Correo*';	 			$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Nacimiento';	 		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Observación*';	 		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.personas',null,'delete');;		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(py.proyecto) ilike sp_ascii('%{text}%') or
	sp_ascii(ps.identificador) ilike sp_ascii('%{text}%') or
	sp_ascii(ps.persona) ilike sp_ascii('%{text}%') or
	sp_ascii(ps.direccion) ilike sp_ascii('%{text}%') or
	sp_ascii(ps.telefono) ilike sp_ascii('%{text}%') or
	sp_ascii(ps.correo) ilike sp_ascii('%{text}%') or
	sp_ascii(ps.observacion) ilike sp_ascii('%{text}%')
");

$sql="
	select
		ps.rowid,
		ps.id_persona,
		py.proyecto,
		ps.identificador,
		ps.persona,
		ps.direccion,
		ps.telefono,
		ps.correo,
		ps.nacimiento,
		ps.observacion
	from
		sistema.personas ps
		left join sistema.proyectos py using (id_proyecto)	
	where
		1=1
		$whereFiltro
	order by
		id_persona desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_persona'],$row['persona']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'personas\',\'persona_ae\',\'idPersona='.$row['id_persona'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarPersona('.$row['id_persona'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']=$row['identificador'];
	$matriz[$c][]['html']=$row['persona'];
	$matriz[$c][]['html']=$row['direccion'];
	$matriz[$c][]['html']=$row['telefono'];
	$matriz[$c][]['html']=$row['correo'];
	$matriz[$c][]['html']=substr($row['nacimiento'],0,10);
	$matriz[$c][]['html']=$row['observacion'];
	$matriz[$c][]['html']=infoAuditoria('sistema.personas',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>