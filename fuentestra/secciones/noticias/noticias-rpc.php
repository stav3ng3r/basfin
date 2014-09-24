<?
if(($accionRPC=='insertarNoticia')||($accionRPC=='editarNoticia')){	
	$idNoticia = recibir_dato('idNoticia');
	$fechaHora = recibir_dato('fechaHora');
	$titular = recibir_dato('titular');
	$antetitulo = recibir_dato('antetitulo');
	$entradilla = recibir_dato('entradilla');
	$cuerpo = recibir_dato('cuerpo');
	$permitirComentar = recibir_dato('permitirComentar');
	$publicado = recibir_dato('publicado');
	$idsArchivos = recibir_dato('idsArchivos');
	$idsCategorias = recibir_dato('idsCategorias');
	$idsNoticiasRelacionadas = recibir_dato('idsNoticiasRelacionadas');
	
	$titular = str_replace("'",chr(92)."'",$titular);
	$antetitulo = str_replace("'",chr(92)."'",$antetitulo);
	$entradilla = str_replace("'",chr(92)."'",$entradilla);
	$cuerpo = str_replace("'",chr(92)."'",$cuerpo);
	
	$fechaHora=substr($fechaHora,6,4).'-'.substr($fechaHora,3,2).'-'.substr($fechaHora,0,2).' '.substr($fechaHora,11,5);
	if($accionRPC=='insertarNoticia'){
		$idNoticia=obtenerSigId('noticias');
		$resp['idNoticia']=$idNoticia;
		$sql="
			insert into noticias (
				id_sistema,
				id_noticia,
				fecha_noticia,
				titular,
				antetitulo,
				entradilla,
				cuerpo,
				permitir_comentar,
				estado,
				id_usuario_creo,
				id_usuario_modif
			)values (
				".$tra['id_sistema'].",
				$idNoticia,
				'$fechaHora',
				'".$titular."',
				'".$antetitulo."',
				'".$entradilla."',
				'".$cuerpo."',
				$permitirComentar,
				$publicado,
				".$tra['id_usuario'].",
				".$tra['id_usuario']."
			)
		";
		$db->set_query($sql);
		$db->execute_query();
	}
	if($accionRPC=='editarNoticia'){
		$sql="
			update
				noticias 
			set
				fecha_noticia='$fechaHora',
				titular='$titular',
				antetitulo='$antetitulo',
				entradilla='$entradilla',
				cuerpo='$cuerpo',
				permitir_comentar=$permitirComentar,
				estado=$publicado,
				id_usuario_modif=".$tra['id_usuario']."
			where
				id_sistema=".$tra['id_sistema']." and
				id_noticia=$idNoticia
		";
		$db->set_query($sql);
		$db->execute_query();
		
		$sql="delete from noticia_rel_noticia_categoria where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
		$db->set_query($sql);
		$db->execute_query();
		
		$sql="delete from noticia_archivos where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
		$db->set_query($sql);
		$db->execute_query();
		
		$sql="delete from noticia_relacionadas where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
		$db->set_query($sql);
		$db->execute_query();
	}
	if($idsArchivos!=''){
		$vIdsArchivos = explode(',',$idsArchivos);
		for($i=0;isset($vIdsArchivos[$i])==true;$i++){
			$sql="
				insert into noticia_archivos (
					id_sistema,
					id_noticia,
					id_archivo,
					orden
				) values (
					".$tra['id_sistema'].",
					$idNoticia,
					".$vIdsArchivos[$i].",
					".($i+1)."
				)
			";
			$db->set_query($sql);
			$db->execute_query();
		}
	}
	
	if($idsCategorias!=''){
		$vIdsCategorias = explode(',',$idsCategorias);
		for($i=0;isset($vIdsCategorias[$i])==true;$i++){
			$sql="
				insert into noticia_rel_noticia_categoria (
					id_sistema,
					id_noticia,
					id_noticia_categoria,
					orden
				) values (
					".$tra['id_sistema'].",
					$idNoticia,
					".$vIdsCategorias[$i].",
					".($i+1)."
				)
			";
			$db->set_query($sql);
			$db->execute_query();
		}
	}
	
	if($idsNoticiasRelacionadas!=''){
		$vIdsNoticiasRelacionadas = explode(',',$idsNoticiasRelacionadas);
		for($i=0;isset($vIdsNoticiasRelacionadas[$i])==true;$i++){
			$sql="
				insert into noticia_relacionadas (
					id_sistema,
					id_noticia,
					id_noticia_relacionada
				) values (
					".$tra['id_sistema'].",
					$idNoticia,
					".$vIdsNoticiasRelacionadas[$i]."
				)
			";
			$db->set_query($sql);
			$db->execute_query();
		}
	}
}

