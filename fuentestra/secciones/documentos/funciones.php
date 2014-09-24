<?
function insertarFormato($formato,$orden,$idDocumento,$permitirEditar,$permitirOrdenar){
    global $db, $tra;

    /*
    formatos/presentacion
    
        titulo1
            normal (agrupar contenido) hasta el siguiente titulo principal/x elementos
            2columnas
            3columnas
        titulo2
            normal (agrupar contenido) hasta el siguiente titulo/x elementos
            2columnas
            3columnas
        parrafo
            normal
            2columnas
            3columnas
        parrafo_archivo
            img_izq_aleatorio
            img_izq_slider
            img_izq_fade
            img_der_aleatorio
            img_der_slider
            img_der_fade
        archivo
            1imagen
            slider
            fade
            2imagenes
            3imagenes
            4imagenes
            1descargar
            2descargar
        editor_formato
        seccion
    */

    $sql="
    	update documento_filas set
            orden = (orden + 1)
    	where
    		id_sistema=".$tra['id_sistema']." and
    		id_documento=$idDocumento and
            orden>=$orden
    ";
    $db->set_query($sql);
    $db->execute_query();
     
    $idDocumentoFila=obtenerSigId('documento_filas');
    
    $presentacion='';
    if($formato=='titulo1'){$presentacion='normal';}
    if($formato=='titulo2'){$presentacion='normal';}
    if($formato=='parrafo'){$presentacion='normal';}
    if($formato=='parrafo_archivo'){$presentacion='img_izq_aleatorio';}
    if($formato=='archivo'){$presentacion='1imagen';}
    
	$sql="
		insert into documento_filas (
			id_sistema,
            id_documento_fila,
			id_documento,
            orden,
            formato,
            presentacion,
            editable,
            ordenable,
			id_usuario_creo,
			id_usuario_modif
		) values (
			".$tra['id_sistema'].",
            $idDocumentoFila,
			$idDocumento,
			$orden,
			'$formato',
            '$presentacion',
            $permitirEditar,
            $permitirOrdenar,
			".$tra['id_usuario'].",
			".$tra['id_usuario']."
		)
	";
	$db->set_query($sql);
	$db->execute_query();
    
    return $idDocumentoFila;
}

