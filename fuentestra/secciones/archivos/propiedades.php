<?
$idArchivo=recibir_dato('idArchivo');

$sql="
	select
		tipo,
		id_archivo_vista_previa,
		enlace,
		permitir_descargar,
		ampliar,
		firma_tipo
	from
		archivos
	where
		id_sistema=".$tra['id_sistema']." and 
		id_archivo=$idArchivo
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();

if($row['enlace']!=''){
	$estadoEnlace='true';
}else{
	$estadoEnlace='false';
}
if($row['permitir_descargar']=='t'){
	$propiedadPermitirDescargar='true';	
}else{
	$propiedadPermitirDescargar='false';
}

$resp['html']=str_replace('{idArchivo}',$idArchivo,$resp['html']);
$resp['html']=str_replace('{tipo}',$row['tipo'],$resp['html']);
$resp['html']=str_replace('{idArchivoVistaPrevia}',$row['id_archivo_vista_previa'],$resp['html']);
$resp['html']=str_replace('{enlace}',$row['enlace'],$resp['html']);
$resp['html']=checkCheckBox('checkEnlace',$resp['html'],$estadoEnlace);
$resp['html']=checkCheckBox('propiedadPermitirDescargar',$resp['html'],$propiedadPermitirDescargar);
$resp['html']=selectedSelect('propiedadAmpliar',$row['ampliar'],$resp['html']);
$resp['html']=selectedSelect('propiedadFirma',$row['firma_tipo'],$resp['html']);
?>