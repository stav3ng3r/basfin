<?
$campo=recibir_dato('campo');
$detalle=recibir_dato('detalle');
$tipo=recibir_dato('tipo');

$sql="select * from sgp.configuraciones where campo='$campo'";
$db->set_query($sql);
$db->execute_query();
$row=$db->get_array();
$valor=$row['valor'];

if($tipo=='textarea'){
	$input='<textarea id="valorPropiedad" style="width:300px;">'.$valor.'</textarea>';
}else if(substr($tipo,0,11)=='seleccion->'){
	$input='<select id="valorPropiedad">';
	$vSeleccion=explode(',',substr($tipo,11));
	for($i=0;isset($vSeleccion[$i])==true;$i++){
		if($valor==$vSeleccion[$i]){
			$selected='selected';
		}else{
			$selected='';
		}
		$input.='<option value="'.$vSeleccion[$i].'" '.$selected.' >'.$vSeleccion[$i].'</option>';
	}
	$input.='</select>';
}else{
	$input='<input type="text" id="valorPropiedad" value="'.$valor.'">';
}

$resp['html']=str_replace('{campo}',$campo,$resp['html']);
$resp['html']=str_replace('{detalle}',$detalle,$resp['html']);
$resp['html']=str_replace('{input}',$input,$resp['html']);
?>