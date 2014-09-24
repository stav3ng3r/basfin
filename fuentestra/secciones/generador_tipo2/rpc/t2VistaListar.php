<?php
$idT2=recibir_dato('idT2');

$sql="
	select
		case when fecha_confirmo is null then false else true end as confirmado
	from
		otros.generador_abm
	where
		id_generador_abm=$idT2
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$confirmado=$row['confirmado'];

$c=-1;
if($confirmado=='f'){
	$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='genT2';
	$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='genT2';
}
$c++;	$matriz[0][$c]['html']='text*';			$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:left;';		//--x-
$c++;	$matriz[0][$c]['html']='integer';		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:right;';	//--x-
$c++;	$matriz[0][$c]['html']='decimal';		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:right;';	//--x-
$c++;	$matriz[0][$c]['html']='date';			$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';	//--x-
$c++;	$matriz[0][$c]['html']='select';		$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';	//--x-
$c++;	$matriz[0][$c]['html']='textarea*';		$matriz[0][$c]['width']=0;		$matriz[0][$c]['style']='text-align:left;';		//--x-
$c++;	$matriz[0][$c]['html']='radio';			$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';	//--x-
//--e->cabecerasLista:2
$c++;	$matriz[0][$c]['html']=infoAuditoria('otros.generador_detalles',null,'delete');		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(text) ilike sp_ascii('%{text}%')	--x-
	--e->filtrosCadenaBuscar:2
");

$sql="
	select
		*
	from
		otros.generador_detalles
	where
		id_generador_abm=$idT2
		$whereFiltro
	order by
		id_generador_detalle desc
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	$c++;
	if($confirmado=='f'){
		$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'generador_tipo2\',\'t2Vista_ae\',\'idT2Vista='.$row['id_generador_detalle'].'\',\'ventana\');" title="editar"><img src="fuentestra/imagenes/bot/16x16/edit.png" /></a></div>';
		$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarT2Vista('.$row['id_generador_detalle'].');|no\',\'eliminar\');" title="eliminar"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a></div>';
	}
	$matriz[$c][]['html']=$row['text'];	//--x-
	$matriz[$c][]['html']=number_format($row['numero'],0,',','.');	//--x-
	$matriz[$c][]['html']=number_format($row['decimales'],2,',','.');	//--x-
	$matriz[$c][]['html']=substr($row['date'],0,10);	//--x-
	$matriz[$c][]['html']=$row['select_html'];	//--x-
	$matriz[$c][]['html']=$row['textarea'];	//--x-
	$matriz[$c][]['html']=$row['radio'];	//--x-
	//--e->filasLista:2
	$matriz[$c][]['html']=infoAuditoria('otros.generador_detalles',$row['rowid']);
}
$resp['html']=armarLista($matriz);
?>