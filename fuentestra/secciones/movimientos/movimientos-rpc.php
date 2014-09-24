<?
if($accionRPC=='insertarMovimiento'){
	$tipo=recibir_dato('tipo','post');
	$fecha=recibir_dato('fecha','post');
	$idContacto=recibir_dato('idContacto','post');
	$idConcepto=recibir_dato('idConcepto','post');
	$observacion=recibir_dato('observacion','post');
	$tipoComprobante=recibir_dato('tipoComprobante','post');
	$nroComprobante=recibir_dato('nroComprobante','post');
	$monto=recibir_dato('monto','post');
	$fechaVencimiento=recibir_dato('fechaVencimiento','post');
	$estado=recibir_dato('estado','post');
	
	if($fechaVencimiento==''){
		$fechaVencimiento='null';
	}else{
		$fechaVencimiento="'$fechaVencimiento'";
	}
	
	$sql="
		insert into movimientos (
			id_sistema,
			id_movimiento,
			id_contacto,
			id_concepto,
			tipo_movimiento,
			observacion_movimiento,
			comprobante_tipo,
			comprobante_nro,
			monto,
			estado,
			fecha_movimiento,
			fecha_vencimiento,
			id_usuario_creo,
			id_usuario_modif
		) values (
			".$tra['id_sistema'].",
			".obtenerSigId('movimientos').",
			$idContacto,
			$idConcepto,
			'$tipo',
			'$observacion',
			'$tipoComprobante',
			'$nroComprobante',
			$monto,
			$estado,
			'$fecha',
			$fechaVencimiento,
			".$tra['id_usuario'].",
			".$tra['id_usuario']."
		)
	";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='editarMovimiento'){
	$idMovimiento=recibir_dato('idMovimiento','post');
	$tipo=recibir_dato('tipo','post');
	$fecha=recibir_dato('fecha','post');
	$idContacto=recibir_dato('idContacto','post');
	$idConcepto=recibir_dato('idConcepto','post');
	$observacion=recibir_dato('observacion','post');
	$tipoComprobante=recibir_dato('tipoComprobante','post');
	$nroComprobante=recibir_dato('nroComprobante','post');
	$monto=recibir_dato('monto','post');
	$fechaVencimiento=recibir_dato('fechaVencimiento','post');
	$estado=recibir_dato('estado','post');
	
	if($fechaVencimiento==''){
		$fechaVencimiento='null';
	}else{
		$fechaVencimiento="'$fechaVencimiento'";
	}
	
	$sql="
		update
			movimientos 
		set 
			id_contacto=$idContacto,
			id_concepto=$idConcepto,
			tipo_movimiento='$tipo',
			observacion_movimiento='$observacion',
			comprobante_tipo='$tipoComprobante',
			comprobante_nro='$nroComprobante',
			monto=$monto,
			estado=$estado,
			fecha_movimiento='$fecha',
			fecha_vencimiento=$fechaVencimiento,
			id_usuario_modif=".$tra['id_usuario']."
		where
			id_sistema=".$tra['id_sistema']." and 
			id_movimiento=$idMovimiento
	";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='eliminarMovimiento'){
	$idMovimiento=recibir_dato('id','post');
	$sql="delete from movimientos where id_sistema=".$tra['id_sistema']." and id_movimiento=$idMovimiento";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='listarMovimientos'){

	$sql="update movimientos set fecha_movimiento=now() where id_sistema=".$tra['id_sistema']." and estado=false and fecha_movimiento<now()";
	$db->set_query($sql);
	$db->execute_query();

	$filt_tipoMovimientoIngreso=recibir_dato('filt_tipoMovimientoIngreso');
	$filt_tipoMovimientoEgreso=recibir_dato('filt_tipoMovimientoEgreso');
	$filt_fechaDesde=recibir_dato('filt_fechaDesde');
	$filt_fechaHasta=recibir_dato('filt_fechaHasta');
	$filt_idContacto=recibir_dato('filt_idContacto');
	$filt_idConcepto=recibir_dato('filt_idConcepto');
	$filt_observacion=recibir_dato('filt_observacion');
	$filt_tipoComprobante=recibir_dato('filt_tipoComprobante');
	$filt_nroComprobante=recibir_dato('filt_nroComprobante');
	$filt_monto=recibir_dato('filt_monto');
	$filt_estadoC=recibir_dato('filt_estadoC');
	$filt_estadoP=recibir_dato('filt_estadoP');
	$where='';

	if(($filt_tipoMovimientoIngreso=='true')&&($filt_tipoMovimientoEgreso=='false')){$where.=" and m.tipo_movimiento='I' ";}
	if(($filt_tipoMovimientoIngreso=='false')&&($filt_tipoMovimientoEgreso=='true')){$where.=" and m.tipo_movimiento='E' ";}
	if($filt_fechaDesde!=''){$where.=" and m.fecha_movimiento>='".$filt_fechaDesde."' ";}
	if($filt_fechaHasta!=''){$where.=" and m.fecha_movimiento<='".$filt_fechaHasta."' ";}
	if($filt_idContacto!=''){$where.=" and ct.id_contacto=".$filt_idContacto." ";}
	if($filt_idConcepto!=''){$where.=" and cp.id_concepto=".$filt_idConcepto." ";}
	if($filt_observacion!=''){$where.=" and m.observacion_movimiento like '%".$filt_observacion."%' ";}
	if($filt_tipoComprobante!=''){$where.=" and m.comprobante_tipo='".$filt_tipoComprobante."' ";}
	if($filt_nroComprobante!=''){$where.=" and m.comprobante_nro='".$filt_nroComprobante."' ";}
	if(($filt_monto!='')&&($filt_monto!='0')){$where.=" and m.monto=".$filt_monto." ";}
	if(($filt_estadoC=='true')&&($filt_estadoP=='false')){$where.=" and m.estado=true ";}
	if(($filt_estadoC=='false')&&($filt_estadoP=='true')){$where.=" and m.estado=false ";}

	$sql="
		select 
			m.id_movimiento,
			ct.nombre,
			cp.concepto,
			m.observacion_movimiento,
			m.comprobante_tipo,
			m.comprobante_nro,
			m.monto,
			m.estado,
			m.fecha_movimiento,
			m.fecha_vencimiento,
			m.renovar,
			m.observacion_renovacion,
			m.tipo_movimiento
		from movimientos m
			join contactos ct on(m.id_contacto=ct.id_contacto and ct.id_sistema=m.id_sistema)
			join conceptos cp on(m.id_concepto=cp.id_concepto and cp.id_sistema=m.id_sistema)
		where
			m.id_sistema=".$tra['id_sistema']."
			$where
		order by 
			m.fecha_movimiento asc,
			m.estado desc,
			m.id_movimiento asc
	";
	$db->set_query($sql);
	$db->execute_query();
	$resp['html']=leerHtmlEnSeccion('tabla-lista').chr(13);
	
	$ac['t']=0;
	$ac['f']=0;
	$c=0;
	while($row=$db->get_array()){
		$c++;
		if($row['estado']=='t'){
			$estadoDesc='<label title="Aprobado">C</label>';
			$class='confirmado';
		}else{
			$estadoDesc='<label title="Pendiente">P</label>';
			$class='pendiente';
		}
		if($row['tipo_movimiento']=='I'){
			$tipoDesc='<label title="Ingreso">+</label>';
		}else{
			$tipoDesc='<label title="Egreso">-</label>';
		}
		
		if($row['tipo_movimiento']=='I'){
			$ac[$row['estado']]+=$row['monto'];
			$montoIngreso=number_format($row['monto'],0,',','.');
			$montoEgreso='&nbsp;';
		}else{
			$ac[$row['estado']]-=$row['monto'];
			$montoIngreso='&nbsp;';
			$montoEgreso=number_format($row['monto'],0,',','.');
		}
		
		if($filt_observacion!=''){
			$row['observacion_movimiento']=agregar_style_a_palabra_en_texto($filt_observacion,$row['observacion_movimiento']);
		}
		
		if($row['fecha_movimiento']==date('d/m/Y')){
			$class.='hoy';
		}
		
		$numFechaVencimiento=substr($row['fecha_vencimiento'],6,4).substr($row['fecha_vencimiento'],3,2).substr($row['fecha_vencimiento'],0,2);
		if(($row['fecha_vencimiento']!='')&&($numFechaVencimiento<date('Ymd'))){
			if($row['tipo_movimiento']=='I'){
				if($row['renovar']==''){
					$class='vencido';
				}
			}else{
				if($row['estado']=='f'){
					$class='vencido';
				}
			}
		}
		
		$htmlLista.=leerHtmlEnSeccion('fila-lista').chr(13);
		$htmlLista=str_replace('{numeracion}',$c,$htmlLista);
		$htmlLista=str_replace('{idMovimiento}',$row['id_movimiento'],$htmlLista);
		$htmlLista=str_replace('{fecha}',$row['fecha_movimiento'],$htmlLista);
		$htmlLista=str_replace('{contacto}',$row['nombre'],$htmlLista);
		$htmlLista=str_replace('{concepto}',$row['concepto'],$htmlLista);
		$htmlLista=str_replace('{observacion}',$row['observacion_movimiento'],$htmlLista);
		$htmlLista=str_replace('{compTipo}',$row['comprobante_tipo'],$htmlLista);
		$htmlLista=str_replace('{compNro}',$row['comprobante_nro'],$htmlLista);
		$htmlLista=str_replace('{tipo}',$tipoDesc,$htmlLista);
		$htmlLista=str_replace('{montoIngreso}',$montoIngreso,$htmlLista);
		$htmlLista=str_replace('{montoEgreso}',$montoEgreso,$htmlLista);
		$htmlLista=str_replace('{estado}',$estadoDesc,$htmlLista);
		$htmlLista=str_replace('{saldoC}',number_format($ac['t'],0,',','.'),$htmlLista);
		$htmlLista=str_replace('{saldoP}',number_format($ac['f'],0,',','.'),$htmlLista);
		$htmlLista=str_replace('{saldoC+P}',number_format($ac['t']+$ac['f'],0,',','.'),$htmlLista);
		$htmlLista=str_replace('{renovarFecha}',$row['fecha_vencimiento'],$htmlLista);
		$htmlLista=str_replace('{renovarResp}',$row['renovar'],$htmlLista);
		$htmlLista=str_replace('{renovarObservacion}',$row['observacion_renovacion'],$htmlLista);
		
		$htmlLista=str_replace('{class}',$class,$htmlLista);
	}	
	$resp['html']=str_replace('{filas}',$htmlLista,$resp['html']);
}
?>