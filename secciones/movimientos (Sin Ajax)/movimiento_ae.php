<?php
$idMovimiento = recibir_dato('idMovimiento');
$tipo = recibir_dato('tipo');
//-- recepcion de datos

$idProyecto = $_SESSION['id_proyecto'];

if(!empty($idMovimiento)){
	$sql="
		select
			id_proyecto,
			fecha::timestamp without time zone as fecha,
			fecha::time as hora,
			fecha_ideal,
			id_persona,
			comprobante_nro,
			tipo,
			confirmado,
			id_usuario,
			correspondiente_al_mes_de,
			moneda,
			array_to_string(comprobante_digital, '|') as comprobante_digital
		from
			sistema.movimientos
		where
			id_movimiento=$idMovimiento and
			id_proyecto=$idProyecto
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$fecha = $row['fecha'];
	$hora = $row['hora'];
	$fechaIdeal = $row['fecha_ideal'];
	$idPersona = $row['id_persona'];
		
	$comprobanteNro = $row['comprobante_nro'];
	$tipo = $row['tipo'];
	$confirmado = $row['confirmado'];
	$idUsuario = $row['id_usuario'];
	$correspondienteMes = substr($row['correspondiente_al_mes_de'], 3);
	$moneda = $row['moneda'];
	$comprobanteDigital = $row['comprobante_digital'];
	
	// Upload
	$adjuntos = mostrarUpload('movimientos/movimientos/', $comprobanteDigital, 180, 120);
	
	// Autocompletar Campo Persona
	$autocompletarPersona = rpcSeccion('movimientos', 'moviMovimientosAgEd_idPersona', array('idPersona' => $row['id_persona']));
	setcookie('autocompletar_persona', json_encode(array($row['id_persona'], $autocompletarPersona)));
	
	// Autocompletar Campos Dinamicos
	$sql="
		select
			*
		from
			sistema.movimiento_detalles
			join sistema.rubros r using (id_rubro)
		where
			id_movimiento=$idMovimiento
	";
	$db->set_query($sql);
	$db->execute_query();
	while($row=$db->get_array()) {
		$datos[] = array(
			'concepto' => $row['concepto'],
			'rubro' => array($row['id_rubro'], $row['rubro']),
			'valor' => ($row['ingreso'] > 0) ? str_replace('.',',',$row['ingreso']) : str_replace('.',',',$row['egreso'])
		);
	}
	
	setcookie('movimientoDetalles', json_encode($datos));
}else{
	$fecha = date('d/m/Y');
	$hora = date('H:i');
	$fechaIdeal = '';
	$idPersona = '';
	$comprobanteNro = '';
	$confirmado = 't';
	$idUsuario = '';
	$correspondienteMes = '';
	$moneda = '';
	$persona = '';
}

$titulo = ucfirst($tipo);

$sql="
	select
		*
	from
		sistema.cajas
	where
		id_proyecto=$idProyecto
";
$db->set_query($sql);
$db->execute_query();
$optionCaja='<option value="null">Caja</option>';
while($row=$db->get_array()) {
	$optionCaja.='<option value="'. $row['id_caja'] .'">'. $row['caja'] .'</option>';
}
?>