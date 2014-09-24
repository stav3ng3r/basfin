<?
if($accionRPC=='agregar'){
	$proceso = recibir_dato('proceso');
	$bandera = recibir_dato('bandera');
	$resultado = recibir_dato('resultado');
	debug($proceso,$bandera,$resultado,'js');
}
?>