<?
$tra['id_sistema'] = 1;
if($accionRPC=='adjuntar'){
	if (!empty($_FILES)) {
		$tempFile=$_FILES['Filedata']['tmp_name'];
		$targetPath=$_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
		$nombreArchivo=$_FILES['Filedata']['name'];
		$targetFile=str_replace('//','/',$targetPath).$nombreArchivo;
		move_uploaded_file($tempFile,$targetFile);
		$resp['nombreArchivo']=$nombreArchivo;
	}
}



if($accionRPC=='subirArchivo'){
	if (!empty($_FILES)) {
		$resp['nombreArchivo'] = preparaNombreArchivo($_FILES['Filedata']['name']);
		move_uploaded_file($_FILES['Filedata']['tmp_name'],'archivos/'.$resp['nombreArchivo']);
		
		list($archivo,$extencion)=explode('.',$resp['nombreArchivo']);
		$peso=filesize('archivos/'.$resp['nombreArchivo'])/1024;
		
		$ancho='null';
		$alto='null';
		if(($extencion=='gif')||($extencion=='jpg')||($extencion=='png')||($extencion=='swf')||($extencion=='swc')||($extencion=='psd')||($extencion=='tiff')||($extencion=='bmp')||($extencion=='iff')||($extencion=='jp2')||($extencion=='jpx')||($extencion=='jb2')||($extencion=='jpc')||($extencion=='xbm')||($extencion=='wbmp')){
			list($ancho, $alto)=getimagesize('archivos/'.$resp['nombreArchivo']);
		}
		$sql="
			select login('tra','sn00.pY');
			insert into archivos (
				id_sistema,
				id_archivo,
				id_archivo_categoria,
				tipo,
				referencia,
				peso,
				ancho,
				alto,
				nombre,
				descripcion,
				id_usuario_creo,
				id_usuario_modif
			) values (
				1,
				".obtenerSigId('archivos').",
				null,
				'$extencion',
				'".$resp['nombreArchivo']."',
				$peso,
				$ancho,
				$alto,
				'',
				'',
				1,
				1
			)
		";
		$db->set_query($sql);
		$db->execute_query();
	}	
}

