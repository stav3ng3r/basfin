<?
$documento=recibir_dato('documento');
$formato=recibir_dato('formato');


if($documento!=''){
	$tituloDocumento=str_replace('-',' ',$documento);
	$tituloDocumento=strtolower($tituloDocumento);
	$tituloDocumento=strtoupper(substr($tituloDocumento,0,1)).substr($tituloDocumento,1);
}else{
	$tituloDocumento='';
}

$resp['html']=str_replace('{documento}',$documento,$resp['html']);
$resp['html']=str_replace('{tituloDocumento}',$tituloDocumento,$resp['html']);
$resp['html']=str_replace('{formato}',$formato,$resp['html']);
?>