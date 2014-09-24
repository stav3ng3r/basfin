<?php
function pasarFormatoBd($fecha){
	$fecha2=substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2);
	if(strlen($fecha)>10){
		$fecha2.=" ".substr($fecha,11);
	}
	return $fecha2;
}

function compararFechas($primera, $segunda, $separador="/"){
  $valoresPrimera = explode ($separador, $primera);   
  $valoresSegunda = explode ($separador, $segunda); 
  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 
  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];
  
  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    return -1;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    return -1;
  }
  
  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     
  return  $diasPrimeraJuliano - $diasSegundaJuliano;
}

function formatear_fecha($fecha='ahora',$formato='D, d/M/Y H:i *Hs.*'){

	/*
		La fecha debe ser ingresada en el formato YYYY-mm-dd HH:ii:ss
	
		LETRAS PARA FORMATEAR LA FECHA
		-----------------------------------------
		Y	año cuatro digitos
		y	año dos digitos
		m	mes numerico dos digitos
		d	dia numerico dos digitos
		H	hora formato militar dos digitos
		i	minutos dos digitos
		s	segundos dos digitos
		w	dia de la semana domingo = 0, lunes = 1 etc.
		h	hora de 1 a 12
		j	dia solo los digitos que e utilizan
		M	nombre del mes abreviado
		F	nombre del mes
		D	nombre del dia abreviado
		l	nombre del dia
		g	hora solo los digitos que e utilizan formato 12 horas
		G	hora solo los digitos que e utilizan formato 24 horas
		n	numero del mes, solo numeros que se utilizan
		a	am, pm
		A	AM, PM		
		*	Sirve para introducir palabra/letras dentro del formato de fecha sin que estas letras se reemplacen ej. 'l, j *de* F *de* Y - H:i', si no se pone asi la d reemplazaria por el numero de día
	*/

	if($fecha=="ahora"){
		$fecha=date("d-m-Y H:i:s");
	}

	$anho=substr($fecha,6,4);
	$mes=substr($fecha,3,2);
	$dia=substr($fecha,0,2);
	$hora=substr($fecha,11,2);
	$minuto=substr($fecha,14,2);
	$segundo=substr($fecha,17,2);
	$num_dia_de_semana=date("w",mktime(0, 0, 0, $mes, $dia, $anho)); //-- domingo es 0, lunes 1 correspondientemente ....
	
	$fecha_formateada="";
	$interpretar=1;
	for($i=0;$i<strlen($formato);$i++){
		if($formato[$i]=="*"){
			if($interpretar==1){
				$interpretar=0;
			}else{
				$interpretar=1;
			}
		}

		if($interpretar==1){
			$b=0;
			if($formato[$i]=="j"){
				if(substr($dia,0,1)==0){
					$fecha_formateada.=substr($dia,1);
				}else{
					$fecha_formateada.=$dia;
				}
				$b=1;
			}
			if($formato[$i]=="M"){
				$fecha_formateada.=substr(nombre_mes($mes),0,3);
				$b=1;
			}
			if($formato[$i]=="F"){
				$fecha_formateada.=nombre_mes($mes);
				$b=1;
			}
			if($formato[$i]=="Y"){
				$fecha_formateada.=$anho;
				$b=1;
			}
			if($formato[$i]=="y"){
				$fecha_formateada.=substr($anho,2,2);
				$b=1;
			}
			if($formato[$i]=="w"){
				$fecha_formateada.=$num_dia_de_semana;
				$b=1;
			}
			if($formato[$i]=="l"){
				$fecha_formateada.=nombre_dia($num_dia_de_semana);
				$b=1;
			}
			if($formato[$i]=="D"){
				$fecha_formateada.=substr(nombre_dia($num_dia_de_semana),0,3);
				$b=1;
			}
			if($formato[$i]=="g"){
				if($hora>12){
					$aux_hora=$hora-12;
				}else{
					$aux_hora=$hora;
				}
				if(substr($aux_hora,0,1)==0){
					$fecha_formateada.=substr($aux_hora,1);
				}else{
					$fecha_formateada.=$aux_hora;
				}
				$b=1;
			}
			if($formato[$i]=="G"){
				if(substr($hora,0,1)==0){
					$fecha_formateada.=substr($hora,1);
				}else{
					$fecha_formateada.=$hora;
				}
				$b=1;
			}
			if($formato[$i]=="d"){
				$fecha_formateada.=$dia;
				$b=1;
			}
			if($formato[$i]=="H"){
				$fecha_formateada.=$hora;
				$b=1;
			}
			if($formato[$i]=="h"){
				if($hora>12){
					$fecha_formateada.=$hora-12;
				}else{
					$fecha_formateada.=$hora;
				}
				$b=1;
			}
			if($formato[$i]=="m"){
				$fecha_formateada.=$mes;
				$b=1;
			}
			if($formato[$i]=="n"){
				if(substr($mes,0,1)==0){
					$fecha_formateada.=substr($mes,1);
				}else{
					$fecha_formateada.=$mes;
				}
				$b=1;
			}
			if($formato[$i]=="i"){
				$fecha_formateada.=$minuto;
				$b=1;
			}
			if($formato[$i]=="s"){
				$fecha_formateada.=$segundo;
				$b=1;
			}
			if($formato[$i]=="a"){
				if($hora>12){
					$fecha_formateada.="pm";
				}else{
					$fecha_formateada.="am";
				}
				$b=1;
			}
			if($formato[$i]=="A"){
				if($hora>12){
					$fecha_formateada.="PM";
				}else{
					$fecha_formateada.="AM";
				}
				$b=1;
			}
			if($b==0){
				if($formato[$i]!="*"){
					$fecha_formateada.=$formato[$i];
				}
			}
		}else{
			if($formato[$i]!="*"){
				$fecha_formateada.=$formato[$i];
			}
		}
	}

	if($fecha==''){
		$fecha_formateada='';
	}

	return $fecha_formateada;
}

