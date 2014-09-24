<?php
$idProyecto = recibir_dato('idProyecto');

$valor = recibir_dato('valor');
setcookie('valor', $valor);
//-- recepcion de datos

if(!empty($idProyecto)){
	$sql="
		select
			proyecto,
			telefono,
			email,
			direccion,
			(select id_pais from sistema.ciudades where id_ciudad=p.id_ciudad) as id_pais,
			id_ciudad,
			array_to_string(logo,'|') as logo,
			firmantes,
			coordenadas,
			id_categoria,
			zona_horaria,
			lenguaje
		from
			sistema.proyectos p
		where
			id_proyecto=$idProyecto
	";
	$db->set_query($sql);
	$db->execute_query();
	$row=$db->get_array();
	
	$proyecto = $row['proyecto'];
	$telefono = $row['telefono'];
	$email = $row['email'];
	$direccion = $row['direccion'];
	$idPais = $row['id_pais'];
	$idCiudad = $row['id_ciudad'];
	$firmantes = $row['firmantes'];
	$coordenadas = $row['coordenadas'];
	$idCategoria = $row['id_categoria'];
	$zonaHoraria = $row['zona_horaria'];
	$lenguaje = $row['lenguaje'];
	
	if (!empty($idPais)) { $pais = rpcSeccion('sistema', 'sistProyectosAgEd_pais', array('idPais' => $idPais)); }
	if (!empty($idCiudad)) { $ciudad = rpcSeccion('sistema', 'sistProyectosAgEd_ciudad', array('idCiudad' => $idCiudad)); }
	if (!empty($idCategoria)) { $categoria = rpcSeccion('sistema', 'sistProyectosAgEd_categoria', array('idCategoria' => $idCategoria)); }
	
	$adjuntos = mostrarUpload('sistema/logos/', $row['logo'], 150, 150);
}else{
	$proyecto = '';
	$telefono = '';
	$email = '';
	$direccion = '';
	$idPais = '';
	$idCiudad = '';
	$listarUpload = '';
	$firmantes = '';
	$coordenadas = '';
	$idCategoria = '';
	$zonaHoraria = '';
	$lenguaje = '';
}
?>