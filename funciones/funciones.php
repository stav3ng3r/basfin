<?
function valorCampoConfig($campo){
	global $tra, $db4;

	//$sql="select * from sgp.configuraciones where id_sistema=".$tra['id_sistema']." and campo='$campo'";
	$sql="select * from sgp.configuraciones where campo='$campo'";
	$db4->set_query($sql);
	$db4->execute_query();
	$row5=$db4->get_array();
	return $row5['valor'];
}

function denominacionClasificador($clasificador,$campo='denominacion'){
	global $tra, $db4;
	list($tp,$prog,$subprog,$proy,$div5,$div6)=explode('-',$clasificador);
	
	if($tp==''){$tp=0;}
	if($prog==''){$prog=0;}
	if($subprog==''){$subprog=0;}
	if($proy==''){$proy=0;}
	if($div5==''){$div5=0;}
	if($div6==''){$div6=0;}

	if(($tp==0)&&($prog==0)&&($subprog==0)&&($proy==0)&&($div5==0)&&($div6==0)){
		$resultado=valorCampoConfig('entidad');
	}else{
		$sql="
			select
				$campo
			from
				sgp.estructura
			where
				tp=$tp and
				prog=$prog and
				subprog=$subprog and
				proy=$proy and
				div5=$div5 and
				div6=$div6
		";
		
		$db4->set_query($sql);
		$db4->execute_query();
		$row5=$db4->get_array();
		$resultado=$row5[$campo];
	}
	return $resultado;
		
}

function denominacionOg($id_og,$campo='denominacion'){
	global $tra, $db4;
	if($id_og==''){
		return 'Npo hay id_og';
	}else{
		if(isset($gDenominacionOg[$id_og])==false){
			/*
			$sql="
				select 
					$campo 
				from 
					sgp.ogs 
				where 
					id_sistema=".$tra['id_sistema']." and 
					id_og=$id_og
			";
			*/
			
			$sql="
				select 
					$campo 
				from 
					sgp.ogs 
				where 
					id_og=$id_og
			";
			
			$db4->set_query($sql);
			$db4->execute_query();
			$row=$db4->get_array();
			$resultado=$row[$campo] = $row[$campo];
		}
		return $resultado;
	}
}

function denominacionFF($id_ff){
	global $tra, $db4, $gDenominacionFF;
	if($id_ff==''	){
		return 'No hay id_ff';	
	}else{
		if(isset($gDenominacionFF[$id_ff])==false){
			//$sql="select denominacion from sgp.ffs where id_sistema=".$tra['id_sistema']." and id_ff=$id_ff";
			$sql="select denominacion from sgp.ffs where id_ff=$id_ff";
			$db4->set_query($sql);
			$db4->execute_query();
			$row=$db4->get_array();
			$gDenominacionFF[$id_ff]=$row['denominacion'];
		}
		return $gDenominacionFF[$id_ff];
	}
	
}
/*
echo "print tra in fuentestra/funciones/funciones.php: ";
print_r($tra);
*/

/*
echo "print tra in conexion.php: ";
print_r($tra);
*/

/*
	$sql1="
	insert into public.session_data (variable_nombre, variable_valor, id_session_postgre) 
	values 
	(
		'id',
		'" . $tra['bdUsuario'] . "', 
		pg_backend_pid())
	";
	*/
	


$sql=" select * from pg_tables where schemaname='public' and tablename='session_data' ";

$db->set_query($sql);
$db->execute_query();



if ( $row=$db->get_array() and isset($tra['id_usuario']) and $tra['id_usuario']!="") {

	
	//$sql_2="select * from public.usuarios where id_usuario=" . $tra['id_usuario'] . " and id_sistema=".$tra['id_sistema'] . " and estado_login=true";
		$sql_2="select * from public.usuarios where id_usuario=" . $tra['id_usuario'] . " and estado_login=true";
	$db->set_query($sql_2);
	$db->execute_query();
	
	while ( $row=$db->get_array() ) {
			$usuario_actual = $row['usuario'];
	}
	
	if ( !isset( $usuario_actual ) ) {
		  $usuario_actual = "unknown";
	}
	

	
	$sql1="
	insert into public.session_data (variable_nombre, variable_valor, id_session_postgre) 
	values 
	(
		'id',
		'" . $usuario_actual . "', 
		pg_backend_pid())
	";

	$db->set_query($sql1);
	$db->execute_query();
	//echo "inserted id into session_data" . "<br/>";
}

