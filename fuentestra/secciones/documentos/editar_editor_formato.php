<?
$idFilaDocumento = recibir_dato('idFilaDocumento');

$sql="
	select
        texto
	from
        documento_fila_textos
	where
		id_sistema=".$tra['id_sistema']." and
		id_documento_fila=$idFilaDocumento and
        orden=1
        
";
$db->set_query($sql);
$db->execute_query();
if($row=$db->get_array()){
    $codigoHtml=$row['texto'];
}else{
    $codigoHtml='';
}
$resp['html']=str_replace('{texto}',$codigoHtml,$resp['html']);
$resp['html']=str_replace('{idFilaDocumento}',$idFilaDocumento,$resp['html']);
?>