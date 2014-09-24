<?php
$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';				$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';				$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistActivaciones';
$c++;	$matriz[0][$c]['html']='&nbsp;';				$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistActivaciones';
$c++;	$matriz[0][$c]['html']='Fecha Activación';	 	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Fecha Operación';	 	$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Validez';	 			$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Observación*';	 		$matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.activaciones',null,'delete');;	$matriz[0][$c]['width']=16;						$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(observacion) ilike sp_ascii('%{text}%')
");

$sql="
	select
		rowid,
		id_activacion,
		fecha_activacion,
		fecha_operacion,
		validez,
		observacion
	from
		sistema.activaciones
	where
		1=1
		$whereFiltro
	order by
		id_activacion desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_activacion'],$row['observacion']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'sistema\',\'activacion_ae\',\'idActivacion='.$row['id_activacion'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarActivacion('.$row['id_activacion'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';
	$matriz[$c][]['html']=substr($row['fecha_activacion'],0,16);
	$matriz[$c][]['html']=substr($row['fecha_operacion'],0,16);
	$matriz[$c][]['html']=''; //$row['validez'];
	$matriz[$c][]['html']=$row['observacion'];
	$matriz[$c][]['html']=infoAuditoria('sistema.activaciones',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
}
$resp['html']=armarLista($matriz);
?>