if($accionRPC=='eliminarNoticia'){
	$idNoticia=recibir_dato('idNoticia');

	$sql="delete from noticia_rel_noticia_categoria where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
	$db->set_query($sql);
	$db->execute_query();
	
	$sql="delete from noticia_archivos where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
	$db->set_query($sql);
	$db->execute_query();
	
	$sql="delete from noticia_relacionadas where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
	$db->set_query($sql);
	$db->execute_query();
	
	$sql="delete from noticias where id_sistema=".$tra['id_sistema']." and id_noticia=$idNoticia";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='listarNoticias'){
	$cadenaBuscar=recibir_dato('cadenaBuscar');
	$idCat=recibir_dato('idCat');
	$desde=recibir_dato('desde');
	$hasta=recibir_dato('hasta');
	$cantReg=recibir_dato('cantReg');
	$cantMuestra=10;
	
	if($cantReg==''){$cantReg=0;}
	
	if($cadenaBuscar!=''){
		$vCadBuscar=explode('+',$cadenaBuscar);
		$whereFiltro=" and (";
		for($i=0;isset($vCadBuscar[$i]);$i++){
			$vCadBuscar[$i]=trim($vCadBuscar[$i]);
			if($i>0){$whereFiltro.=" and ";}
			$whereFiltro.="
				(
					sp_ascii(n.titular) ilike sp_ascii('%".$vCadBuscar[$i]."%') or 
					sp_ascii(n.entradilla) ilike sp_ascii('%".$vCadBuscar[$i]."%')
				) 
			";
		}
		$whereFiltro.=" ) ";
	}else{
		$whereFiltro='';	
	}
	
	if($desde!=''){
		$whereFiltro.=' and (n.fecha_noticia>=\''.pasarFormatoBd($desde).' 00:00:00\')';
	}
	if($hasta!=''){
		$whereFiltro.=' and (n.fecha_noticia<=\''.pasarFormatoBd($hasta).' 23:59:59\')';
	}
	
	if($idCat==''){
		$sql="
		select
			n.id_noticia,
			n.titular,
			n.antetitulo,
			n.entradilla,
			n.permitir_comentar,
			n.fecha_noticia,
			n.estado,
			(
				select 
					a.referencia
				from 
					noticia_archivos na
					join archivos a on (a.id_sistema=na.id_sistema and a.id_archivo=na.id_archivo)
				where
					na.id_sistema=".$tra['id_sistema']." and na.id_noticia=n.id_noticia and (a.tipo='jpg' or a.tipo='gif' or a.tipo='png' or a.tipo='flv' or a.tipo='mp3')
				order by
					na.orden asc
				limit 1
			) as archivo_referencia
		from 
			noticias n
		where 
			id_sistema=".$tra['id_sistema']." 
			$whereFiltro
		order by
			fecha_noticia desc
		offset
			$cantReg
		limit
			$cantMuestra
		";
	}else{
		$sql="
		select
			n.id_noticia,
			n.titular,
			n.antetitulo,
			n.entradilla,
			n.permitir_comentar,
			n.fecha_noticia,
			n.estado,
			(
				select 
					a.referencia
				from 
					noticia_archivos na
					join archivos a on (a.id_sistema=na.id_sistema and a.id_archivo=na.id_archivo)
				where
					na.id_sistema=".$tra['id_sistema']." and na.id_noticia=n.id_noticia and (a.tipo='jpg' or a.tipo='gif' or a.tipo='png' or a.tipo='flv' or a.tipo='mp3')
				order by
					na.orden asc
				limit 1
			) as archivo_referencia
		from 
			noticias n
			join noticia_rel_noticia_categoria rel on (rel.id_sistema=n.id_sistema and rel.id_noticia=n.id_noticia)
		where 
			n.id_sistema=".$tra['id_sistema']." and
			rel.id_noticia_categoria=$idCat
			$whereFiltro
		order by
			n.fecha_noticia desc
		offset
			$cantReg
		limit
			$cantMuestra
		";
	}
	$db->set_query($sql);
	$db->execute_query();
	$htmlLista='';
	$c=$cantReg;
	$c2=0;
	while($row=$db->get_array()){
		$c++;
		$c2++;
		if($row['archivo_referencia']!=''){
			$htmlLista.=leerHtmlEnSeccion('lista-noticia-con-multimedia').chr(13);
							
			$sql2="select tipo, id_archivo_vista_previa from archivos where id_sistema=".$tra['id_sistema']." and referencia='".utf8_encode($row['archivo_referencia'])."'";
			$db2->set_query($sql2);
			$db2->execute_query();
			$row2=$db2->get_array();
			
			if(($row2['tipo']=='jpg')||($row2['tipo']=='gif')||($row2['tipo']=='png')){
				$multimedia='index.php?o=ima&archivo='.$row['archivo_referencia'].'&tipo=2&ancho=107&alto=80';
			}
			if($row2['tipo']=='flv'){
				if($row2['id_archivo_vista_previa']==''){
					$multimedia='index.php?o=ima&archivo=&tipo=2&ancho=107&alto=80&icon=video';
				}else{
					$sql3="select referencia from archivos where id_sistema=".$tra['id_sistema']." and id_archivo=".$row2['id_archivo_vista_previa'];
					$db3->set_query($sql3);
					$db3->execute_query();
					$row3=$db3->get_array();
					$multimedia='index.php?o=ima&archivo='.$row3['referencia'].'&tipo=2&ancho=107&alto=80&icon=video';
				}
			}

			$htmlLista=str_replace('{multimedia}',$multimedia,$htmlLista);
		}else{
			$htmlLista.=leerHtmlEnSeccion('lista-noticia-sin-multimedia').chr(13);
		}

		$sql2="
		select
			nc.noticia_categoria
		from 
			noticia_rel_noticia_categoria rel
			join noticia_categorias nc on (nc.id_sistema=rel.id_sistema and rel.id_noticia_categoria=nc.id_noticia_categoria)
		where 
			rel.id_sistema=".$tra['id_sistema']." and rel.id_noticia=".$row['id_noticia']."
		order by
			nc.noticia_categoria asc
		";
		$db2->set_query($sql2);
		$db2->execute_query();
		$categorias='';
		while($row2=$db2->get_array()){
			if($row2['noticia_categoria'][0]!='.'){
				if($categorias!=''){$categorias.=', ';}
				$categorias.=$row2['noticia_categoria'];
			}
		}

		$sql2="
			select
				n.id_noticia,
				n.titular,
				n.fecha_noticia
			from
				noticia_relacionadas rel
				join noticias n on (n.id_sistema=rel.id_sistema and rel.id_noticia_relacionada=n.id_noticia)
			where
				rel.id_sistema=".$tra['id_sistema']." and
				rel.id_noticia=".$row['id_noticia']."
			order by
				n.fecha_noticia desc
		";
		$db2->set_query($sql2);
		$db2->execute_query();
		$htmlNoticiasRelacionadas='';
		while($row2=$db2->get_array()){
			$htmlNoticiasRelacionadas.="<li><a href=\"javascript:cargarSeccion('noticias','extenso','idNoticia=".$row2['id_noticia']."','ventana');\">".$row2['titular']." (".$row2['fecha_noticia'].")</a></li>".chr(13);
		}
		if($htmlNoticiasRelacionadas!=''){
			$htmlNoticiasRelacionadas='
				<div class="tituloRelacionadas">Noticias relacionadas</div>
				<div class="noticiaRelacionada">'.$htmlNoticiasRelacionadas.'</div>
			';
		}

		if($cadenaBuscar!=''){
			$row['titular']=resaltarCadena($cadenaBuscar,$row['titular']);
			$row['entradilla']=resaltarCadena($cadenaBuscar,$row['entradilla']);
		}
		
		$htmlLista=str_replace('{idNoticia}',$row['id_noticia'],$htmlLista);
		$htmlLista=str_replace('{fecha}',$row['fecha_noticia'],$htmlLista);
		$htmlLista=str_replace('{categorias}',$categorias,$htmlLista);
		$htmlLista=str_replace('{antetitulo}',$row['antetitulo'],$htmlLista);
		$htmlLista=str_replace('{titular}',$row['titular'],$htmlLista);
		$htmlLista=str_replace('{entradilla}',$row['entradilla'],$htmlLista);
		$htmlLista=str_replace('{noticiasRelacionadas}',$htmlNoticiasRelacionadas,$htmlLista);
	}
	if($cantMuestra==$c2){
		$resp['mostrarMas']='SI';
	}else{
		$resp['mostrarMas']='NO';
	}
	$resp['cantReg']=$c;
	$resp['html']=$htmlLista;
}

