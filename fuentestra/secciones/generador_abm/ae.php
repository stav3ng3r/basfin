<?php
$sql = "
	select
		table_schema,
		table_name
	from
		information_schema.tables
	where
		table_schema != 'information_schema' and
		table_schema != 'pg_catalog'
	order by
		table_schema,
		table_name
";
$db->set_query($sql);
$db->execute_query();

$optionTablas = '<option value=""></option>';
while($row=$db->get_array()){
	$tablas = $row['table_schema'].'.'.$row['table_name'];
	$optionTablas .= '<option value="'.$tablas.'">'.$tablas.'</option>';
}

$sql = "
	select
		split_part(detalle, ' - ', 1) as detalle
	from
		permisos
	group by
		split_part(detalle, ' - ', 1)
	order by
		split_part(detalle, ' - ', 1)
";
$db->set_query($sql);
$db->execute_query();

$optionPermisos = '<option value=""></option>';
$optionPermisos .= '<option value="nuevo">Nuevo Permiso</option>';
while($row=$db->get_array()){
	if($row['detalle']!=''){
		$optionPermisos .= '<option value="'.$row['detalle'].'">'.$row['detalle'].'</option>';
	}
}

$resp['html']=str_replace('{optionTablas}',$optionTablas,$resp['html']);
$resp['html']=str_replace('{optionPermisos}',$optionPermisos,$resp['html']);
?>