function obtenerFormatoFila($idDocumentoFila){
    global $db3, $tra;
    
    $sql3="
    	select
            orden,
            formato,
            presentacion,
            editable,
            ordenable
    	from
            documento_filas
    	where
    		id_sistema=".$tra['id_sistema']." and
    		id_documento_fila=$idDocumentoFila
    ";
    $db3->set_query($sql3);
    $db3->execute_query();
    $rowFila=$db3->get_array();
    
    $htmlFormato='';
    $htmlFormato.=leerHtmlEnSeccion('formato-admin').chr(13);
    $sql3="
    	select
            orden,
            texto
    	from
            documento_fila_textos
    	where
    		id_sistema=".$tra['id_sistema']." and
    		id_documento_fila=$idDocumentoFila
        order by
            orden
    ";
    $db3->set_query($sql3);
    $db3->execute_query();
    $cTextos=0;
    while($rowTextos=$db3->get_array()){
        $cTextos++;
		$vTextos[$rowTextos['orden']]['texto']=$rowTextos['texto'];
		if($rowFila['formato']!='editor_formato'){
			$vTextos[$rowTextos['orden']]['texto']=str_replace(chr(10),'<br>',$rowTextos['texto']);
		}
    }
    $sql3="
    	select
            orden,
            id_archivo,
            enlace
    	from
            documento_fila_archivos
    	where
    		id_sistema=".$tra['id_sistema']." and
    		id_documento_fila=$idDocumentoFila
      order by
        orden
    ";
    $db3->set_query($sql3);
    $db3->execute_query();
    $cArchivos=0;
    while($rowArchivos=$db3->get_array()){
        $cArchivos++;
        $vArchivos[$rowArchivos['orden']]['id_archivo']=$rowArchivos['id_archivo'];
        $vArchivos[$rowArchivos['orden']]['enlace']=$rowArchivos['enlace'];
    }
    if(($cTextos==0)&&($cArchivos==0)){
        $htmlFormato.="<br>Aún no has insertado la información. Click en editar para insertar la información<br><br>";
    }else{
        if($rowFila['formato']=='editor_formato'){
            $htmlFormato.=$vTextos[1]['texto'];
        }else{
            include 'fuentestra/secciones/documentos/dimensiones-vista-archivo.php';
            $cantInsertFormato=1;
            if($rowFila['formato']=='archivo'){
                if(($rowFila['presentacion']=='slider')||($rowFila['presentacion']=='fade')){
                    $cantElementosPorFila=$cArchivos;
                    $cantInsertFormato=1;                
                }else{
                    $cantElementosPorFila=1;
                    if(($rowFila['presentacion']=='2imagenes')||($rowFila['presentacion']=='2descargar')){$cantElementosPorFila=2;}
                    if($rowFila['presentacion']=='3imagenes'){$cantElementosPorFila=3;}
                    if($rowFila['presentacion']=='4imagenes'){$cantElementosPorFila=4;}
                    if(($cArchivos/$cantElementosPorFila)>intval($cArchivos/$cantElementosPorFila)){
                        $cantInsertFormato=intval($cArchivos/$cantElementosPorFila)+1;
                    }else{
                        $cantInsertFormato=$cArchivos/$cantElementosPorFila;
                    }
                }
                
            }
            $c=0;
            for($j=1;$j<=$cantInsertFormato;$j++){
                $htmlFormato.=leerHtmlEnSeccion('formato-'.$rowFila['formato'].'-'.$rowFila['presentacion']).chr(13);
                if($j==1){
                    for($i=1;isset($vTextos[$i]['texto'])==true;$i++){
                        $htmlFormato=str_replace("{texto:$i}",$vTextos[$i]['texto'],$htmlFormato);            
                    }
                }
                if($cArchivos>0){
                    for($i=1;$i<=$cantElementosPorFila;$i++){
                        $c++;
                          
                        if($vArchivos[$c]['id_archivo']!=''){
                            $sql3="
                            	select
                                    tipo,
                                    referencia,
									nombre,
                                    descripcion,
									peso,
									ancho,
									alto
                            	from
                                    archivos
                            	where
                            		id_sistema=".$tra['id_sistema']." and
                            		id_archivo=".$vArchivos[$c]['id_archivo']."
                            ";
                            $db3->set_query($sql3);
                            $db3->execute_query();
                            $rowInfoArchivo=$db3->get_array();
                            
							if(($rowFila['presentacion']=='1descargar')||($rowFila['presentacion']=='2descargar')){
								$link='archivos/'.$rowInfoArchivo['referencia'];
								$imagen='';
								if(($rowInfoArchivo['tipo']=='jpg')||($rowInfoArchivo['tipo']=='png')||($rowInfoArchivo['tipo']=='gif')){
									$link='fuentestra/descargar-imagen.php?referencia=archivos/'.$rowInfoArchivo['referencia'].'&ancho='.$rowInfoArchivo['ancho'].'&alto='.$rowInfoArchivo['alto'];
									$scrollbars=0;
									if($rowInfoArchivo['ancho']>=800){$anchoVentana=800;$scrollbars=1;}else{$anchoVentana=$rowInfoArchivo['ancho'];}
									if($rowInfoArchivo['alto']>=500){$altoVentana=500;$scrollbars=1;}else{$altoVentana=$rowInfoArchivo['alto'];}
									$link.="\" onClick=\"window.open(this.href, '_blank', 'width=".$anchoVentana.",height=".$altoVentana.",scrollbars=".$scrollbars."'); return false;";
									$imagen='fuentestra/imagenes/formatos/32x32/img-'.$rowInfoArchivo['tipo'].'.png';
								}else if($rowInfoArchivo['tipo']=='pdf'){
									$link.="\" onClick=\"window.open(this.href, '_blank', 'width=800,height=500'); return false;";
									$imagen='fuentestra/imagenes/formatos/32x32/pdf.png';
								}else if($rowInfoArchivo['tipo']=='mp3'){
									$imagen='fuentestra/imagenes/formatos/32x32/mp3.png';
								}else if($rowInfoArchivo['tipo']=='zip'){
									$imagen='fuentestra/imagenes/formatos/32x32/zip.png';
								}else if($rowInfoArchivo['tipo']=='rar'){
									$imagen='fuentestra/imagenes/formatos/32x32/rar.png';
								}else if($rowInfoArchivo['tipo']=='txt'){
									$imagen='fuentestra/imagenes/formatos/32x32/txt.png';
								}else if($rowInfoArchivo['tipo']=='exe'){
									$imagen='fuentestra/imagenes/formatos/32x32/exe.png';
								}else if($rowInfoArchivo['tipo']=='yt'){
									$imagen='fuentestra/imagenes/formatos/32x32/you-tube.png';
								}else if(($rowInfoArchivo['tipo']=='doc')||($rowInfoArchivo['tipo']=='docx')){
									$imagen='fuentestra/imagenes/formatos/32x32/word.png';
								}else if(($rowInfoArchivo['tipo']=='xls')||($rowInfoArchivo['tipo']=='xlsx')){
									$imagen='fuentestra/imagenes/formatos/32x32/excel.png';
								}else if(($rowInfoArchivo['tipo']=='ppt')||($rowInfoArchivo['tipo']=='pptx')){
									$imagen='fuentestra/imagenes/formatos/32x32/power-point.png';
								}else if(($rowInfoArchivo['tipo']=='avi')||($rowInfoArchivo['tipo']=='mp4')||($rowInfoArchivo['tipo']=='flv')){
									$imagen='fuentestra/imagenes/formatos/32x32/video.png';
								}else{
									$imagen='fuentestra/imagenes/formatos/32x32/default.png';
								}
								$vistaArchivo='<a href="'.$link.'" title="descargar archivo"><img src="'.$imagen.'"></a>';
							}else if($rowFila['presentacion']=='mp3streaming'){
								
							}else{
								if(($rowInfoArchivo['tipo']=='jpg')||($rowInfoArchivo['tipo']=='png')||($rowInfoArchivo['tipo']=='gif')){
									$vistaArchivo='<a href="javascript:cargarSeccion(\'archivos\',\'ampliar_multimedia\',\'idArchivo='.$vArchivos[$c]['id_archivo'].'\',\'ventana\');"><img src="index.php?o=ima&archivo='.$rowInfoArchivo['referencia'].'&tipo='.$dimesionVistaArchivo[$rowFila['presentacion']]['tipoResize'].'&ancho='.$dimesionVistaArchivo[$rowFila['presentacion']]['ancho'].'&alto='.$dimesionVistaArchivo[$rowFila['presentacion']]['alto'].'&alinear=c" /></a>';
								}else{
									$vistaArchivo='aca la vista previa';
								}
							}
                            $htmlFormato=str_replace("{idArchivo:$i}",$vArchivos[$c]['id_archivo'],$htmlFormato);
                            $htmlFormato=str_replace("{vistaArchivo:$i}",$vistaArchivo,$htmlFormato);
                            if($rowInfoArchivo['nombre']!=''){$rowInfoArchivo['nombre']='<div class="detalleTitulo">'.$rowInfoArchivo['nombre'].'</div>';}
                            $htmlFormato=str_replace("{nombre:$i}",$rowInfoArchivo['nombre'],$htmlFormato);
                            if($rowInfoArchivo['descripcion']!=''){$rowInfoArchivo['descripcion']='<div class="detalle">'.str_replace(chr(10),'<br>',$rowInfoArchivo['descripcion']).'</div>';}
                            $htmlFormato=str_replace("{descripcion:$i}",$rowInfoArchivo['descripcion'],$htmlFormato);
							$htmlFormato=str_replace("{nombreArchivo:$i}",substr($rowInfoArchivo['referencia'],15),$htmlFormato);
							$htmlFormato=str_replace("{nombreArchivoCompleto:$i}",$rowInfoArchivo['referencia'],$htmlFormato);
							$htmlFormato=str_replace("{referencia:$i}",$rowInfoArchivo['referencia'],$htmlFormato);
							$htmlFormato=str_replace("{link:$i}",$link,$htmlFormato);
							$htmlFormato=str_replace("{peso:$i}",number_format($rowInfoArchivo['peso'],2,',','.').' KB',$htmlFormato);
                            $htmlFormato=str_replace("{display:$i}",'',$htmlFormato);
                        }else{
                            $htmlFormato=str_replace("{display:$i}",'display:none;',$htmlFormato);
                        }
                    }
                }   
            }
        }
    }
    
    $htmlFormato=str_replace('{idDocumentoFila}',$idDocumentoFila,$htmlFormato);
    $htmlFormato=str_replace('{formato}',$rowFila['formato'],$htmlFormato);
    
    return $htmlFormato;
}
?>