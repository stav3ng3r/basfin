<?
$documento=recibir_dato('documento');
/*
$sql="
	select
        id_documento,
        editable,
        ordenable,
        id_usuario_creo
	from
        documentos
	where
		id_sistema=".$tra['id_sistema']." and
		documento='".$documento."'
";
*/

$sql="
	select
        id_documento,
        editable,
        ordenable
	from
        documentos
	where
		documento='".$documento."'
";

$db->set_query($sql);
$db->execute_query();
$htmlFormatos='';
if($row=$db->get_array()){
    /*
	$sql="
    	select
            id_documento_fila,
            orden,
            formato,
            editable,
            ordenable,
            id_usuario_creo
    	from
            documento_filas
    	where
    		id_sistema=".$tra['id_sistema']." and
    		id_documento=".$row['id_documento']."
        order by
            orden asc
    ";
	*/
	
	$sql="
    	select
            id_documento_fila,
            orden,
            formato,
            editable,
            ordenable
    	from
            documento_filas
    	where
    		id_documento=".$row['id_documento']."
        order by
            orden asc
    ";
    $idDocumento=$row['id_documento'];
    $db->set_query($sql);
    $db->execute_query();
    $idsDocumentoFila='';
    $c=0;
    while($row=$db->get_array()){
        $c++;
        if($idsDocumentoFila!=''){$idsDocumentoFila.=',';}
        $idsDocumentoFila.=$row['id_documento_fila'];
        $htmlFormatos.='<div class="etiquetaDocumento" id="documentoEtiqueta'.$row['orden'].'">';
        $htmlFormatos.=obtenerFormatoFila($row['id_documento_fila']).chr(13);
        $htmlFormatos.='</div>';
    }
    if($c==0){
        $htmlFormatos="<a href=\"javascript:cargarSeccion('documentos','insertar_formato','idDocumento=$idDocumento','ventana');\">insertar formato</a>";
    }
    $resp['html']=str_replace('{formatos}',$htmlFormatos,$resp['html']);
    $resp['html']=str_replace('{idsDocumentoFila}',$idsDocumentoFila,$resp['html']);
}else{
	$resp['html']=leerHtmlEnSeccion('documento-nuevo').chr(13);
    $resp['html']=str_replace('{documento}',$documento,$resp['html']);
}
?>