if(($accionRPC=='mostrarArchivoEnEdicionCategoria')||($accionRPC=='preCargarArchivoEnEdicionCategoria')){
	$referencias=recibir_dato('referencias');
	if($accionRPC=='preCargarArchivoEnEdicionCategoria'){
		$v2Referencias=explode(',',$referencias);
		$where='';
		for($i=0;isset($v2Referencias[$i])==true;$i++){
			if($where!=''){$where.=' or ';}
			$where.=' id_archivo='.$v2Referencias[$i].' ';
		}
		$where='('.$where.') ';
		$sql="select * from archivos where 1=1 and $where order by fecha_usuario_creo desc";
		$db->set_query($sql);
		$db->execute_query();
		$referencias='';
		while($row=$db->get_array()){
			if($referencias!=''){$referencias.=',';}
			$referencias.=$row['referencia'];
		}
	}
	$vReferencias=explode(',',$referencias);
	for($i=0;isset($vReferencias[$i])==true;$i++){
		$sql="select * from archivos where 1=1 and referencia='".$vReferencias[$i]."'";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();

		$link='archivos/'.$row['referencia'];
		$imagen='';
		$tamanho=$row['peso'].' KB';
		if(($row['tipo']=='jpg')||($row['tipo']=='png')||($row['tipo']=='gif')){
			$link="javascript:cargarSeccion('archivos','ampliar_multimedia','idArchivo=".$row['id_archivo']."','ventana');";
			$imagen='index.php?o=ima&archivo='.$row['referencia'].'&tipo=2&ancho=70&alto=53';
			$tamanho.='<br>'.$row['ancho'].'x'.$row['alto'];
		}else if($row['tipo']=='pdf'){
			$link.="\" onClick=\"window.open(this.href, '_blank', 'width=800,height=500'); return false;";
			$imagen='fuentestra/imagenes/formatos/32x32/pdf.png';
		}else if($row['tipo']=='mp3'){
			$imagen='fuentestra/imagenes/formatos/32x32/mp3.png';
		}else if($row['tipo']=='zip'){
			$imagen='fuentestra/imagenes/formatos/32x32/zip.png';
		}else if($row['tipo']=='rar'){
			$imagen='fuentestra/imagenes/formatos/32x32/rar.png';
		}else if($row['tipo']=='txt'){
			$imagen='fuentestra/imagenes/formatos/32x32/txt.png';
		}else if($row['tipo']=='exe'){
			$imagen='fuentestra/imagenes/formatos/32x32/exe.png';
		}else if($row['tipo']=='yt'){
			$imagen='fuentestra/imagenes/formatos/32x32/you-tube.png';
		}else if(($row['tipo']=='doc')||($row['tipo']=='docx')){
			$imagen='fuentestra/imagenes/formatos/32x32/word.png';
		}else if(($row['tipo']=='xls')||($row['tipo']=='xlsx')){
			$imagen='fuentestra/imagenes/formatos/32x32/excel.png';
		}else if(($row['tipo']=='ppt')||($row['tipo']=='pptx')){
			$imagen='fuentestra/imagenes/formatos/32x32/power-point.png';
		}else if(($row['tipo']=='avi')||($row['tipo']=='mp4')||($row['tipo']=='flv')){
			$imagen='fuentestra/imagenes/formatos/32x32/video.png';
		}else{
			$imagen='fuentestra/imagenes/formatos/32x32/default.png';
		}
		
		if(($row['tipo']=='jpg')||($row['tipo']=='png')||($row['tipo']=='gif')||($row['tipo']=='flv')||($row['tipo']=='pdf')){
			$displayPropiedades='';
		}else{
			$displayPropiedades='display:none;';
		}
		
		$resp['html'].=leerHtmlEnSeccion('datos-archivo-en-edicion-categoria').chr(13);
		$resp['html']=str_replace('{idArchivo}',$row['id_archivo'],$resp['html']);
		$resp['html']=str_replace('{enlace}',$link,$resp['html']);
		$resp['html']=str_replace('{vistaPrevia}','<img src="'.$imagen.'">',$resp['html']);
		$resp['html']=str_replace('{tipo}',$row['tipo'],$resp['html']);
		$resp['html']=str_replace('{nombre}',substr($row['referencia'],15),$resp['html']);
		$resp['html']=str_replace('{tamanho}',$tamanho,$resp['html']);
		$resp['html']=str_replace('{displayPropiedades}',$displayPropiedades,$resp['html']);
	}
}

if($accionRPC=='insertarCategoria'){
	$nombreCategoria=recibir_dato('nombreCategoria','post');
	$sql="select id_archivo_categoria from archivo_categorias where 1=1 and archivo_categoria='$nombreCategoria'";
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		$resp['mensaje']='Ya existe una categoria denominada '.$nombreCategoria;	
	}else{
		$sql="
			insert into archivo_categorias (
				
				id_archivo_categoria,
				archivo_categoria,
				id_usuario_creo,
				id_usuario_modif
			) values (
				
				".obtenerSigId('archivo_categorias').",
				'$nombreCategoria',
				".$tra['id_usuario'].",
				".$tra['id_usuario']."
			)
		";
		$db->set_query($sql);
		$db->execute_query();
	}
}

if($accionRPC=='editarCategoria'){
	$id=recibir_dato('id','post');
	$nombreCategoria=recibir_dato('nombreCategoria','post');
	$sql="select id_archivo_categoria from archivo_categorias where 1=1 and archivo_categoria='$nombreCategoria' and id_archivo_categoria<>$id";
	$db->set_query($sql);
	$db->execute_query();
	if($row=$db->get_array()){
		$resp['mensaje']='Ya existe otra categoria denominada '.$nombreCategoria;	
	}else{
		$sql="
			update
				archivo_categorias
			set
				archivo_categoria='$nombreCategoria',
				id_usuario_modif=".$tra['id_usuario']."
			where
				1=1 and
				id_archivo_categoria=$id
		";
		$db->set_query($sql);
		$db->execute_query();
	}
}

