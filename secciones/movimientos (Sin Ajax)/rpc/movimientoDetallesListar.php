<?php
$idMovimiento=recibir_dato('idMovimiento');

$sql="
	select
		confirmado,
		tipo
	from
		sistema.movimientos
	where
		id_movimiento=$idMovimiento
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$confirmado=$row['confirmado'];
$tipo=strtolower($row['tipo']);

$c=-1;
/*
if($confirmado=='f'){
	$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistPaises';
	$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='sistPaises';
}
*/
$c++;	$matriz[0][$c]['html']='Concepto*';	 $matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Rubro*';	 $matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Valor*';	 $matriz[0][$c]['width']='*';	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.ciudades',null,'delete');		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(ciudad) ilike sp_ascii('%{text}%')
");

$sql="
	select
		*
	from
		sistema.movimiento_detalles
	where
		id_movimiento=$idMovimiento
		$whereFiltro
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	$c++;
	if($confirmado=='f'){
		$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:cargarSeccion(\'sistema\',\'ciudad_ae\',\'idCiudad='.$row['id_ciudad'].'\',\'ventana\');" title="editar"><img src="fuentestra/imagenes/bot/16x16/edit.png" /></a></div>';
		$matriz[$c][]['html']='<div style="width:16px;height:16px;"><a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarCiudad('.$row['id_ciudad'].');|no\',\'eliminar\');" title="eliminar"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a></div>';
	}
	$matriz[$c][]['html']=$row['concepto'];
	$matriz[$c][]['html']=$row['id_rubro'];
	$matriz[$c][]['html']=$row[$tipo];
	$matriz[$c][]['html']=infoAuditoria('sistema.movimiento_detalles',$row['rowid']);
}
$resp['html']=armarLista($matriz);
?>