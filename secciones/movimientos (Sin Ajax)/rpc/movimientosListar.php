<?php
$idMovimiento = recibir_dato('id_movimiento');

$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';					$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';					$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='moviMovimientos';
$c++;	$matriz[0][$c]['html']='&nbsp;';					$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='moviMovimientos';
$c++;	$matriz[0][$c]['html']='Fecha';	 					$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['data']='fecha';						$matriz[0][$c]['orderBy']='fecha';
$c++;	$matriz[0][$c]['html']='Client./Proveed.*';	 		$matriz[0][$c]['width']=250;	$matriz[0][$c]['style']='text-align:left;';			$matriz[0][$c]['data']='persona';					$matriz[0][$c]['orderBy']='persona';
$c++;	$matriz[0][$c]['html']='Comprobante*';				$matriz[0][$c]['width']=0;		$matriz[0][$c]['style']='text-align:left;';			$matriz[0][$c]['data']='comprobante_nro';			$matriz[0][$c]['orderBy']='comprobante_nro';
$c++;	$matriz[0][$c]['html']='Valor';						$matriz[0][$c]['width']=150;	$matriz[0][$c]['style']='text-align:right;';		$matriz[0][$c]['data']='valor';						$matriz[0][$c]['orderBy']='valor';
$c++;	$matriz[0][$c]['html']=infoAuditoria('sistema.movimientos',null,'delete');		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

$whereFiltro=generarWhereFiltroCadenaBuscar("
	sp_ascii(comprobante_nro) ilike sp_ascii('%{text}%') or
	sp_ascii(tipo) ilike sp_ascii('%{text}%') or
	text(id_usuario)='{text}' or
	sp_ascii(moneda) ilike sp_ascii('%{text}%')
");

if (!empty($idMovimiento)) {
	$whereFiltro.=" and id_movimiento=$idMovimiento ";
}

if($orderBy==''){$orderBy='fecha desc';}

$sql="
	select
		*
	from
		(
		select
			m.rowid,
			id_movimiento,
			m.id_proyecto,
			m.fecha,
			fecha_ideal,
			p.persona,
			comprobante_nro,
			tipo,
			confirmado,
			id_usuario
			moneda,
			correspondiente_al_mes_de,
			(
				select sum(case when m.tipo='ingreso' then md.ingreso else md.egreso end)
				from sistema.movimiento_detalles md
				where md.id_movimiento=m.id_movimiento
			) as valor			
		from
			sistema.movimientos m
			join sistema.personas p using (id_persona)
		where
			m.id_proyecto={$_SESSION['id_proyecto']}
			$whereFiltro
		) a
	order by
		$orderBy		
";
$sql=filtrarQueryLista($sql);
$db->set_query($sql);
$db->execute_query();
$c=0;
while($row=$db->get_array()){
	
	//-- informacion de registros de lista
	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_movimiento'],$row['comprobante_tipo']);
	$matriz[$c][]['html']='<a href="javascript:cargarSeccion(\'movimientos\',\'movimiento_ae\',\'idMovimiento='.$row['id_movimiento'].'\',\'ventana\');" title="editar"><i class="glyphicon glyphicon-edit"></i></a>';
	$matriz[$c][]['html']='<a href="javascript:dialogo(\'Confirma que desea eliminar este registro\',\'si:eliminarMovimiento('.$row['id_movimiento'].');|no\',\'eliminar\');" title="eliminar"><i class="glyphicon glyphicon-remove"></i></a>';	
	$matriz[$c][]['html']=substr($row['fecha'],0,16);
	$matriz[$c][]['html']=$row['persona'];
	$matriz[$c][]['html']=$row['comprobante_nro'];
	$matriz[$c][]['html']=number_format($row['valor'],0,',','.');
	$matriz[$c][]['html']=infoAuditoria('sistema.movimientos',$row['rowid']);
	$matriz[$c]['estado']=$row['estado'];
	$matriz[$c]['id']=$row['id_movimiento'];
}
$resp['html']=armarLista($matriz);
?>