if($accionRPC=='listarCategorias'){
	$matriz[0][]=array("html" => "&nbsp;" ,"width" => '16px');
	$matriz[0][]=array("html" => "&nbsp;" ,"width" => '16px');
	$matriz[0][]=array("html" => "Categoria" ,"width" => '*');
	$sql="select id_archivo_categoria, archivo_categoria from archivo_categorias where 1=1 order by archivo_categoria";
	$db->set_query($sql);
	$db->execute_query();
	$c=0;
	while($row=$db->get_array()){
		$c++;
		$matriz[$c][]['html']='<a href="javascript:agregarEditarCategoriaArchivo('.$row['id_archivo_categoria'].');" title="editar"><img src="fuentestra/imagenes/bot/16x16/edit.png"></a>';
		$matriz[$c][]['html']='<a href="javascript:eliminarCategoriaArchivo('.$row['id_archivo_categoria'].');" title="eliminar"><img src="fuentestra/imagenes/bot/16x16/delete.png"></a>';
		$matriz[$c][]['html']=$row['archivo_categoria'];
	}
	$resp['html']=armarLista($matriz);
}

if($accionRPC=='eliminarCategoria'){
	$id=recibir_dato('id');
	$sql="delete from archivo_categorias where 1=1 and id_archivo_categoria=$id";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='cargarSelectCategoriasArchivo'){
	$sql="select id_archivo_categoria, archivo_categoria from archivo_categorias where 1=1 order by archivo_categoria";
	$db->set_query($sql);
	$db->execute_query();
	$resp['html'].='<option id=""></option>'.chr(13);
	while($row=$db->get_array()){
		$resp['html'].='<option id="'.$row['id_archivo_categoria'].'" value="'.$row['id_archivo_categoria'].'">'.$row['archivo_categoria'].'</option>'.chr(13);
	}
}

if($accionRPC=='editarCategorizacionArchivo'){
	
	//print_r($_REQUEST);
	$idArchivos=recibir_dato('idArchivos');
	$idArchivoCategoria=recibir_dato('idArchivoCategoria');
	$aplicarCategoria=recibir_dato('aplicarCategoria');
	$nombre=recibir_dato('nombre');
	$aplicarNombre=recibir_dato('aplicarNombre');
	$descripcion=recibir_dato('descripcion');
	$aplicarDescripcion=recibir_dato('aplicarDescripcion');
	$fecha=recibir_dato('fecha');
	$aplicarFecha=recibir_dato('aplicarFecha');
	$palabrasClaves=recibir_dato('palabrasClaves');
	$aplicarPalabrasClaves=recibir_dato('aplicarPalabrasClaves');
	$firma=recibir_dato('firma');
	$aplicarFirma=recibir_dato('aplicarFirma');
	if(($aplicarCategoria=='true')||($aplicarNombre=='true')||($aplicarDescripcion=='true')||($aplicarFecha=='true')||($aplicarPalabrasClaves=='true')||($aplicarFirma=='true')){
		$update='';
		if($aplicarCategoria=='true'){
			if($idArchivoCategoria==''){
				$update.='id_archivo_categoria=null';
			}else{
				$update.='id_archivo_categoria='.$idArchivoCategoria;
			}
		}
		if($aplicarNombre=='true'){
			if($update!=''){$update.=', ';}
			$update.="nombre='".$nombre."'";
		}
		if($aplicarDescripcion=='true'){
			if($update!=''){$update.=', ';}
			$update.="descripcion='".$descripcion."'";
		}
		if($aplicarFecha=='true'){
			if($update!=''){$update.=', ';}
			if($fecha==''){
				$update.="fecha_archivo=null";
			}else{
				$update.="fecha_archivo='".$fecha."'";
			}
		}
		if($aplicarPalabrasClaves=='true'){
			if($update!=''){$update.=', ';}
			$update.="palabras_claves='".$palabrasClaves."'";
		}
		if($aplicarFirma=='true'){
			if($update!=''){$update.=', ';}
			if($firma==''){
				$firma='false';
			}
			$update.="firma=$firma";
		}
		$vArchivos=explode(',',$idArchivos);
		//echo "idArchivos: " . $idArchivos . "<br/>";
		//echo "vArchivos: <br/>";
		//print_r($vArchivos);
		for($i=0;isset($vArchivos[$i])==true;$i++){
			$sql="update archivos set $update where 1=1 and id_archivo=".$vArchivos[$i];
			$db->set_query($sql);
			$db->execute_query();
		}
	}
}