function nombre_mes($num){
	
	if($num==1){$aux="enero";}
	if($num==2){$aux="febrero";}
	if($num==3){$aux="marzo";}
	if($num==4){$aux="abril";}
	if($num==5){$aux="mayo";}
	if($num==6){$aux="junio";}
	if($num==7){$aux="julio";}
	if($num==8){$aux="agosto";}
	if($num==9){$aux="setiembre";}
	if($num==10){$aux="octubre";}
	if($num==11){$aux="noviembre";}
	if($num==12){$aux="diciembre";}
	
	return $aux;
}

function nombre_dia($num){
	
	if($num==0){$nombre="domingo";}
	if($num==1){$nombre="lunes";}
	if($num==2){$nombre="martes";}
	if($num==3){$nombre="miércoles";}
	if($num==4){$nombre="jueves";}
	if($num==5){$nombre="viernes";}
	if($num==6){$nombre="sábado";}
	
	return $nombre;
}

function fecha_mas_fecha($fecha1, $fecha2){
	$resultado="0000-00-00 00:00:00";
	$f1['d']=substr($fecha1,8,2);
	$f1['m']=substr($fecha1,5,2);
	$f1['Y']=substr($fecha1,0,4);
	$f1['H']=substr($fecha1,11,2);
	$f1['i']=substr($fecha1,14,2);
	$f1['s']=substr($fecha1,17,2);
	
	if($f1['d']==""){$f1['d']=0;}
	if($f1['m']==""){$f1['m']=0;}
	if($f1['Y']==""){$f1['Y']=0;}
	if($f1['H']==""){$f1['H']=0;}
	if($f1['i']==""){$f1['i']=0;}
	if($f1['s']==""){$f1['s']=0;}
	
	$valor1=mktime($f1['H'], $f1['i'], $f1['s'], $f1['m'], $f1['d'], $f1['Y']);
	
	return $resultado;
}

function sumaDia($fecha,$dia){
	list($year,$mon,$day) = explode('-',$fecha);
	return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));		
}

function sumaSegundo($segundo, $fechaHora=''){
	if($fechaHora==''){
		$fechaHora=date('Y-m-d H:i:s');
	}
	$fechaHora=str_replace(' ','-',$fechaHora);
	$fechaHora=str_replace(':','-',$fechaHora);
	list($year,$mon,$day,$hora,$min,$seg) = explode('-',$fechaHora);
	$nuevoTiempo=mktime($hora,$min,$seg+$segundo,$mon,$day,$year);
	return date('Y-m-d H:i:s',$nuevoTiempo);
}

