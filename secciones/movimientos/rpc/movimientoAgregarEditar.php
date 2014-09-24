<?php
$idMovimientoEdit = recibir_dato('idMovimientoEdit');
$idCaja = recibir_dato('idCaja');
$moneda = recibir_dato('moneda');
$confirmado = recibir_dato('confirmado');
$tipo = recibir_dato('tipo');
$fechaIdeal = recibir_dato('fechaIdeal');
$correspondienteMes = recibir_dato('correspondienteMes');
$fecha = recibir_dato('fecha');
$hora = recibir_dato('hora');
$comprobanteNro = recibir_dato('comprobanteNro');
$idPersona = recibir_dato('idPersona');
$concepto = recibir_dato('concepto');
$rubro = recibir_dato('rubro');
$ingreso = recibir_dato('ingreso');
$egreso = recibir_dato('egreso');
$adjuntos = recibir_dato('adjuntos');

$conceptos = explode('|',$concepto);
$rubros = explode('|',$rubro);
$ingreso = explode('|',$ingreso);
$egreso = explode('|',$egreso);

$idProyecto = $_SESSION['id_proyecto'];

if($idProyecto==''){$idProyecto='null';}
$idUsuario = $tra['id_usuario'];

$fecha = empty($fecha) ? 'null' : "'$fecha $hora'";
$fechaIdeal = empty($fechaIdeal) ? 'null' : "'$fechaIdeal'";

if(!empty($correspondienteMes)) {
	$correspondienteMes = "'01/$correspondienteMes'";
} else {
	$correspondienteMes = 'null';
}

$posUpload = '{}';

$db->begin();

if(empty($idMovimientoEdit)){

	///-----------------------------------///
	
	if (!empty($adjuntos)) {
		$sql="select nextval('sistema.movimientos_id_movimiento_seq');";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();
		$idMovimiento = $row['nextval'];	
		
		$archivo=$adjuntos;
		$prefijo=$idMovimiento;
		$archivoViejo='';
		$prefijoViejo='';
		
		$posUpload=posUpload(
			'movimientos/movimientos/',			//-- ruta
			$archivo,							//-- archivos nuevos
			$archivoViejo,						//-- archivos viejos
			$prefijo,							//-- prefijo nuevo
			$prefijoViejo						//-- prefijo viejo
		);
	}
	
	///-----------------------------------///	
	
	$sql="
		insert into sistema.movimientos(
			id_proyecto,
			fecha,
			fecha_ideal,
			id_persona,
			comprobante_nro,
			tipo,
			id_usuario,
			correspondiente_al_mes_de,
			moneda,
			confirmado,
			comprobante_digital
		)values(
			$idProyecto,
			$fecha,
			$fechaIdeal,
			'$idPersona',
			'$comprobanteNro',
			'$tipo',
			$idUsuario,
			$correspondienteMes,
			'$moneda',
			'$confirmado',
			'". $posUpload ."'
		) returning id_movimiento
	";
	//d($sql);
	$db->set_query($sql);
	$db->execute_query();
	$row = $db->get_array();
		
	$idMovimiento = $row['id_movimiento'];
}else{
	
	///-----------------------------------///
	
	if (!empty($adjuntos)) {
		$sql="
			select
				id_movimiento,
				array_to_string(comprobante_digital, '|') as archivos
			from
				sistema.movimientos
			where
				id_movimiento=$idMovimientoEdit
		";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();
		
		$archivo=$adjuntos;
		$prefijo=$idMovimientoEdit;
		$prefijoViejo=$row['id_movimiento'];
		$archivoViejo=$row['archivos'];
		
		$posUpload=posUpload(
			'movimientos/movimientos/',			//-- ruta
			$archivo,							//-- archivos nuevos
			$archivoViejo,						//-- archivos viejos
			$prefijo,							//-- prefijo nuevo
			$prefijoViejo						//-- prefijo viejo
		);
	}
	
	///-----------------------------------///	
	
	$sql="
		update
			sistema.movimientos
		set
			id_proyecto=$idProyecto,
			fecha=$fecha,
			fecha_ideal=$fechaIdeal,
			id_persona='$idPersona',
			comprobante_nro='$comprobanteNro',
			tipo='$tipo',
			id_usuario=$idUsuario,
			correspondiente_al_mes_de=$correspondienteMes,
			moneda='$moneda',
			comprobante_digital='". $posUpload ."'
		where
			id_movimiento=$idMovimientoEdit
	";
	//d($sql);
	$db->set_query($sql);
	$db->execute_query();
	
	$sql="delete from sistema.movimiento_detalles where id_movimiento=$idMovimientoEdit";
	//d($sql);
	$db->set_query($sql);
	$db->execute_query();
	
	$idMovimiento = $idMovimientoEdit;
}

for($i=0; $i<count($conceptos); $i++) {
	$ig = empty($ingreso[$i]) ? 'null' : $ingreso[$i];
	$eg = empty($egreso[$i]) ? 'null' : $egreso[$i];
	
	$sql="
		insert into sistema.movimiento_detalles (
			id_movimiento,
			id_rubro,
			concepto,
			ingreso,
			egreso
		)values(
			{$idMovimiento},
			{$rubros[$i]},
			'{$conceptos[$i]}',
			$ig,
			$eg
		)
	";
	//d($sql);
	$db->set_query($sql);
	$db->execute_query();
}

$resp['idMovimiento'] = $idMovimiento;

$db->commit();
?>