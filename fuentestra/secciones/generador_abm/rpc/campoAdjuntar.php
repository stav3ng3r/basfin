<?php
$tablax = recibir_dato('tablax');
list($esquema,$tabla) = explode(chr(46),$tablax);

$sql="
	select
		column_name
	from
		information_schema.columns
	where
		table_schema='$esquema' and
		table_name='$tabla' and
		data_type='ARRAY'
";
$db->set_query($sql);
$db->execute_query();

$optionCampos = '<option value=""></option>';
while($row=$db->get_array()){
	$campo = $row['column_name'];
	$optionCampos .= '<option value="'.$campo.'">'.$campo.'</option>';
}

$resp['campoAdjuntar'] = $optionCampos;
?>