if($accionRPC=='listarNoticiasParaRelacionar'){
	$idNoticia=recibir_dato('idNoticia');
	$idsNoticiasRelacionadas=recibir_dato('idsNoticiasRelacionadas');

	$vIdsNoticiasRelacionadas=explode(',',$idsNoticiasRelacionadas);
	for($i=0;isset($vIdsNoticiasRelacionadas[$i])==true;$i++){
		$vNotSelect[$vIdsNoticiasRelacionadas[$i]]=true;
	}
	$whereIdNoticia='';
	if($idNoticia!=''){
		$whereIdNoticia="and id_noticia<>$idNoticia";
	}
	$sql="select * from noticias where id_sistema=".$tra['id_sistema']." $whereIdNoticia order by fecha_noticia desc";
	$db->set_query($sql);
	$db->execute_query();
	$resp['html']=leerHtmlEnSeccion('tabla-lista-relacionar-noticia').chr(13);
	$htmlFilas='';
	$c=0;
	while($row=$db->get_array()){
		$c++;
		
		$sql2="
			select
				nc.noticia_categoria
			from 
				noticia_rel_noticia_categoria rel
				join noticia_categorias nc on (rel.id_sistema=nc.id_sistema and rel.id_noticia_categoria=nc.id_noticia_categoria)
			where 
				rel.id_sistema=".$tra['id_sistema']." and
				rel.id_noticia=".$row['id_noticia']."
			order by
				nc.noticia_categoria asc
		";
		$db2->set_query($sql2);
		$db2->execute_query();
		$categorias='';
		while($row2=$db2->get_array()){
			if($categorias!=''){$categorias.=', ';}
			$categorias.=$row2['noticia_categoria'];
		}
		
		$htmlFilas.=leerHtmlEnSeccion('fila-lista-relacionar-noticia').chr(13);
		$htmlFilas=str_replace('{idNoticia}',$row['id_noticia'],$htmlFilas);
		$htmlFilas=str_replace('{titular}',$row['titular'],$htmlFilas);
		$htmlFilas=str_replace('{fecha}',substr($row['fecha_noticia'],0,16),$htmlFilas);
		$htmlFilas=str_replace('{categorias}',$categorias,$htmlFilas);
		if(isset($vNotSelect[$row['id_noticia']])==true){
			$htmlFilas=str_replace('<input type="checkbox" name="idNoticiaParaRelacionar" value="'.$row['id_noticia'].'" />','<img src="fuentestra/imagenes/bot/16x16/accept.png" />',$htmlFilas);
		}
	}
	if($c==0){
		$htmlFilas='<tr><td colspan=3>No se registra ninguna ninguna para relacionar</td></tr>';
	}
	$resp['html']=str_replace('{filas}',$htmlFilas,$resp['html']);	
}

