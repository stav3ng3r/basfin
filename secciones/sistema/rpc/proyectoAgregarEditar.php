<?php
$idProyectoEdit = recibir_dato('idProyectoEdit');
$proyecto = recibir_dato('proyecto');
$telefono = recibir_dato('telefono');
$email = recibir_dato('email');
$direccion = recibir_dato('direccion');

$idPais = recibir_dato('idPais');
$idCiudad = recibir_dato('idCiudad');

$logo = recibir_dato('logo'); // upload

$firmantes = recibir_dato('firmantes');
$coordenadas = recibir_dato('coordenadas');
$idCategoria = recibir_dato('idCategoria');
$zonaHoraria = recibir_dato('zonaHoraria');
$lenguaje = recibir_dato('lenguaje');
$plantilla = recibir_dato('plantilla');

if($proyecto==''){$proyecto='null';}
if($telefono==''){$telefono='null';}
if($email==''){$email='null';}
if($direccion==''){$direccion='null';}
if($idCiudad==''){$idCiudad='null';}
if($firmantes==''){$firmantes='null';}
if($coordenadas==''){$coordenadas='null';}
if($idCategoria==''){$idCategoria='null';}
if($zonaHoraria==''){$zonaHoraria='null';}
if($lenguaje==''){$lenguaje='null';}

$posUpload='{}';

if(empty($idProyectoEdit)){
	
	if (!empty($logo)) {
		$sql="select nextval('sistema.proyectos_id_proyecto_seq');";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();
		$idProyecto = $row['nextval'];	
		
		$archivo=$logo;
		$prefijo=$idProyecto;
		$archivoViejo='';
		$prefijoViejo='';
		
		$posUpload=posUpload(
			'sistema/logos/',					//-- ruta
			$archivo,							//-- archivos nuevos
			$archivoViejo,						//-- archivos viejos
			$prefijo,							//-- prefijo nuevo
			$prefijoViejo						//-- prefijo viejo
		);
	}
	
	///-----------------------------------///			
	
	$sql="
		insert into sistema.proyectos(
			proyecto,
			telefono,
			email,
			direccion,
			id_ciudad,
			firmantes,
			coordenadas,
			id_categoria,
			zona_horaria,
			lenguaje,
			logo
		)values(
			'$proyecto',
			'$telefono',
			'$email',
			'$direccion',
			$idCiudad,
			'$firmantes',
			'$coordenadas',
			$idCategoria,
			'$zonaHoraria',
			'$lenguaje',
			'$posUpload'
		)
	";
	$db->set_query($sql);
	$db->execute_query();	
}else{
	///-----------------------------------///
	
	if (!empty($logo)) {
		$sql="
			select
				id_proyecto,
				array_to_string(logo, '|') as logo
			from
				sistema.proyectos
			where
				id_proyecto=$idProyectoEdit
		";
		$db->set_query($sql);
		$db->execute_query();
		$row=$db->get_array();
		
		$archivo=$logo;
		$prefijo=$idProyectoEdit;
		$prefijoViejo=$row['id_proyecto'];
		$archivoViejo=$row['logo'];
		
		$posUpload=posUpload(
			'sistema/logos/',			//-- ruta
			$archivo,							//-- archivos nuevos
			$archivoViejo,						//-- archivos viejos
			$prefijo,							//-- prefijo nuevo
			$prefijoViejo						//-- prefijo viejo
		);
	}
	
	///-----------------------------------///		
	
	$sql="
		update
			sistema.proyectos
		set
			proyecto='$proyecto',
			telefono='$telefono',
			email='$email',
			direccion='$direccion',
			id_ciudad=$idCiudad,
			firmantes='$firmantes',
			coordenadas='$coordenadas',
			id_categoria=$idCategoria,
			zona_horaria='$zonaHoraria',
			lenguaje='$lenguaje',
			logo='$posUpload'
		where
			id_proyecto=$idProyectoEdit
	";
	$db->set_query($sql);
	$db->execute_query();	
	
	$idProyecto=$idProyectoEdit; 
}

$resp['idProyecto']=$idProyecto;
?>