<?php
$idT2=recibir_dato('idT2');
$tipo=recibir_dato('tipo');

if($tipo=='t'){
	$auxTipo='now()';
	$idUsuarioConfirmo=$tra['id_usuario'];
}else{
	$auxTipo='null';
	$idUsuarioConfirmo='null';
}

$sql="
	update
		otros.generador_abm
	set
		fecha_confirmo=$auxTipo,
		id_usuario_confirmo={$idUsuarioConfirmo}
	where
		id_generador_abm=$idT2
";
$db->set_query($sql);
$db->execute_query();

$resp['estado']='t';
$resp['confirmado']=$tipo;
?>