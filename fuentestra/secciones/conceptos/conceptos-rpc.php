<?
if($accionRPC=='insertarConcepto'){
	$nombreConcepto=recibir_dato('nombreConcepto','post');

	$sql="
		insert into conceptos (
			id_sistema,
			id_concepto,
			concepto,
			id_usuario_creo,
			id_usuario_modif
		) values (
			".$tra['id_sistema'].",
			".obtenerSigId('conceptos').",
			'$nombreConcepto',
			".$tra['id_usuario'].",
			".$tra['id_usuario']."
		)
	";
	$db->set_query($sql);
	$db->execute_query();
	$resp['mensaje']="El concepto se ha agregado exitósamente";
}
?>