<?php
$tabla1 = recibir_dato('tabla1');
list($esquema,$tabla) = explode(chr(46),$tabla1);

$sql="
	select
		tc.table_schema,
		tc.table_name
	from 
		information_schema.table_constraints as tc 
		join information_schema.key_column_usage as kcu using(constraint_name)
		join information_schema.constraint_column_usage as ccu using(constraint_name)
	where
		ccu.table_schema = '$esquema' and
		ccu.table_name = '$tabla' and
		tc.constraint_type = 'FOREIGN KEY'
	group by
		tc.table_schema,
		tc.table_name
";
$db->set_query($sql);
$db->execute_query();

$optionTablas = '<option value=""></option>';
while($row=$db->get_array()){
	$tablas = $row['table_schema'].'.'.$row['table_name'];
	$optionTablas .= '<option value="'.$tablas.'">'.$tablas.'</option>';
}

$resp['opcionTabla2'] = $optionTablas;
?>