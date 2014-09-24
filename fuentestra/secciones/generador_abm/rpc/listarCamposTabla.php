<?php
$tabla = recibir_dato('tabla');
$idTabla = recibir_dato('idTabla');

list($schema,$table) = explode(chr(46),$tabla);

$sql = "
	select
		column_name,
		data_type
	from
		information_schema.columns
	where
		table_schema = '$schema' and
		table_name = '$table'
	order by
		ordinal_position
";
$db->set_query($sql);
$db->execute_query();
$listaCamposTabla='';
$c=0;

while($row=$db->get_array()){
	$c++;
	$nombreCampo=$row['column_name'];

	if((substr($row['column_name'],0,3) == 'id_' && $listaCamposTabla=='') || $row['column_name'] == 'estado' || $row['column_name'] == 'id_usuario_confirmo' || $row['column_name'] == 'fecha_confirmo' || $row['column_name'] == 'rowid'){
		$editList='';
	}else{
		$editList='checked';
		$nombreCampo=str_replace('_',' ',$nombreCampo);
		$nombreCampo=str_replace('cion','ción',$nombreCampo);
		$nombreCampo=ucfirst($nombreCampo);
	}
	
	if($idTabla==2 && substr($row['column_name'],0,3) == 'id_' && $c==2){
		$editList='';
	}
	
	$listaCamposTabla .= "
		<tr>
			<td><input type='text' id='genABM_nombreCampoT$idTabla' title='{$row['column_name']} ({$row['data_type']})' class='{$row['column_name']}' value='$nombreCampo' /></td>
			<td><input type='checkbox' name='genABM_selCamposListarT$idTabla' value='{$row['column_name']}' id='genABM_selCamposListarT$idTabla' $editList title='Listar' /></td>
			<td><input type='checkbox' name='genABM_selCamposAgregarEditarT$idTabla' value='{$row['column_name']}' id='genABM_selCamposAgregarEditarT$idTabla' $editList title='Agregar - Editar' /></td>
		</tr>
	";
}

$resp['titulo']=$tabla;
$resp['idTabla']=$idTabla;
$resp['html']=$listaCamposTabla;
//
?>