if($accionRPC=='listarCategorias'){
	$idsCategorias=recibir_dato('idsCategorias');

	$vIdsCategorias=explode(',',$idsCategorias);
	for($i=0;isset($vIdsCategorias[$i])==true;$i++){
		$vCatSelect[$vIdsCategorias[$i]]=true;
	}
	$sql="select * from noticia_categorias where id_sistema=".$tra['id_sistema']." order by noticia_categoria";
	$db->set_query($sql);
	$db->execute_query();
	$resp['html']=leerHtmlEnSeccion('tabla-lista-categoria-noticia').chr(13);
	$htmlFilas='';
	$c=0;
	while($row=$db->get_array()){
		$c++;
		if(isset($vCatSelect[$row['id_noticia_categoria']])==true){
			$checked='checked';
		}else{
			$checked='';
		}
		
		$htmlFilas.=leerHtmlEnSeccion('fila-lista-categoria-noticia').chr(13);
		$htmlFilas=str_replace('{idCategoria}',$row['id_noticia_categoria'],$htmlFilas);
		$htmlFilas=str_replace('{categoria}',$row['noticia_categoria'],$htmlFilas);
		$htmlFilas=str_replace('{checked}',$checked,$htmlFilas);
	}
	if($c==0){
		$htmlFilas='<tr><td colspan=3>No se registra ninguna categoría cargada</td></tr>';
	}
	$resp['html']=str_replace('{filas}',$htmlFilas,$resp['html']);
}

