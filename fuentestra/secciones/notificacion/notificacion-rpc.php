<?php
$tiempoEspera = 5000;

if ($accionRPC == 'verficiarNotificaciones' && !empty($tra['id_usuario'])) {

	$sql = "
		select
			*,
			denominacion tipo_notificacion
		from
			sistema.notificaciones
			left join sistema.notificaciones_usuarios using (id_notificacion)
			join sistema.notificacion_tipos on (id_tipo = id_notificacion_tipo)
		where
			(id_usuario = {$tra['id_usuario']} or
			alcance = 3) and
			visto is null
		order by id_notificacion desc;
	";

	$db -> set_query($sql);
	$db -> execute_query();

	$notificaciones = array();
	$notificacionesHtml = '';
	$nuevasNotificaciones = 'f';
	while ($notificaciones = $db -> get_array()) {
		$nuevasNotificaciones = 't';
		$tipo = '';

		switch ($notificaciones['tipo_notificacion']) {
			case 'exito' :
				$tipo = 'success';
				break;
			case 'informacion' :
				$tipo = 'info';
				break;
			case 'alerta' :
				$tipo = 'warning';
				break;
			case 'error' :
				$tipo = 'danger';
				break;
			default :
				$tipo = 'info';
				break;
		}

		$notificacionesHtml .= "
			<div class=\"alert alert-$tipo popup\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
				<h4>{$notificaciones['titulo']}</h4>
				{$notificaciones['mensaje']}
			</div>
		";

		$sql2 = "
			select count(*) from sistema.notificaciones_usuarios
			where id_notificacion = {$notificaciones['id_notificacion']} and id_usuario = {$tra['id_usuario']}
		";
		$db2 -> set_query($sql2);
		$db2 -> execute_query();
		$row = $db2 -> get_array();
		
		if ($row && intval($row['count']) >= 1) {
			$sql2 = "
				UPDATE sistema.notificaciones_usuarios
				SET visto = current_timestamp
				WHERE id_notificacion = {$notificaciones['id_notificacion']} and id_usuario = {$tra['id_usuario']};
			";
			$db2 -> set_query($sql2);
			$db2 -> execute_query();
			
		} else {
			
			$sql2 = "
				INSERT INTO sistema.notificaciones_usuarios(
				            id_notificacion, id_usuario, visto)
				    VALUES ({$notificaciones['id_notificacion']}, {$tra['id_usuario']}, current_timestamp);
			";
			$db2 -> set_query($sql2);
			$db2 -> execute_query();
		}

	}

	if($nuevasNotificaciones === 'f' ) $tiempoEspera = 'f';
	
	$resp['tiempoEspera'] = $tiempoEspera;
	$resp['nuevasNotificaciones'] = $nuevasNotificaciones;
	$resp['notificaciones'] = $notificacionesHtml;

}

?>
