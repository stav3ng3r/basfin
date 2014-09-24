<?php
$idT2=recibir_dato('idT2');
$tipo=recibir_dato('tipo');

if($tipo=='t'){
	$auxTipo='true';
}else{
	$auxTipo='false';
}

$sql="
	update
		otros.generador_abm
	set
		estado=$auxTipo
	where
		id_generador_abm=$idT2
";
$db->set_query($sql);
$db->execute_query();
?>