if($accionRPC=='insertarCategoria'){
	$categoria=recibir_dato('categoria');
	$sql="select id_noticia_categoria from noticia_categorias where id_sistema=".$tra['id_sistema']." and noticia_categoria='".$categoria."'";
	$db->set_query($sql);
	$db->execute_query();
	$referencias='';
	if($row=$db->get_array()){
		$resp['mensaje']='Ya existe una categoría con el nombre '.$categoria;	
	}else{
		$sql="
			insert into noticia_categorias (
				id_sistema,
				id_noticia_categoria,
				noticia_categoria,
				id_usuario_creo,
				id_usuario_modif
			) values (
				".$tra['id_sistema'].",
				".obtenerSigId('noticia_categorias').",
				'$categoria',
				".$tra['id_usuario'].",
				".$tra['id_usuario']."
			)
		";
		$db->set_query($sql);
		$db->execute_query();
	}
}

if($accionRPC=='editarCategoria'){
	$idCategoria=recibir_dato('idCategoria');
	$categoria=recibir_dato('categoria');
	$sql="select id_noticia_categoria from noticia_categorias where id_sistema=".$tra['id_sistema']." and noticia_categoria='".$categoria."' and id_noticia_categoria<>$idCategoria";
	$db->set_query($sql);
	$db->execute_query();
	$referencias='';
	if($row=$db->get_array()){
		$resp['mensaje']='Ya existe una categoría con el nombre '.$categoria;	
	}else{
		$sql="
			update 
				noticia_categorias 
			set
				noticia_categoria='$categoria',
				id_usuario_modif=".$tra['id_usuario']."
			where
				id_sistema=".$tra['id_sistema']." and
				id_noticia_categoria=$idCategoria
		";
		$db->set_query($sql);
		$db->execute_query();
	}
}

