<?php

$cantElementosNuevos=20;

$idItem = recibir_dato('idMenu');

$c=-1;
//-- informacion de cabecera de lista
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='menuAdministrar';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='menuAdministrar';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';		$matriz[0][$c]['permiso']='menuAdministrar';
$c++;	$matriz[0][$c]['html']='Item*';			$matriz[0][$c]['width']=0;		$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='Tipo';			$matriz[0][$c]['width']=80;		$matriz[0][$c]['style']='text-align:center;';
$c++;	$matriz[0][$c]['html']='Detalle';		$matriz[0][$c]['width']=250;	$matriz[0][$c]['style']='text-align:left;';
$c++;	$matriz[0][$c]['html']='&nbsp;';		$matriz[0][$c]['width']=16;		$matriz[0][$c]['style']='text-align:center;';

if($cadenaBuscar!=''){
	if(substr($cadenaBuscar,0,1)=='>'){
		$whereFiltro="and '>' || sp_ascii(mi.ruta2) ilike sp_ascii('%".$cadenaBuscar."%')";
	}else{
		$whereFiltro=generarWhereFiltroCadenaBuscar("
			sp_ascii(mi.item) ilike sp_ascii('%{text}%')
		");		
	}
}

if(empty($idItem)){
	$where=" i1.cab_id_item is null ";
}else{
	$where=" i1.id_item=$idItem ";	
}

$sql="
	with recursive mapa_items as (
		(
		select
			i1.id_item,
			i1.cab_id_item,
			i1.item,
			case when length(i1.orden::text)=1 then '0'||i1.orden else i1.orden::text end || '@' || i1.id_item || '@' || i1.item as ruta,
			i1.item as ruta2,
			0 as nivel,
			i1.orden
		from
			items i1
		where
			$where
		)
		union all
		(
		select
			i2.id_item,
			i2.cab_id_item,
			i2.item,
			mi.ruta||'/'|| case when length(i2.orden::text)=1 then '0'||i2.orden else i2.orden::text end ||'@'||i2.id_item||'@'||i2.item as ruta,
			mi.ruta2||'>'|| i2.item as ruta2,
			mi.nivel + 1 as nivel,
			i2.orden
		from
			items i2,
			mapa_items mi
		where
			i2.cab_id_item = mi.id_item
		)
	)
	select
		*,
		i.tipo,
		i.seccion,
		i.aplicacion,
		i.parametros,
		i.item_de_sistema
	from
		mapa_items mi
		join items i on (mi.id_item=i.id_item)
	where
		1=1
		$whereFiltro
	order by
		mi.ruta
";
//echo $sql;
if($cadenaBuscar==''){
	$sql=filtrarQueryLista($sql);
}
$db->set_query($sql);
$db->execute_query();
$c=0;
unset($gItemOrganigrama);
while($row=$db->get_array()){
	$espacio=' &nbsp; &nbsp; &nbsp; &nbsp; ';
	
	$vDepend=explode('/',$row['ruta']);
	//-- informacion de registros de lista
	if($cadenaBuscar!=''){
		for($i=0;$i<=$row['nivel']-1;$i++){
			
			list($orden,$idOrgRuta,$denomRuta)=explode('@',$vDepend[$i]);
			
			if(isset($gItemOrganigrama[$idOrgRuta])==false){
				$espaciado='';
				for($e=0;$e<$i;$e++){
					$espaciado.=$espacio;	
				}
								
				$c++;
				$matriz[$c][]['html']='<!--seleccionarDeListado()-->';
				$matriz[$c][]['html']='&nbsp;';
				$matriz[$c][]['html']='&nbsp;';
				$matriz[$c][]['html']='&nbsp;';
				$matriz[$c][]['html']=$espaciado.$denomRuta;
				$matriz[$c][]['html']='&nbsp;';
				$matriz[$c][]['html']='&nbsp;';
				$matriz[$c][]['html']='&nbsp;';
				$gItemOrganigrama[$idOrgRuta]=1;
			}
		}		
	}

	$itemTitle='';
	for($o=0;$o<$row['nivel'];$o++){
		$ruta = explode('@',$vDepend[$o]);
		
		$espaciado='';
		for($i=0;$i<$o;$i++){
			$espaciado.=$espacio;	
		}
		
		$itemTitle .= $espaciado.$ruta[1].'<br>';
	}
	
	$espaciado='';
	for($i=0;$i<$row['nivel'];$i++){
		$espaciado.=$espacio;
	}
	$itemTitle .= $espaciado.$row['item'];

	$detalle='';
	if($row['tipo']=='aplicacion'){
		$detalle=$row['seccion'];
		if($row['aplicacion']!=''){
		$detalle.=' &gt; '.$row['aplicacion'];
		}
	}
	if($row['tipo']=='documento'){
		$detalle=str_replace('documento=','',$row['parametros']);
	}
	if($row['tipo']=='href'){
		$detalle=$row['parametros'];
	}

	if(($row['item_de_sistema']=='t' && $tra['id_usuario']==1) || ($row['item_de_sistema']=='f')){
		$accionAddItem='<a href="javascript:cargarSeccion(\'menu\',\'menu_ae\',\'cabIdItem='.$row['id_item'].'\',\'ventana\');" title="agregar ítem dentro de esta sección"><span class="glyphicon glyphicon-plus"></a>';
		$accionEditar='<a href="javascript:cargarSeccion(\'menu\',\'menu_ae\',\'idItem='.$row['id_item'].'\',\'ventana\');" title="editar propiedades del ítem"><span class="glyphicon glyphicon-edit"></a>';
		$accionEliminar='<a href="javascript:dialogo(\'Confirma que desea eliminar este item del menú?\',\'si:eliminarMenu('.$row['id_item'].');|no\',\'eliminar\');" title="eliminar ítem"><span class="glyphicon glyphicon-remove"></a>';
	}else{
		$accionAddItem='&nbsp;';
		$accionEditar='&nbsp;';
		$accionEliminar='&nbsp;';
	}

	$c++;
	$matriz[$c][]['html']=seleccionarDeLista($row['id_item'],'<label title=#cs#'.$itemTitle.'#cs#>'.$row['item'].'</label>');
	$matriz[$c][]['html']=$accionAddItem;
	$matriz[$c][]['html']=$accionEditar;
	$matriz[$c][]['html']=$accionEliminar;
	$matriz[$c][]['html']=$espaciado.$row['orden'].') '.$row['item'];
	$matriz[$c][]['html']=$row['tipo'];
	$matriz[$c][]['html']=$detalle;
	$matriz[$c][]['html']='<span class="glyphicon glyphicon-info-sign"></span>';
	$matriz[$c]['estado']=$row['estado'];
	$gItemOrganigrama[$row['id_item']]=1;
}
$resp['html']=armarLista($matriz);
?>