function ultimoDiaMes($mes){
	if($mes==1){$ultDia=31;}
	if($mes==2){$ultDia=28;}
	if($mes==3){$ultDia=31;}
	if($mes==4){$ultDia=30;}
	if($mes==5){$ultDia=31;}
	if($mes==6){$ultDia=30;}
	if($mes==7){$ultDia=31;}
	if($mes==8){$ultDia=31;}
	if($mes==9){$ultDia=30;}
	if($mes==10){$ultDia=31;}
	if($mes==11){$ultDia=30;}
	if($mes==12){$ultDia=31;}
	return $ultDia;
}

function sumarFecha($fecha,$habiles,$dias){
	if($fecha=='')
		return;
	if($dias=='')
		$dias=0;
		
	$res=array();
	$ofecha=getdate();
	
	$fechaArr=explode('/',$fecha);
	$iax=$fechaArr[2];
	$imx=$fechaArr[1];
	$idx=$fechaArr[0];
	
	//die('->'.$idx.' | '.date('t',mktime(0,0,0,$imx,1,$iax)));
	
	$cdias=0;
	while($cdias<$dias){
		$idx=$idx+1;
		
		$tmp=date('t',mktime(0,0,0,$imx,1,$iax));
		if($idx>$tmp){
			$imx=$fechaArr[1]+1;
			if($imx>12){
				$imx=1;
				$iax++;
			}

			$dias_mes=date('t',mktime(0,0,0,$imx,1,$iax));
			$idx=1;
		}
		$dia=getdate(mktime(0,0,0,$imx,$idx,$iax));
		
		if($habiles==false){
			$cdias++;
		}else{
			//domingo = 0
			if($dia['wday']>0&&$dia['wday']<6){
				$cdias++;
			}
		}
	}
	if(strlen($idx)==1)
		$idx='0'.$idx;
	if(strlen($imx)==1)
		$imx='0'.$imx;
	return $idx.'/'.$imx.'/'.$iax;
}

function restarFecha($fecha,$habiles,$dias){
	if($fecha=='')
		return;
	if($dias=='')
		$dias=0;
		
	$res=array();
	$ofecha=getdate();
	
	$fechaArr=explode('/',$fecha);
	$iax=$fechaArr[2];
	$imx=$fechaArr[1];
	$idx=$fechaArr[0];
	
	//die('->'.$idx.' | '.date('t',mktime(0,0,0,$imx,1,$iax)));
	
	$cdias=$dias;
	while($cdias>0){
		$idx=$idx-1;
		
		if($idx==0){
			$imx=$fechaArr[1]-1;
			if($imx==0){
				$imx=12;
				$iax--;
			}
			$ofecha=getdate();
			
			$a=date('t',mktime(0,0,0,$imx,1,$iax));
			
			$dias_mes=date('t',mktime(0,0,0,$imx,1,$iax));
			$idx=$dias_mes;
		}
		$dia=getdate(mktime(0,0,0,$imx,$idx,$iax));
		
		if($habiles==false){
			$cdias--;
		}else{
			//domingo = 0
			if($dia['wday']>0&&$dia['wday']<6){
				$cdias--;
			}
		}
	}
	if(strlen($idx)==1)
		$idx='0'.$idx;
	if(strlen($imx)==1)
		$imx='0'.$imx;
	return $idx.'/'.$imx.'/'.$iax;
}


function calcularEdad($fechaNac){
	$edad='';
	if($fechaNac!=''){
		$edad=date('Y')-substr($fechaNac,6,4);
		// 20-11-1985
		// 0123456789
		if(substr($fechaNac,3,2)>date('m')){
			$edad--;
		}else if(substr($fechaNac,3,2)==date('m')){
			if(substr($fechaNac,0,2)>date('d')){
				$edad--;
			}else if(substr($fechaNac,0,2)==date('d')){
				$edad='<b>'.$edad.' !</b>';
			}
		}
	}
	
	return $edad;	
}
?>