if($accionRPC=='listadoGralArchivos'){
	$cadenaBuscar=recibir_dato('cadenaBuscar');
	$cantRegLista=recibir_dato('cantRegLista');
	if($cantRegLista==''){$cantRegLista=0;}
	
	$archivosPreSeleccionados=recibir_dato('archivosPreSeleccionados');
	$vArchivosPreSeleccionados=explode(',',$archivosPreSeleccionados);
	for($i=0;isset($vArchivosPreSeleccionados[$i])==true;$i++){
		$idCatPreSeleccionado[$vArchivosPreSeleccionados[$i]]=true;
	}
	
	if($cadenaBuscar!=''){
		$vCadBuscar=explode('+',$cadenaBuscar);
		$whereFiltro=" and (";
		for($i=0;isset($vCadBuscar[$i]);$i++){
			$vCadBuscar[$i]=trim($vCadBuscar[$i]);
			if($i>0){$whereFiltro.=" and ";}
			$whereFiltro.="
				(
					sp_ascii(cat.archivo_categoria) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(arch.nombre) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(arch.palabras_claves) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(arch.descripcion) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(arch.referencia) ilike sp_ascii('%".$vCadBuscar[$i]."%')
				) 
			";
		}
		$whereFiltro.=" ) ";
	}else{
		$whereFiltro='';	
	}
	
	$sql="
		select
			arch.*,
			cat.archivo_categoria
		from
			archivos arch
			left join archivo_categorias cat on (cat.id_archivo_categoria=arch.id_archivo_categoria and 1=1)
		where 
			1=1 
			$whereFiltro
		order by
			arch.fecha_usuario_creo desc
		offset
			$cantRegLista
		limit
			10
	";
	$db->set_query($sql);
	$db->execute_query();
	if($cantRegLista==0){
		$resp['html']=leerHtmlEnSeccion('listadoGralArchivos-tabla').chr(13);
	}else{
		$resp['html']='{filas}';
	}
	$htmlFilas='';
	$c=$cantRegLista;
	$c2=0;
	while($row=$db->get_array()){
		$c++;
		$c2++;
		$link='archivos/'.$row['referencia'];
		$imagen='';
		$detalle=number_format($row['peso'],2,',','.').' KB';
		if(($row['tipo']=='jpg')||($row['tipo']=='png')||($row['tipo']=='gif')){
			$link="javascript:cargarSeccion('archivos','ampliar_multimedia','idArchivo=".$row['id_archivo']."','ventana');";
			$imagen='index.php?o=ima&archivo='.$row['referencia'].'&tipo=2&ancho=70&alto=53';
			$detalle.='<br>'.$row['ancho'].'x'.$row['alto'];
			if($row['firma']=='t'){
				$detalle.='<br>con firma';
			}
		}else if($row['tipo']=='pdf'){
			$link.="\" onClick=\"window.open(this.href, '_blank', 'width=800,height=500'); return false;";
			$imagen='fuentestra/imagenes/formatos/32x32/pdf.png';
		}else if($row['tipo']=='mp3'){
			$imagen='fuentestra/imagenes/formatos/32x32/mp3.png';
		}else if($row['tipo']=='zip'){
			$imagen='fuentestra/imagenes/formatos/32x32/zip.png';
		}else if($row['tipo']=='rar'){
			$imagen='fuentestra/imagenes/formatos/32x32/rar.png';
		}else if($row['tipo']=='txt'){
			$imagen='fuentestra/imagenes/formatos/32x32/txt.png';
		}else if($row['tipo']=='exe'){
			$imagen='fuentestra/imagenes/formatos/32x32/exe.png';
		}else if($row['tipo']=='yt'){
			$imagen='fuentestra/imagenes/formatos/32x32/you-tube.png';
		}else if(($row['tipo']=='doc')||($row['tipo']=='docx')){
			$imagen='fuentestra/imagenes/formatos/32x32/word.png';
		}else if(($row['tipo']=='xls')||($row['tipo']=='xlsx')){
			$imagen='fuentestra/imagenes/formatos/32x32/excel.png';
		}else if(($row['tipo']=='ppt')||($row['tipo']=='pptx')){
			$imagen='fuentestra/imagenes/formatos/32x32/power-point.png';
		}else if(($row['tipo']=='avi')||($row['tipo']=='mp4')||($row['tipo']=='flv')){
			$imagen='fuentestra/imagenes/formatos/32x32/video.png';
		}else{
			$imagen='fuentestra/imagenes/formatos/32x32/default.png';
		}
		
		if($cadenaBuscar!=''){
			$row['archivo_categoria']=resaltarCadena($cadenaBuscar,$row['archivo_categoria']);
			$row['nombre']=resaltarCadena($cadenaBuscar,$row['nombre']);
			$row['palabras_claves']=resaltarCadena($cadenaBuscar,$row['palabras_claves']);
			$row['descripcion']=resaltarCadena($cadenaBuscar,$row['descripcion']);
			$row['referencia']=resaltarCadena($cadenaBuscar,$row['referencia']);
		}
		
		if($row['nombre']!=''){
			$row['nombre']='<b>'.$row['nombre'].'</b>';
			if($row['descripcion']!=''){
				$row['nombre'].=': ';
			}
		}
		
		$htmlFilas.=leerHtmlEnSeccion('listadoGralArchivos-fila').chr(13);
		$htmlFilas=str_replace('{idArchivo}',$row['id_archivo'],$htmlFilas);
		$htmlFilas=str_replace('{enlace}',$link,$htmlFilas);
		$htmlFilas=str_replace('{vistaPrevia}','<img src="'.$imagen.'">',$htmlFilas);
		$htmlFilas=str_replace('{tipo}',$row['tipo'],$htmlFilas);
		$htmlFilas=str_replace('{nombreExtenso}',$row['referencia'],$htmlFilas);
		$htmlFilas=str_replace('{referencia}',str_replace('_',' ',str_replace('-',' ',substr($row['referencia'],15))),$htmlFilas);
		$htmlFilas=str_replace('{categoria}',$row['archivo_categoria'],$htmlFilas);
		$htmlFilas=str_replace('{palabrasClaves}',$row['palabras_claves'],$htmlFilas);
		$htmlFilas=str_replace('{nombre}',$row['nombre'],$htmlFilas);
		$htmlFilas=str_replace('{descripcion}',$row['descripcion'],$htmlFilas);
		$htmlFilas=str_replace('{fecha}',$row['fecha_archivo'],$htmlFilas);
		$htmlFilas=str_replace('{detalle}',$detalle,$htmlFilas);
		$htmlFilas=str_replace('{adjuntado}',formatear_fecha($row['fecha_usuario_creo'],'d/M/Y*<br>*H:i *Hs.*'),$htmlFilas);

		if(isset($idCatPreSeleccionado[$row['id_archivo']])==true){
			$htmlFilas=str_replace('<input name="idArchivoListaGral" value="'.$row['id_archivo'].'" type="checkbox" title="seleccionar" />','<img src="fuentestra/imagenes/bot/16x16/accept.png" title="archivo seleccionado" />',$htmlFilas);
		}
	}
	if($c==0){
		$htmlFilas='<tr><td colspan="8">No se registra ningún archivo</td></tr>';
	}
	if($c2==10){
		$resp['masArchivos']='SI';
	}else{
		$resp['masArchivos']='NO';
	}
	$resp['html']=str_replace('{filas}',$htmlFilas,$resp['html']);
	$resp['cantRegLista']=$c;
}

