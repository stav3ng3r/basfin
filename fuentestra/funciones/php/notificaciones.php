<?php

	/* Tipos de notificaciones
	 * ***********************************/
	const INFORMACION = 1;
	const EXITO = 2;
	const ALERTA = 3;
	const ERROR = 4;

	/* Alcances de la notificacion
	 * ***********************************/
	const INDIVIDUAL = 1;
	const GRUPAL = 2;
	const PUBLICO = 3;

	function crearNotificacion($mensaje, $titulo = null, $tipoNotificacion = 1, $alcance = 3, $idSujeto = null) {
		
		if (!isset($mensaje) || empty($mensaje))
			throw new InvalidArgumentException("La notificacion debe contener un mensaje.");
		
		if (!($alcance >= 1 && $alcance <= 3))
			throw new InvalidArgumentException("El alcance de la notifiacion debe ser 1, 2 o 3. Se introdujo: " . $alcance);
		
		if ($alcance !== 3 && (!isset($idSujeto) || empty($idSujeto) || !is_int($idSujeto)))
			throw new InvalidArgumentException("El idSujeto debe ser un entero. Se introdujo: " . $idSujeto);
		
		$query = "
    		INSERT INTO sistema.notificaciones (id_tipo, titulo, mensaje, alcance, id_sujeto)
    		VALUES ($tipoNotificacion, " . ( (!isset($titulo) || empty($titulo)) ? 'null' : "'$titulo'" ) . ", '$mensaje', $alcance, " . ((!isset($idSujeto) || empty($idSujeto)) ? 'null' : $idSujeto ) . ");
    	";

		$dbNot = new db();
		$dbNot->connect();
		$dbNot -> set_query($query);
		$dbNot -> execute_query();

	}
	

	function obtenerNotifiacion() {
		
	}