if($accionRPC=='eliminarCategoria'){
	$idCategoria=recibir_dato('idCategoria');
	$sql="delete from noticia_categorias where id_sistema=".$tra['id_sistema']." and id_noticia_categoria=$idCategoria";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='cargarRelNoticiaCategorias'){
	$idsCategorias=recibir_dato('idsCategorias');
	if($idsCategorias!=''){
		$vIdsCategorias=explode(',',$idsCategorias);
		for($i=0;isset($vIdsCategorias[$i])==true;$i++){
			$c++;
			$sql="select id_noticia_categoria, noticia_categoria from noticia_categorias where id_sistema=".$tra['id_sistema']." and id_noticia_categoria=".$vIdsCategorias[$i];
			$db->set_query($sql);
			$db->execute_query();
			$row=$db->get_array();
			$resp['html'].=leerHtmlEnSeccion('fila-rel-noticia-categoria').chr(13);
			$resp['html']=str_replace('{idCategoria}',$row['id_noticia_categoria'],$resp['html']);
			$resp['html']=str_replace('{categoria}',$row['noticia_categoria'],$resp['html']);
		}
	}else{
		$resp['html']='<a href="javascript:cargarSeccion(\'noticias\',\'lista_categorias\',\'\',\'ventana\');" title="vincular a una categoria">seleccionar categoría</a>';
	}
}

if($accionRPC=='generarListaNoticiasRelacionadas'){
	$idsNoticiasActuales = recibir_dato('idsNoticiasActuales');
	$idsNoticiasNuevas = recibir_dato('idsNoticiasNuevas');

	$where='';
	if($idsNoticiasActuales!=''){	
		$vIdsNoticiasActuales=explode(',',$idsNoticiasActuales);
		for($i=0;isset($vIdsNoticiasActuales[$i])==true;$i++){
			if($where!=''){$where.='or';}
			$where.=' id_noticia='.$vIdsNoticiasActuales[$i].' ';
		}
	}
	if($idsNoticiasNuevas!=''){
		$vIdsNoticiasNuevas=explode(',',$idsNoticiasNuevas);
		for($i=0;isset($vIdsNoticiasNuevas[$i])==true;$i++){
			if($where!=''){$where.='or';}
			$where.=' id_noticia='.$vIdsNoticiasNuevas[$i].' ';
		}
	}
	if($where!=''){
		$where=' and ('.$where.')';
	}
	
	$sql="select * from noticias where id_sistema=".$tra['id_sistema']." $where order by fecha_noticia desc";
	$db->set_query($sql);
	$db->execute_query();
	while($row=$db->get_array()){
		$sql2="
			select
				nc.noticia_categoria
			from 
				noticia_rel_noticia_categoria rel
				join noticia_categorias nc on (rel.id_sistema=nc.id_sistema and rel.id_noticia_categoria=nc.id_noticia_categoria)
			where 
				rel.id_sistema=".$tra['id_sistema']." and
				rel.id_noticia=".$row['id_noticia']."
			order by
				nc.noticia_categoria asc
		";
		$db2->set_query($sql2);
		$db2->execute_query();
		$categorias='';
		while($row2=$db2->get_array()){
			if($categorias!=''){$categorias.=', ';}
			$categorias.=$row2['noticia_categoria'];
		}
		
		if(isset($vNotSelect[$row['id_noticia']])==true){
			$checked='checked';
		}else{
			$checked='';
		}
		
		$resp['html'].=leerHtmlEnSeccion('fila-noticia-relacionada').chr(13);
		$resp['html']=str_replace('{idNoticia}',$row['id_noticia'],$resp['html']);
		$resp['html']=str_replace('{titular}',$row['titular'],$resp['html']);
		$resp['html']=str_replace('{fecha}',substr($row['fecha_noticia'],0,16),$resp['html']);
		$resp['html']=str_replace('{categorias}',$categorias,$resp['html']);
	}
}
?>