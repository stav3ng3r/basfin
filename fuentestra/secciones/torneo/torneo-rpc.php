<?
if($accionRPC=='cargarTablaPuntosEdicion'){
	$idTorneo=recibir_dato('idTorneo');
	$resp['html']=leerHtmlEnSeccion('formato-editar-puntos-tabla').chr(13);
	$htmlFilas='';
	$formatoFila=leerHtmlEnSeccion('formato-editar-puntos-fila').chr(13);
	$sql="
		select
			ptos.*,
			eq.equipo,
			arch.referencia as logo
		from
			torneo.puntos ptos
			join torneo.equipos eq on (ptos.id_sistema=eq.id_sistema and ptos.id_equipo=eq.id_equipo)
			join archivos arch on (eq.id_sistema=arch.id_sistema and eq.id_archivo=arch.id_archivo)
		where
			ptos.id_sistema=".$tra['id_sistema']." and 
			id_torneo=$idTorneo
		order by
			ptos.puntos desc
		
	";
	$db->set_query($sql);
	$db->execute_query();
	$c=0;
	while($row=$db->get_array()){
		$c++;
		$htmlFilas.=$formatoFila;
		$logo='<img src="index.php?o=ima&archivo='.$row['logo'].'&tipo=2&ancho=16&alto=16&alinear=c">';
		$htmlFilas=str_replace('{pos}',$c,$htmlFilas);
		$htmlFilas=str_replace('{idPunto}',$row['id_punto'],$htmlFilas);
		$htmlFilas=str_replace('{logo}',$logo,$htmlFilas);
		$htmlFilas=str_replace('{equipo}',$row['equipo'],$htmlFilas);
		$htmlFilas=str_replace('{puntos}',$row['puntos'],$htmlFilas);
		$htmlFilas=str_replace('{pj}',$row['pj'],$htmlFilas);
		$htmlFilas=str_replace('{pg}',$row['pg'],$htmlFilas);
		$htmlFilas=str_replace('{pp}',$row['pp'],$htmlFilas);
		$htmlFilas=str_replace('{pe}',$row['pe'],$htmlFilas);
		$htmlFilas=str_replace('{gf}',$row['gf'],$htmlFilas);
		$htmlFilas=str_replace('{gc}',$row['gc'],$htmlFilas);
	}
	$resp['html']=str_replace('{filas}',$htmlFilas,$resp['html']);
}

if($accionRPC=='editarPuntos'){
	$idPunto=recibir_dato('idPunto');
	$puntos=recibir_dato('puntos');
	$pj=recibir_dato('pj');
	$pg=recibir_dato('pg');
	$pp=recibir_dato('pp');
	$pe=recibir_dato('pe');
	$gf=recibir_dato('gf');
	$gc=recibir_dato('gc');
	if($puntos==''){$puntos=0;}
	if($pj==''){$pj=0;}
	if($pg==''){$pg=0;}
	if($pp==''){$pp=0;}
	if($pe==''){$pe=0;}
	if($gf==''){$gf=0;}
	if($gc==''){$gc=0;}
	$sql="
		update
			torneo.puntos
		set
			puntos = $puntos,
			pj = $pj,
			pg = $pg,
			pp = $pp,
			pe = $pe,
			gf = $gf,
			gc = $gc
		where
			id_sistema = ".$tra['id_sistema']." and
			id_punto = $idPunto
	";
	$db->set_query($sql);
	$db->execute_query();
}

if($accionRPC=='cargarTablaPuntos'){
	$idTorneo=recibir_dato('idTorneo');
	$resp['html']=leerHtmlEnSeccion('formato-puntos-tabla').chr(13);
	$htmlFilas='';
	$formatoFila=leerHtmlEnSeccion('formato-puntos-fila').chr(13);
	$sql="
		select
			ptos.*,
			eq.equipo,
			arch.referencia as logo
		from
			torneo.puntos ptos
			join torneo.equipos eq on (ptos.id_sistema=eq.id_sistema and ptos.id_equipo=eq.id_equipo)
			join archivos arch on (eq.id_sistema=arch.id_sistema and eq.id_archivo=arch.id_archivo)
		where
			ptos.id_sistema=".$tra['id_sistema']." and 
			id_torneo=$idTorneo
		order by
			ptos.puntos desc
		
	";
	$db->set_query($sql);
	$db->execute_query();
	$c=0;
	while($row=$db->get_array()){
		$c++;
		$htmlFilas.=$formatoFila;
		$logo='<img src="index.php?o=ima&archivo='.$row['logo'].'&tipo=2&ancho=22&alto=22&alinear=c">';
		$htmlFilas=str_replace('{pos}',$c,$htmlFilas);
		$htmlFilas=str_replace('{logo}',$logo,$htmlFilas);
		$htmlFilas=str_replace('{equipo}',$row['equipo'],$htmlFilas);
		$htmlFilas=str_replace('{puntos}',$row['puntos'],$htmlFilas);
		$htmlFilas=str_replace('{pj}',$row['pj'],$htmlFilas);
		$htmlFilas=str_replace('{pg}',$row['pg'],$htmlFilas);
		$htmlFilas=str_replace('{pp}',$row['pp'],$htmlFilas);
		$htmlFilas=str_replace('{pe}',$row['pe'],$htmlFilas);
		$htmlFilas=str_replace('{gf}',$row['gf'],$htmlFilas);
		$htmlFilas=str_replace('{gc}',$row['gc'],$htmlFilas);
		$htmlFilas=str_replace('{s}',$row['gf']-$row['gc'],$htmlFilas);
	}
	$resp['html']=str_replace('{idTorneo}',$idTorneo,$resp['html']);
	$resp['html']=str_replace('{refrescarEn}',recibir_dato('refrescarEn'),$resp['html']);	
	$resp['html']=str_replace('{filas}',$htmlFilas,$resp['html']);
}
?>