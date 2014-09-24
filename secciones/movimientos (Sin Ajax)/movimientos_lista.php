<?php

$sql="
	select
		coalesce(sum(md.ingreso),0) as ingreso,
		coalesce(sum(md.egreso),0) as egreso
	from
		sistema.movimientos m
		join sistema.movimiento_detalles md using (id_movimiento)
	where
		m.id_proyecto={$_SESSION['id_proyecto']}
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$saldoGral=number_format($row['ingreso']-$row['egreso'],0,',','.');

for ($i=(date('d')-6); $i<=date('d'); $i++) {
	$tiempo = mktime(0,0,0,date('n'),$i,date('Y'));
	$fecha = date('Y-m-d', $tiempo);
	
	$sql="
		select
			coalesce(sum(md.ingreso),0) as ingreso,
			coalesce(sum(md.egreso),0) as egreso
		from
			sistema.movimientos m
			join sistema.movimiento_detalles md using (id_movimiento)
		where
			m.fecha::date='$fecha' and
			m.id_proyecto={$_SESSION['id_proyecto']}
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$ingreso[] = (float)$row['ingreso'];
	$egreso[] = (float)$row['egreso'];
	$fechas[] = date('d/m/Y', $tiempo);
}

$datos = json_encode(
	array(
		'fechas' => $fechas,
		'datos' => array(
			array('name' => 'Ingreso', 'data' => $ingreso),
			array('name' => 'Egreso', 'data' => $egreso)
		)
	)
);
?>