if($accionRPC=='calcularEspacioUtilizado'){
	$sql="select sum(peso) as total from archivos where 1=1";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	$resp['html']=number_format($row['total']/1024,2,',','.').' MB';
}

if($accionRPC=='eliminarArchivos'){
	$idsArchivos=recibir_dato('idsArchivos');
	$cantEliminados=0;
	if($idsArchivos!=''){
		$vIdArchivo=explode(',',$idsArchivos);
		for($i=0;isset($vIdArchivo[$i])==true;$i++){
			$sql="select referencia from archivos where 1=1 and id_archivo=".$vIdArchivo[$i];
			$db->set_query($sql);
			$db->execute_query();
			$row=$db->get_array();
			unlink('archivos/'.$row['referencia']);

			$sql="delete from archivos where 1=1 and id_archivo=".$vIdArchivo[$i];
			$db->set_query($sql);
			$db->execute_query();
			
			$cantEliminados++;
		}
	}
	$resp['cantEliminados']=$cantEliminados;
}

if($accionRPC=='agregarListadoRelArchivos'){
	$cListaRelArchivos=recibir_dato('cListaRelArchivos','post',0);
	$idsArchivos=recibir_dato('idsArchivos');
	$vIdArchivo=explode(',',$idsArchivos);
	for($i=0;isset($vIdArchivo[$i])==true;$i++){
		$sql="
			select
				arch.*,
				cat.archivo_categoria
			from
				archivos arch
				left join archivo_categorias cat on (cat.id_archivo_categoria=arch.id_archivo_categoria and 1=1)
			where 
				1=1 
				and arch.id_archivo=".$vIdArchivo[$i]."
			order by
				arch.fecha_usuario_creo desc
		";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();

		$link='archivos/'.$row['referencia'];
		$imagen='';
		$detalle=number_format($row['peso'],2,',','.').' KB';
		if(($row['tipo']=='jpg')||($row['tipo']=='png')||($row['tipo']=='gif')){
			$link="javascript:cargarSeccion('archivos','ampliar_multimedia','idArchivo=".$row['id_archivo']."','ventana');";
			$imagen='index.php?o=ima&archivo='.$row['referencia'].'&tipo=2&ancho=70&alto=53';
			$detalle.='<br>'.$row['ancho'].'x'.$row['alto'];
			if($row['firma']=='t'){
				$detalle.='<br>con firma';
			}
		}else if($row['tipo']=='pdf'){
			$link.="\" onClick=\"window.open(this.href, '_blank', 'width=800,height=500'); return false;";
			$imagen='fuentestra/imagenes/formatos/32x32/pdf.png';
		}else if($row['tipo']=='mp3'){
			$imagen='fuentestra/imagenes/formatos/32x32/mp3.png';
		}else if($row['tipo']=='zip'){
			$imagen='fuentestra/imagenes/formatos/32x32/zip.png';
		}else if($row['tipo']=='rar'){
			$imagen='fuentestra/imagenes/formatos/32x32/rar.png';
		}else if($row['tipo']=='txt'){
			$imagen='fuentestra/imagenes/formatos/32x32/txt.png';
		}else if($row['tipo']=='exe'){
			$imagen='fuentestra/imagenes/formatos/32x32/exe.png';
		}else if($row['tipo']=='yt'){
			$imagen='fuentestra/imagenes/formatos/32x32/you-tube.png';
		}else if(($row['tipo']=='doc')||($row['tipo']=='docx')){
			$imagen='fuentestra/imagenes/formatos/32x32/word.png';
		}else if(($row['tipo']=='xls')||($row['tipo']=='xlsx')){
			$imagen='fuentestra/imagenes/formatos/32x32/excel.png';
		}else if(($row['tipo']=='ppt')||($row['tipo']=='pptx')){
			$imagen='fuentestra/imagenes/formatos/32x32/power-point.png';
		}else if(($row['tipo']=='avi')||($row['tipo']=='mp4')||($row['tipo']=='flv')){
			$imagen='fuentestra/imagenes/formatos/32x32/video.png';
		}else{
			$imagen='fuentestra/imagenes/formatos/32x32/default.png';
		}
		
		if($row['nombre']!=''){
			if($row['descripcion']!=''){
				$row['descripcion']='<b>'.$row['nombre'].':</b> '.$row['descripcion'];
			}else{
				$row['descripcion']='<b>'.$row['nombre'].'</b>';
			}
		}
		
		$descripcion=$row['descripcion'];
		if($descripcion==''){
			$descripcion='sin descripción';
		}
		$descripcionResumen=$descripcion;
		if(strlen($descripcionResumen)>60){
			$descripcionResumen=substr($descripcionResumen,0,60).'...';
		}
		$cListaRelArchivos++;
		$htmlFila=leerHtmlEnSeccion('fila-rel-archivo').chr(13);
		$htmlFila=str_replace('{c}',$cListaRelArchivos,$htmlFila);
		$htmlFila=str_replace('{idArchivo}',$row['id_archivo'],$htmlFila);
		$htmlFila=str_replace('{enlace}',$link,$htmlFila);
		$htmlFila=str_replace('{vistaPrevia}','<img src="'.$imagen.'">',$htmlFila);
		$htmlFila=str_replace('{nombreExtenso}',$row['referencia'],$htmlFila);
		$htmlFila=str_replace('{descripcion}',$descripcion,$htmlFila);
		$htmlFila=str_replace('{descripcionResumen}',$descripcionResumen,$htmlFila);
		$htmlFila=str_replace('{detalle}',$detalle,$htmlFila);
		$resp['htmlArchivo'.$cListaRelArchivos]=$htmlFila;
		$resp['idArchivo'.$cListaRelArchivos]=$row['id_archivo'];
	}
	$resp['cListaRelArchivos']=$cListaRelArchivos;
}