/**
FUNCION PARA CONTAR DIAS
*/
function contador_dias($fecha){
	list($dia,$mes,$ano) = explode('/',$fecha);
	$nuevo_formato_fecha = implode('-',array($ano,$mes,$dia));
	$operacion = floor((time() - strtotime($nuevo_formato_fecha)) / (60 * 60 * 24));
	$contador_dias = $operacion + 1;
	return $contador_dias;
}
/**
*/

function generarAsientoReversion($idAsiento,$detalle,$ctaDebe){
	global $tra, $db4, $resp;
	
	$sql4="
		select
			a.descripcion,
			a.cotizacion,
			d.cuenta_debe,
			d.debe_usd as valor_usd,
			d.debe_gs as valor_gs,
			j.nro_justificacion
		from
			contab.contabilidad_asientos a
			join (
			select
				id_contabilidad_asiento,
				c1 || '.' || c2 || '.' || c3 || '.' || c4 || '.' || c5 || '.' || c6 || '.' || c7 || '.' || c8 || '.' || c9 as cuenta_debe,
				debe_usd,
				debe_gs
			from
				contab.contabilidad_asiento_cuentas
			where
				id_contabilidad_asiento=$idAsiento and
				tipo='D'
			) d on (d.id_contabilidad_asiento=a.id_contabilidad_asiento)
			join contab.justificaciones j on (j.id_justificacion=a.id_justificacion)
		where
			a.id_contabilidad_asiento=$idAsiento

	";
	$db4->set_query($sql4);
	$db4->execute_query();
	$row4=$db4->get_array();

	$ctaDebe='1.2.3.1.'.substr($row4['cuenta_debe'],8);
	$ctaHaber=$row4['cuenta_debe'];
	
	return generarAsiento($fecha,$row4['descripcion'].' - Reversión',$row4['cotizacion'],$row4['valor_gs'],$row4['valor_usd'],$ctaDebe,$ctaHaber,3,$row4['nro_justificacion'],'');
}

