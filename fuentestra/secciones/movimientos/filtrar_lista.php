<?
$filt_idContacto=recibir_dato('filt_idContacto');

$sql="
	select id_contacto, nombre
	from contactos
	where id_sistema=".$tra['id_sistema']."
	order by nombre
";
$db->set_query($sql);
$db->execute_query();
$optionsContactos='<option value=""></option>'.chr(13);
while($row=$db->get_array()){
	if($filt_idContacto==$row['id_contacto']){
		$selected='selected="selected"';
	}else{
		$selected='';	
	}
	$optionsContactos.='<option value="'.$row['id_contacto'].'" '.$selected.'>'.$row['nombre'].'</option>'.chr(13);
}

$filt_idConcepto=recibir_dato('filt_idConcepto');

$sql="
	select id_concepto, concepto
	from conceptos
	where id_sistema=".$tra['id_sistema']."
	order by concepto
";
$db->set_query($sql);
$db->execute_query();
$optionsConceptos='<option value=""></option>'.chr(13);
while($row=$db->get_array()){
	if($filt_idConcepto==$row['id_concepto']){
		$selected='selected="selected"';
	}else{
		$selected='';	
	}
	$optionsConceptos.='<option value="'.$row['id_concepto'].'" '.$selected.'>'.$row['concepto'].'</option>'.chr(13);
}

$resp['html']=str_replace('{optionsContactos}',$optionsContactos,$resp['html']);
$resp['html']=str_replace('{optionsConceptos}',$optionsConceptos,$resp['html']);
?>