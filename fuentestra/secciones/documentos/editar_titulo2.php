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
        orden,
        texto
	from
        documento_fila_textos
	where
		id_sistema=".$tra['id_sistema']." and
		id_documento_fila=$idFilaDocumento
    order by
        orden
        
";
$db->set_query($sql);
$db->execute_query();
while($row=$db->get_array()){
    $resp['html']=str_replace('{texto:'.$row['orden'].'}',$row['texto'],$resp['html']);
}
for($i=1;$i<=3;$i++){
    $resp['html']=str_replace("{texto:$i}",'',$resp['html']);
}

$resp['html']=selectedSelect('presentacionTitulo2',$presentacion,$resp['html']);

$resp['html']=str_replace('{idFilaDocumento}',$idFilaDocumento,$resp['html']);
?>