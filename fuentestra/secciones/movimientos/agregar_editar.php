<?
if($accion=='preEditar'){
	$tituloAccion='Editar movimiento';
	$idMovimiento=recibir_dato('id');
	
	$sql="select * from movimientos where id_sistema=".$tra['id_sistema']." and id_movimiento=$idMovimiento";
	$db->set_query($sql);
	$db->execute_query();
	$optionsContactos='<option value=""></option>'.chr(13);
	$row=$db->get_array();
	
	$tipoMovimiento=$row['tipo_movimiento'];
	$fechaMovimiento=$row['fecha_movimiento'];
	$idContacto=$row['id_contacto'];
	$idConcepto=$row['id_concepto'];
	$observacion=$row['observacion_movimiento'];
	$tipoComprobante=$row['comprobante_tipo'];
	$nroComprobante=$row['comprobante_nro'];
	$monto=$row['monto'];
	$fechaVencimiento=$row['fecha_vencimiento'];
	if($row['estado']=='t'){$estado='true';}else{$estado='false';}
}else{
	$tipoMovimiento=recibir_dato('tipo');
	$tituloAccion='Agregar movimiento';
	$fechaMovimiento=date('d/m/Y');
}

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
	if($idContacto==$row['id_contacto']){
		$selected='selected="selected"';
	}else{
		$selected='';	
	}
	$optionsContactos.='<option value="'.$row['id_contacto'].'" '.$selected.'>'.$row['nombre'].'</option>'.chr(13);
}

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
	if($idConcepto==$row['id_concepto']){
		$selected='selected="selected"';
	}else{
		$selected='';	
	}
	$optionsConceptos.='<option value="'.$row['id_concepto'].'" '.$selected.'>'.$row['concepto'].'</option>'.chr(13);
}

$resp['html']=str_replace('{tituloAccion}',$tituloAccion,$resp['html']);
$resp['html']=checkRadio('tipoMovimiento',$tipoMovimiento,$resp['html']);
$resp['html']=str_replace('{fecha}',$fechaMovimiento,$resp['html']);
$resp['html']=str_replace('{optionsContactos}',$optionsContactos,$resp['html']);
$resp['html']=str_replace('{optionsConceptos}',$optionsConceptos,$resp['html']);
$resp['html']=str_replace('{observacion}',$observacion,$resp['html']);
$resp['html']=str_replace('{tipoComprobante}',$tipoComprobante,$resp['html']);
$resp['html']=str_replace('{nroComprobante}',$nroComprobante,$resp['html']);
$resp['html']=str_replace('{monto}',$monto,$resp['html']);
$resp['html']=str_replace('{fechaVencimiento}',$fechaVencimiento,$resp['html']);
$resp['html']=checkRadio('estado',$estado,$resp['html']);
$resp['html']=str_replace('{idMovimiento}',$idMovimiento,$resp['html']);
?>