function generarAsiento($fecha,$descripcion,$cotizacion,$valorGS,$valorUSD,$ctaDebe,$ctaHaber,$comprobanteTipo,$comprobanteNro,$idComprobantePago,$idReversoDe=''){
	global $tra, $db4, $resp;

	$cuentaD=explode('.',$ctaDebe);
	$cuentaH=explode('.',$ctaHaber);

	for($m=0;$m<=8;$m++){
		if(isset($cuentaD[$m])==false){
			$cuentaD[$m]=0;
		}
		if(isset($cuentaH[$m])==false){
			$cuentaH[$m]=0;
		}
	}

	$sql4="
		select
			denominacion
		from
			contab.contabilidad_cuentas
		where
			c1=".$cuentaD[0]." and 
			c2=".$cuentaD[1]." and 
			c3=".$cuentaD[2]." and 
			c4=".$cuentaD[3]." and 
			c5=".$cuentaD[4]." and 
			c6=".$cuentaD[5]." and 
			c7=".$cuentaD[6]." and 
			c8=".$cuentaD[7]." and 
			c9=".$cuentaD[8]." and 
			afectable=true
	";
	$db4->set_query($sql4);
	$db4->execute_query();
	if(!($row4=$db4->get_array())){
		$resp['mensaje']='No se ha podido confirmar el Comp. de Pago porque la cuenta '.$ctaDebe.' no existe o no es una cuenta afectable dentro del plan de Cuentas';
	}else{
		$sql4="
			select
				denominacion
			from
				contab.contabilidad_cuentas
			where
				c1=".$cuentaH[0]." and 
				c2=".$cuentaH[1]." and 
				c3=".$cuentaH[2]." and 
				c4=".$cuentaH[3]." and 
				c5=".$cuentaH[4]." and 
				c6=".$cuentaH[5]." and 
				c7=".$cuentaH[6]." and 
				c8=".$cuentaH[7]." and 
				c9=".$cuentaH[8]." and 
				afectable=true
		";
		$db4->set_query($sql4);
		$db4->execute_query();
		if(!($row4=$db4->get_array())){
			$resp['mensaje']='No se ha podido confirmar el Comp. de Pago porque la cuenta '.$ctaHaber.' no existe o no es una cuenta afectable dentro del plan de Cuentas';
		}
	}
	if($resp['mensaje']==''){
		$sql4="select max(id_contabilidad_asiento) from contab.contabilidad_asientos";
		$db4->set_query($sql4);
		$db4->execute_query();
		if($row4=$db4->get_array()){
			$idAsiento=$row4['max']+1;
		}else{
			$idAsiento=1;
		}
		
		if($idComprobantePago==''){
			$idComprobantePago='null';
			$justificar='false';
		}else{
			$idComprobantePago="'$idComprobantePago'";	
			$justificar='true';
		}

		if($idReversoDe==''){$idReversoDe='null';}
		
		$sql4="
			insert into contab.contabilidad_asientos(				
				id_contabilidad_asiento,
				fecha,
				descripcion,
				cotizacion,
				comprobante_tipo,
				comprobante_nro,
				justificar,
				id_comprobante_pago,
				reversion_de_asiento
			)values(
				".$idAsiento.",
				'".pasarFormatoBd($fecha)."',
				'".$descripcion."',
				'".$cotizacion."',
				$comprobanteTipo,
				$comprobanteNro,
				$justificar,
				$idComprobantePago,
				$idReversoDe
			)
		";
		$db4->set_query($sql4);
		$db4->execute_query();
		
		$sql4="
			insert into contab.contabilidad_asiento_cuentas(
				id_contabilidad_asiento_cuenta,
				id_contabilidad_asiento,
				tipo,
				c1,
				c2,
				c3,
				c4,
				c5,
				c6,
				c7,
				c8,
				c9,
				observacion,
				cotizacion,
				debe_gs,
				debe_usd,
				haber_gs,
				haber_usd,
				block_gs,
				block_usd
			)values(
				".obtenerSigId('contab.contabilidad_asiento_cuentas').",
				".$idAsiento.",
				'D',
				".$cuentaD[0].",
				".$cuentaD[1].",
				".$cuentaD[2].",
				".$cuentaD[3].",
				".$cuentaD[4].",
				".$cuentaD[5].",
				".$cuentaD[6].",
				".$cuentaD[7].",
				".$cuentaD[8].",
				'',				
				".$cotizacion.",
				$valorGS,
				$valorUSD,
				null,
				null,
				false,
				false
			)
		";
		$db4->set_query($sql4);
		$db4->execute_query();
		
		$sql4="
			insert into contab.contabilidad_asiento_cuentas(
				id_contabilidad_asiento_cuenta,
				id_contabilidad_asiento,
				tipo,
				c1,
				c2,
				c3,
				c4,
				c5,
				c6,
				c7,
				c8,
				c9,
				observacion,
				cotizacion,
				debe_gs,
				debe_usd,
				haber_gs,
				haber_usd,
				block_gs,
				block_usd
			)values(
				".obtenerSigId('contab.contabilidad_asiento_cuentas').",
				".$idAsiento.",
				'H',
				".$cuentaH[0].",
				".$cuentaH[1].",
				".$cuentaH[2].",
				".$cuentaH[3].",
				".$cuentaH[4].",
				".$cuentaH[5].",
				".$cuentaH[6].",
				".$cuentaH[7].",
				".$cuentaH[8].",
				'',				
				".$cotizacion.",
				null,
				null,
				$valorGS,
				$valorUSD,
				false,
				false
			)
		";
		$db4->set_query($sql4);
		$db4->execute_query();
	
		return $idAsiento;
	}else{
		return 0;
	}
	
}
?>