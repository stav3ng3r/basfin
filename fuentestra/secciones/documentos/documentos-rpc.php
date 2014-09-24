<?
if($accionRPC=='crearDocumento'){
	$documento = recibir_dato('documento');
	$formato = recibir_dato('formato');
	$titulo = recibir_dato('titulo');
	$permitirEditar = recibir_dato('permitirEditar');
	$permitirOrdenar = recibir_dato('permitirOrdenar');
    
    $idDocumento=obtenerSigId('documentos');
    
	$sql="
		insert into documentos (
			id_sistema,
			id_documento,
			documento,
			editable,
			ordenable,
			id_usuario_creo,
			id_usuario_modif
		) values (
			".$tra['id_sistema'].",
			$idDocumento,
			'$documento',
			$permitirEditar,
            $permitirOrdenar,
			".$tra['id_usuario'].",
			".$tra['id_usuario']."
		)
	";
	$db->set_query($sql);
	$db->execute_query();
    $resp['documento']=$documento;
}

if($accionRPC=='insertarFormato'){
    $idDocumento = recibir_dato('idDocumento');
	$idDocumentoFila = recibir_dato('idDocumentoFila');
	$formato = recibir_dato('formato');
	$permitirEditar = recibir_dato('permitirEditar');
	$permitirOrdenar = recibir_dato('permitirOrdenar');
    
    if($idDocumentoFila==''){
        $orden=1;
        $idDocumentoFila=insertarFormato($formato,$orden,$idDocumento,$permitirEditar,$permitirOrdenar);
    }else{
        $sql="
        	select
                id_documento,
                orden
        	from
                documento_filas
        	where
        		id_sistema=".$tra['id_sistema']." and
        		id_documento_fila=$idDocumentoFila
        ";
        $db->set_query($sql);
        $db->execute_query();
        $row=$db->get_array();
        $orden=$row['orden']+1;
        $idDocumentoFila=insertarFormato($formato,($row['orden']+1),$row['id_documento'],$permitirEditar,$permitirOrdenar);
    }
    $resp['htmlFormato']=obtenerFormatoFila($idDocumentoFila);
    $resp['orden']=$orden;
    $resp['idDocumentoFila']=$idDocumentoFila;
    $resp['formato']=$formato;
}

if($accionRPC=='eliminarFilaDocumento'){
    $idFilaDocumento = recibir_dato('idFilaDocumento');
    $sql="select * from documento_filas where id_sistema=".$tra['id_sistema']." and id_documento_fila=".$idFilaDocumento;
    $db->set_query($sql);
    $db->execute_query();
    $row=$db->get_array();
    $idDocumento=$row['id_documento'];
    $orden=$row['orden'];
    
    $sql="delete from documento_fila_archivos where id_sistema=".$tra['id_sistema']." and id_documento_fila=".$idFilaDocumento;
    $db->set_query($sql);
    $db->execute_query();
    
    $sql="delete from documento_fila_textos where id_sistema=".$tra['id_sistema']." and id_documento_fila=".$idFilaDocumento;
    $db->set_query($sql);
    $db->execute_query();
    
    $sql="delete from documento_filas where id_sistema=".$tra['id_sistema']." and id_documento_fila=".$idFilaDocumento;
    $db->set_query($sql);
    $db->execute_query();
    
    $sql="update documento_filas set orden = (orden - 1) where id_sistema=".$tra['id_sistema']." and id_documento=$idDocumento and orden>$orden";
    $db->set_query($sql);
    $db->execute_query();
}

if($accionRPC=='subirOrdenFilaDocumento'){
    $idFilaDocumento = recibir_dato('idFilaDocumento');
    $sql="select * from documento_filas where id_sistema=".$tra['id_sistema']." and id_documento_fila=".$idFilaDocumento;
    $db->set_query($sql);
    $db->execute_query();
    $row=$db->get_array();
    $idDocumento=$row['id_documento'];
    $orden=$row['orden'];
    
    $sql="update documento_filas set orden = (orden + 1) where id_sistema=".$tra['id_sistema']." and id_documento=$idDocumento and orden=".($orden-1);
    $db->set_query($sql);
    $db->execute_query();
    
    $sql="update documento_filas set orden = ".($orden - 1)." where id_sistema=".$tra['id_sistema']." and id_documento_fila=$idFilaDocumento";
    $db->set_query($sql);
    $db->execute_query();    
}

if($accionRPC=='editarInfosFilaDocumento'){
    $idDocumentoFila = recibir_dato('idDocumentoFila');
    $presentacion = recibir_dato('presentacion');
    $textoCol[1] = recibir_dato('textoCol1');
    $textoCol[2] = recibir_dato('textoCol2');
    $textoCol[3] = recibir_dato('textoCol3');
    $idsArchivos = recibir_dato('idsArchivos');
    $vIdsArchivos = explode(',',$idsArchivos);

	for($i=1;$i<=3;$i++){
		$textoCol[$i]=str_replace("'",chr(92)."'",$textoCol[$i]);
	}

    $sql="update documento_filas set presentacion='$presentacion', id_usuario_modif=".$tra['id_usuario'].", fecha_usuario_modif=now() where id_sistema=".$tra['id_sistema']." and id_documento_fila=$idDocumentoFila";
    $db->set_query($sql);
    $db->execute_query();

    $sql="delete from documento_fila_textos where id_sistema=".$tra['id_sistema']." and id_documento_fila=$idDocumentoFila";
    $db->set_query($sql);
    $db->execute_query();
    
    for($i=1;$i<=3;$i++){
        $sql="
            insert into documento_fila_textos (
                id_sistema,
                id_documento_fila_texto,
                id_documento_fila,
                orden,
                texto,
                id_usuario_creo
            ) values (
                ".$tra['id_sistema'].",
                ".obtenerSigId('documento_fila_textos').",
                $idDocumentoFila,
                $i,
                '".$textoCol[$i]."',
                ".$tra['id_usuario']."
            )
        ";
        $db->set_query($sql);
        $db->execute_query();
    }
    
    $sql="delete from documento_fila_archivos where id_sistema=".$tra['id_sistema']." and id_documento_fila=$idDocumentoFila";
    $db->set_query($sql);
    $db->execute_query();

    if($idsArchivos!=''){
        for($i=0;isset($vIdsArchivos[$i])==true;$i++){
            $sql="
                insert into documento_fila_archivos (
                    id_sistema,
                    id_documento_fila_archivo,
                    id_documento_fila,
                    orden,
                    id_archivo,
                    id_usuario_creo
                ) values (
                    ".$tra['id_sistema'].",
                    ".obtenerSigId('documento_fila_archivos').",
                    $idDocumentoFila,
                    ".($i+1).",
                    '".$vIdsArchivos[$i]."',
                    ".$tra['id_usuario']."
                )
            ";
            $db->set_query($sql);
            $db->execute_query();
        }
    }
 
    $sql="select orden from documento_filas where id_sistema=".$tra['id_sistema']." and id_documento_fila=".$idDocumentoFila;
    $db->set_query($sql);
    $db->execute_query();
    $row=$db->get_array();
    $resp['orden']=$row['orden'];
    
    $resp['html']=obtenerFormatoFila($idDocumentoFila);
}
?>