<?
$idFilaDocumento = recibir_dato('idFilaDocumento');

$sql="
	select
        presentacion
	from
        documento_filas
	where
		id_sistema=".$tra['id_sistema']." and
		id_documento_fila=$idFilaDocumento
        
";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$presentacion=$row['presentacion'];

$sql="
	select
        id_archivo
	from
        documento_fila_archivos
	where
		id_sistema=".$tra['id_sistema']." and
		id_documento_fila=$idFilaDocumento
    order by
        orden
        
";
$db->set_query($sql);
$db->execute_query();
$idsArchivos='';
while($row=$db->get_array()){
    if($idsArchivos!=''){$idsArchivos.=',';}
    $idsArchivos.=$row['id_archivo'];
}
$resp['html']=selectedSelect('presentacionArchivo',$presentacion,$resp['html']);
$resp['html']=str_replace('{idsArchivos}',$idsArchivos,$resp['html']);
$resp['html']=str_replace('{idFilaDocumento}',$idFilaDocumento,$resp['html']);
?>