if($accionRPC=='aplicarPropiedadesArchivo'){
	$idArchivo = recibir_dato('idArchivo');
	$idArchivoVistaPrevia = recibir_dato('idArchivoVistaPrevia');
	$enlace = recibir_dato('enlace');
	$permitirDescargar = recibir_dato('permitirDescargar');
	$ampliar = recibir_dato('ampliar');
	$firma = recibir_dato('firma');

	if($idArchivoVistaPrevia==''){
		$idArchivoVistaPrevia='null';
	}

	$sql="
		update
			archivos
		set
			id_archivo_vista_previa=$idArchivoVistaPrevia,
			enlace='$enlace',
			permitir_descargar=$permitirDescargar,
			ampliar='$ampliar',
			firma_tipo='$firma',
			id_usuario_modif=".$tra['id_usuario'].",
			fecha_usuario_modif=now()
		where
			1=1 and
			id_archivo=$idArchivo
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
}

if($accionRPC=='listarImagenesSeleccionarUnaImagen'){
	$cadenaBuscar=recibir_dato('cadenaBuscar');
	$cantElementosExistentes=recibir_dato('cantElementosExistentes','request',0);
	$cantElementosNuevos=10;
	
	$c=0;	$matrizListado[0][$c]['html']='&nbsp;';			$matrizListado[0][$c]['width']=16;		$matrizListado[0][$c]['style']='text-align:center;';
	$c++;	$matrizListado[0][$c]['html']='Vista';			$matrizListado[0][$c]['width']=70;		$matrizListado[0][$c]['style']='text-align:center;';
	$c++;	$matrizListado[0][$c]['html']='Nombre archivo';	$matrizListado[0][$c]['width']=150;		$matrizListado[0][$c]['style']='';
	$c++;	$matrizListado[0][$c]['html']='Descripción';	$matrizListado[0][$c]['width']=400;		$matrizListado[0][$c]['style']='';
	
	if($cadenaBuscar!=''){
		$vCadBuscar=explode('+',$cadenaBuscar);
		$whereFiltro=" and (";
		for($i=0;isset($vCadBuscar[$i]);$i++){
			$vCadBuscar[$i]=trim($vCadBuscar[$i]);
			if($i>0){$whereFiltro.=" and ";}
			
			$whereFiltro.="
				(
					sp_ascii(referencia) ilike '%".$vCadBuscar[$i]."%' or 
					sp_ascii(descripcion) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(palabras_claves) ilike sp_ascii('%".$vCadBuscar[$i]."%')
				) 
			";
		}
		$whereFiltro.=" ) ";
	}else{
		$whereFiltro='';	
	}
	
	$sql="
		select
			id_archivo,
			referencia,
			descripcion,
			palabras_claves
		from
			archivos
		where
			1=1 and
			(tipo='jpg' or tipo='gif' or tipo='png')
			$whereFiltro
		order by
			id_usuario_creo desc
		offset
			$cantElementosExistentes
		limit
			$cantElementosNuevos
	";
	$db->set_query($sql);
	$db->execute_query();
	$c=0;
	while($row=$db->get_array()){
		$c++;
		
		if($cadenaBuscar!=''){
			$row['referencia']=resaltarCadena($cadenaBuscar,$row['referencia']);
			$row['descripcion']=resaltarCadena($cadenaBuscar,$row['descripcion']);
			$row['palabras_claves']=resaltarCadena($cadenaBuscar,$row['palabras_claves']);
		}
		
		$matrizListado[$c][]['html']='<a href="javascript:seleccionarArchivoParaVistaPrevia('.$row['id_archivo'].');" title="editar"><img src="fuentestra/imagenes/bot/16x16/pin.png" /></a>';
		$matrizListado[$c][]['html']='<a href="javascript:cargarSeccion(\'archivos\',\'ampliar_multimedia\',\'idArchivo='.$row['id_archivo'].'\',\'ventana\');" title="ampliar imágen"><img src="index.php?o=ima&archivo='.$row['referencia'].'&tipo=2&ancho=70&alto=53"></a>';
		$matrizListado[$c][]['html']=substr($row['referencia'],15);
		$matrizListado[$c][]['html']=$row['descripcion'].'<br><i>'.$row['palabras_claves'].'</i>';
	}
	$resp['html']=armarLista($matrizListado,$cantElementosExistentes,$cantElementosNuevos);
}

if($accionRPC=='mostrarVistaPreviaDeArchivoVinculado'){
	$idArchivo = recibir_dato('idArchivo');
	if($idArchivo!=''){
		$sql="
			select
				referencia
			from
				archivos
			where
				1=1 and
				id_archivo=$idArchivo
		";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();	
		$resp['html']='
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="16"><a href="javascript:desvincularImagenVistaPrevia();" title="desvicular vista previa"><img src="fuentestra/imagenes/bot/16x16/delete.png" /></a></td>
				<td width="*"><a href="javascript:cargarSeccion(\'archivos\',\'ampliar_multimedia\',\'idArchivo='.$idArchivo.'\',\'ventana\');" title="ampliar imágen"><img src="index.php?o=ima&archivo='.$row['referencia'].'&tipo=2&ancho=120&alto=120" /></a></td>
			</tr>
		</table>
		';
	}else{
		$resp['html']='';
	}
}
?>