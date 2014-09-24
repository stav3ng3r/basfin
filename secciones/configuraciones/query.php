<?php

$sql="
	select
		id_reserva,
		id_cdp,
		periodo,
		tp,
		prog,
		subprog,
		proy,
		div5,
		div6,
		id_og,
		id_ff,
		id_of,
		id_dpto,
		valor,
		fecha,
		estado
	from
		presup.reservas
	where
		id_cdp='439' and tp=1 and prog=18
	order by
		tp,
		prog,
		subprog,
		proy,
		div5,
		div6,
		id_og,
		id_ff,
		id_of,
		id_dpto
limit 10
";
$db->set_query($sql);
$db->execute_query();
$html='aca va el listado de registros<table border=1>';
while($row=$db->get_array()){
	
	$html.='<tr>';
	
	$html.='<td>'.$row['id_reserva'].'</td>';
	$html.='<td>'.$row['id_cdp'].'</td>';
	$html.='<td>'.$row['periodo'].'</td>';
	$html.='<td>'.$row['tp'].'</td>';
	$html.='<td>'.$row['prog'].'</td>';
	$html.='<td>'.$row['subprog'].'</td>';
	$html.='<td>'.$row['proy'].'</td>';
	$html.='<td>'.$row['div5'].'</td>';
	$html.='<td>'.$row['div6'].'</td>';
	$html.='<td>'.$row['id_og'].'</td>';
	$html.='<td>'.$row['id_ff'].'</td>';
	$html.='<td>'.$row['id_of'].'</td>';
	$html.='<td>'.$row['id_dpto'].'</td>';
	$html.='<td>'.$row['valor'].'</td>';
	$html.='<td>'.$row['fecha'].'</td>';
	$html.='<td>'.$row['estado'].'</td>';
	
	$html.='</tr>';
	
}
$html.='</table>';
$resp['html']=$html;
?>